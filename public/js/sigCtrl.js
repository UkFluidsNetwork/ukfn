angular.module('ukfn')
        .controller('sigController', function ($http, $localStorage) {
            // this scope name
            var controller = this;
            controller.GOOGLE_API = "AIzaSyBfPzqmEJJdLfOXiaoTeGfSH2qDyxrIoD4";
            controller.MAPS_API_URL = "https://maps.google.com/maps/api/js";
            controller.MAPS_API_KEY = "AIzaSyBARkpTMK_9AmqRV967Lrjtx3UUkZrp_HI";
            controller.MAP_URL = controller.MAPS_API_URL
                                 + "?key="
                                 + controller.MAPS_API_KEY;
            controller.$storage = $localStorage;
            controller.selectedSigId = null; // initially selected SIG

            (function() {
                $http(
                    {
                        method: 'GET',
                        url: '/api/sigs'
                    }
                ).then(function (response) {

                    // get all SIGs and their institutions
                    controller.allSigs = response;

                    // prepare array with institutions only
                    var sigInstitutions = [];

                    for(i=0; i<response.data.length; i++) {
                        if (typeof response.data[i].institutions !== 'undefined') {
                            for (z=0; z <response.data[i].institutions.length; z++) {
                                sigInstitutions.push(response.data[i].institutions[z]);
                            }
                        }
                    }

                    // get unique institutions
                    var all = [];
                    var output = [];
                    for (x=0; x<sigInstitutions.length;x++) {
                        if(all[sigInstitutions[x].id]) continue;
                        all[sigInstitutions[x].id] = true;
                        output.push(sigInstitutions[x]);
                    }
                    // tell ng repeat to display it
                    controller.displayAll = true;
                    // return unique institutions
                    controller.distinctInstitutions = output;

                    // check if we want to display a specific sig
                    if (controller.selectedSigId) {
                        controller.setActive(controller.selectedSigId);
                        controller.getSig(controller.selectedSigId);
                    }
                });
            })();

            /**
             * Get selected sig and its institutions
             *
             * @author Robert Barczyk <robert@barczyk.net>
             * @param {intiger} id
             * @returns {json}
             */
            controller.getSig = function (id) {
                $http(
                    {
                        method: 'GET',
                        url: '/api/sigs/'+id
                    }
                ).then(function (response) {
                    controller.displayAll = false;
                    controller.thisSig = response;
                });
            };


        /**
         * Set active sig on sig map
         *
         * @author Robert Barczyk <robert@barczyk.net>
         * @param {type} id
         * @returns {undefined}
         */
        controller.setActive = function(id) {
            controller.sigActive = id;
        };

        /**
         * Display all sigs on sig map
         *
         * @author Robert Barczyk <robert@barczyk.net>
         * @returns {undefined}
         */
        controller.dispAll = function() {
            controller.displayAll = true;
        };

        // default UK map coordinates
        controller.map =
                {
                    'latitude'  : '54.8',
                    'longtitude': '-4.40'
                };
        controller.map.coordinates = controller.map.latitude
                                    + ", " + controller.map.longtitude;

        // map options
        controller.options = {
            styles: [
                {
                    "featureType":"administrative",
                    "elementType":"all",
                    "stylers":[
                        {"saturation":"-100"}
                    ]
                },
                {
                    "featureType":"administrative.province",
                    "elementType":"all",
                    "stylers":[{"visibility":"off"}]
                },
                {
                    "featureType":"landscape",
                    "elementType":"all",
                    "stylers":[
                        {"saturation":-100},
                        {"lightness":65},
                        {"visibility":"on"}
                    ]
                },
                {
                    "featureType":"poi",
                    "elementType":"all",
                    "stylers":[
                        {"saturation":-100},
                        {"lightness":"50"},
                        {"visibility":"simplified"}
                    ]
                },
                {
                    "featureType":"road",
                    "elementType":"all",
                    "stylers":[{"saturation":"-100"}]
                },
                {
                    "featureType":"road.highway",
                    "elementType":"all",
                    "stylers":[{"visibility":"simplified"}]
                },
                {
                    "featureType":"road.arterial",
                    "elementType":"all",
                    "stylers":[{"lightness":"30"}]
                },
                {
                    "featureType":"road.local",
                    "elementType":"all",
                    "stylers":[{"lightness":"40"}]
                },
                {
                    "featureType":"transit",
                    "elementType":"all",
                    "stylers":[
                        {"saturation":-100},
                        {"visibility":"simplified"}
                    ]
                },
                {
                    "featureType":"water",
                    "elementType":"geometry",
                    "stylers":[
                        {"hue":"#ffff00"},
                        {"lightness":-25},
                        {"saturation":-97}
                    ]
                },
                {
                    "featureType":"water",
                    "elementType":"labels",
                    "stylers":[
                        {"lightness":-25},
                        {"saturation":-100}
                    ]
                }
            ]
        };

        // Edit Sig //-> BEGIN
        controller.ukfnUsers = [];
        controller.thisMembers = [];
        controller.addMemberSearch = '';

        // used in select
        controller.sigMemebrships = [
            {name: "Member", id: 0, seleted: true},
            {name: "Leader", id: 1},
            {name: "Co-Leader", id: 2},
            {name: "Key personel", id: 3}
        ];

        // translate membership code to string
        controller.getMemberStatus = function(id)
        {
            switch(id) {
                case 1:
                    return "Leader";
                    break;
                case 2:
                    return "Co-Leader";
                    break;
                case 3:
                    return "Key personel";
                    break;
                case 0:
                    return "Member";
            };
        };

        // initialise two arays with users when page load
        controller.loadUsers = function() {
            controller.loadSigMembers();
            controller.loadAllUsers();
        };

        /**
         * Load this sig members
         *
         * @returns {void}  Sets array thisMembers
         */
        controller.loadSigMembers = function() {
            $http(
                    {
                        method: 'GET',
                        url: '/api/sig/members/' + controller.selectedSigId
                    }
                ).then(function (response) {
                    controller.thisMembers = response.data;
                });
        };

        /**
         * Load all UKFN users, unset the ones that are already a member of this sig
         *
         * @returns {void}
         */
        controller.loadAllUsers = function() {
            controller.ukfnUsers = [];
            $http(
                    {
                        method: 'GET',
                        url: '/api/users'
                    }
                ).then(function (response) {
                    var users = response.data;
                    // for each ukfn user
                    for (var i = 0; i < users.length; i++) {
                        var existing = controller.belongsToSig(users[i].id);
                        // if thgis user is not not a member of this sig add him to all users list
                        if (!existing) {
                            // at his default property for not associated memebrs
                            users[i].selected = 0;
                            controller.ukfnUsers.push(users[i]);
                        }
                    }
                });
        };

        controller.belongsToSig = function(userId)
        {
            var existing = false;
            if (controller.thisMembers.length !== 0) {
                for (var i =0; i< controller.thisMembers.length; i++) {
                    if(userId === controller.thisMembers[i].id) {
                        existing = true;
                        break;
                    }
                }
            }

            return existing;
        };

        /**
         * Add selected user to this sig + set membership
         *
         * @param {int} userId
         * @param {int} sigMain
         * @returns {void}
         */
        controller.addMember = function(userId, sigMain)
        {
            sigMain = typeof sigMain !== 'undefined' ? sigMain : -1;
            // if not membership is selected terminate
            if (sigMain === -1) {return;}

            var existing = controller.belongsToSig(userId);

            if (!existing) {
                $http({
                    method : 'POST',
                    url: '/sig/members/add/' + controller.selectedSigId,
                    data: {
                        user_id: userId,
                        main: sigMain
                    }
                })
                .success(function(){
                    controller.loadUsers();
                });

                // reset search
                controller.addMemberSearch = '';
            }
        };

        controller.updateMember = function(userId, sigMain)
        {
            $http({
                method : 'POST',
                url: '/sig/members/update/' + controller.selectedSigId,
                data: {
                    user_id: userId,
                    main: sigMain
                }
            })
            .success(function(){
                controller.loadUsers();
            });
        };

        /**
         * Delete this user from this sig
         *
         * @param {int} userId
         * @returns {void}
         */
        controller.deleteMember = function(userId)
        {
            $http({
                method : 'POST',
                url: '/sig/members/delete/' + controller.selectedSigId,
                data: {
                    user_id: userId
                }
            })
            .success(function(){
                controller.loadUsers();
            });
        };
    });
