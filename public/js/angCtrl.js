/**
 * SIG Controler
 *
 * @author Robert Barczyk <robert@barczyk.net>
 * @param {storage} $localStorage
 * @param {$http} $http
 */
angular.module('ukfn')
        .controller('sigController', function ($http, $localStorage) {
            // no undeclared variables

            // this scope name
            var controller = this;
            controller.GOOGLE_API = "AIzaSyBfPzqmEJJdLfOXiaoTeGfSH2qDyxrIoD4";
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
        controller.addMember = function(userId, sigMain = -1)
        {
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

/**
 * Talks Controler
 *
 * @author Robert Barczyk <robert@barczyk.net>
 * @param {storage} $localStorage
 * @param {$http} $http
 */
angular.module('ukfn')
    .controller('talksController', function ($http, $localStorage, $sce) {
        // this scope name
        var controller = this;
        controller.$storage = $localStorage;
        controller.searchTerms = []; // terms entered in recorded search box
        controller.selectedAggregators = []; // aggregators selected in past filter
        controller.aggregators = []; // aggregators given as options
        controller.loading = true; // flag to display loading message
        controller.query = ""; // future/recorded/past
        controller.currentQuery = ""; // current selected query
        controller.showframe = [];

        controller.updateQuery = function(query) {
            controller.query = query;
            if (controller.currentQuery !== controller.query) {
                controller.aggregators = [];
                controller.searchTerms = [];
                controller.selectedAggregators = [];
                controller.currentQuery = controller.query;
            }
            controller.loadTalks();
        };

        controller.loadTalks = function() {
            var lookup = [];
            var url = '/api/talks/' + controller.query;
            controller.loading = true;
            // clear array of available talks before making the request.
            controller.talks = [];

            $http(
                {
                    method: 'GET',
                    url: url,
                    params: {
                        feeds: JSON.stringify(controller.selectedAggregators),
                        search: JSON.stringify(controller.searchTerms)
                    }
                }
            ).then(function (response) {
                controller.loading = false;
                controller.talks = response.data;
                // get uniqe aggregators for this set of talks
                for (var i = 0; i < controller.talks.length; i++)  {
                    if (controller.talks[i].aggregator !== null) {
                        var aggregator = controller.talks[i].aggregator.name;
                        var aggregatorId = controller.talks[i].aggregator.id;
                        if (!(aggregator in lookup)) {
                            lookup[aggregator] = true;
                            controller.aggregators.push({id: aggregatorId, label: aggregator});
                        }
                    }

                    if (controller.talks[i].recordingurl) {
                        controller.talks[i].recordingurl = $sce.trustAsResourceUrl(controller.talks[i].recordingurl);
                    }
                    if (controller.talks[i].streamingurl) {
                        controller.talks[i].streamingurl = $sce.trustAsResourceUrl(controller.talks[i].streamingurl);
                    }
                }
            });
        };
        
        controller.selectizeSeriesConfig = {
            create: false,
            plugins: ['remove_button'],
            delimiter: ',',
            searchField: 'label',
            framework: 'bootstrap',
            valueField: 'id',
            labelField: 'label',
            placeholder: 'Select series'
          };

        controller.selectizeSearchConfig = {
            create: true,
            plugins: ['remove_button'],
            delimiter: ',',
            searchField: 'label',
            framework: 'bootstrap',
            valueField: 'id',
            labelField: 'label',
            placeholder: 'Enter search term(s)'
          };
    });

/**
 * Talks Controler
 *
 * @author Javier Arias <javier@arias.re>
 * @param {storage} $localStorage
 * @param {$http} $http
 */
angular.module('ukfn').config(function($sceDelegateProvider) {
 $sceDelegateProvider.resourceUrlWhitelist([
   // Allow same origin resource loads.
   'self',
   // Allow loading from our assets domain.  Notice the difference between * and **.
   'http://sms.cam.ac.uk/**']);
 });
 
angular.module('ukfn')
    .controller('resourcesController', function ($http, $localStorage, $sce) {
        // this scope name
        var controller = this;
        controller.$storage = $localStorage;
        controller.disciplines = []; // disciplines for selectize
        controller.categories = []; // discipline categories for selectize optgroup
        controller.searchTerms = []; // terms entered in recorded search box
        controller.types = {
            Notes: true,
            Code: true,
            Slides: true,
            Audio: true,
            Video: true
        };
        controller.icons = {
            Notes: "glyphicon-file",
            Code: "glyphicon-console",
            Slides: "glyphicon-blackboard",
            Audio: "glyphicon-headphones",
            Video: "glyphicon-film"
        };

        controller.loading = true; // flag to display loading message

        controller.updateQuery = function(query) {
            controller.loadResources();
        };

        controller.loadDisciplines = function() {
            var url = '/api/tags/disciplines';
            controller.disciplines = [];

            $http({method: 'GET', url: url}).then(function (response) {
                var curCategory = ""
                for (var i = 0; i < response.data.length; i++)  {
                    var category = response.data[i].category;
                    if (category !== curCategory) {
                        controller.categories.push({'category': category});
                        curCategory = category;
                    }
                }
                controller.disciplines = response.data;
            });
        };

        controller.loadResources = function() {
            var url = '/api/resources/';
            controller.loading = true;
            // clear array of available resources before making the request.
            controller.resources = [];

            $http(
                {
                    method: 'GET',
                    url: url,
                    params: {
                        types: JSON.stringify(controller.types),
                        search: JSON.stringify(controller.searchTerms)
                    }
                }
            ).then(function (response) {
                controller.loading = false;
                controller.resources = response.data;
            });
        };
        
        controller.isUrl = function(s) {
            var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
            return regexp.test(s);
        };
        
        controller.isPdf = function(s) {
            return s.includes(".pdf");
        };

        controller.selectizeDisciplinesConfig = {
            create: false,
            plugins: ['remove_button', 'optgroup_columns'],
            delimiter: ',',
            searchField: 'name',
            framework: 'bootstrap',
            valueField: 'id',
            labelField: 'name',
            optgroupField: 'category',
            optgroupLabelField: 'category',
            optgroupValueField: 'category',
            optgroups: controller.categories,
            placeholder: 'Enter subject area(s)'
          };
    });