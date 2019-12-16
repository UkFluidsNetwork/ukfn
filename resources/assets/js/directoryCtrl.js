angular.module('ukfn')
    .controller('directoryController', function ($http, $localStorage, $sce, NgMap) {
        var controller = this;
        controller.GOOGLE_API = "AIzaSyBfPzqmEJJdLfOXiaoTeGfSH2qDyxrIoD4";
        controller.MAPS_API_URL = "https://maps.google.com/maps/api/js";
        controller.MAPS_API_KEY = "AIzaSyBARkpTMK_9AmqRV967Lrjtx3UUkZrp_HI";
        controller.MAP_URL = controller.MAPS_API_URL +
            "?key=" +
            controller.MAPS_API_KEY;
        controller.$storage = $localStorage;
        controller.searchTerms = []; // terms entered in recorded search box
        controller.loading = true; // flag to display loading message
        controller.totalDisplayed = 25;
        controller.institutions = [];
        controller.searchInsts = [];

        controller.initialise = function () {
            controller.loadInstitutions();
            controller.loadUsers();
            controller.loadTags();
            controller.loadSigs();
        };

        controller.updateQuery = function (query) {
            controller.loadUsers();
            controller.loadInstitutions();
            controller.loadTags();
        };

        controller.searchInst = function (self, inst_id) {
            if (controller.searchInsts.includes('inst' + inst_id)) {
                index = controller.searchInsts.indexOf('inst' + inst_id);
                controller.searchInsts.splice(index, 1);
            } else {
                controller.searchInsts.push('inst' + inst_id);
            }
            controller.updateQuery();
        };

        controller.loadMore = function (more) {
            controller.totalDisplayed += more;
        };

        controller.loadAll = function () {
            controller.totalDisplayed = controller.users.length;
        };

        controller.allDisplayed = function () {
            return controller.totalDisplayed >= controller.users.length;
        };

        controller.compileSearch = function () {
            var res = controller.searchTerms.concat(controller.searchInsts);
            return JSON.stringify(res);
        };

        controller.loadUsers = function () {
            var url = '/api/public/users/';
            var query = controller.compileSearch();
            controller.loading = true;

            // clear array of available users before making the request.
            controller.users = [];
            $http({
                method: 'GET',
                url: url,
                params: {
                    search: query
                }
            }).then(function (response) {
                controller.users = response.data;
                controller.loading = false;
            });
        };

        controller.loadInstitutions = function () {
            var institutions_url = '/api/public/users/institutions/';
            var query = controller.compileSearch();
            $http({
                method: 'GET',
                url: institutions_url,
                params: {
                    search: query
                }
            }).then(function (response) {
                controller.distinctInstitutions = response.data;
                angular.forEach(controller.distinctInstitutions,
                    function (value, key) {
                        var arr = {
                            id: "inst" + key,
                            name: value.name
                        };
                        controller.institutions.push(arr);
                    });
            });
        };

        controller.loadTags = function () {
            var tags_url = '/api/tags/all/';
            $http({
                method: 'GET',
                url: tags_url
            }).then(function (response) {
                controller.tags = response.data;
            });
        };

        controller.loadSigs = function () {
            var sigs_url = '/api/sigs/';
            $http({
                method: 'GET',
                url: sigs_url
            }).then(function (response) {
                controller.sigs = response.data;
            });
        };

        controller.tagClicked = function (tag) {
            if (controller.searchTerms.includes('tag' + tag.id)) {
                index = controller.searchTerms.indexOf('tag' + tag.id);
                controller.searchTerms.splice(index, 1);
            } else {
                controller.searchTerms.push('tag' + tag.id);
            }
            controller.updateQuery();
        };

        controller.tagSelected = function (tag_id) {
            for (var i = 0; i < controller.searchTerms.length; i++) {
                if (controller.searchTerms[i] == tag_id) {
                    return true;
                }
            }
            return $.inArray(tag_id, controller.searchTerms) > -1;
        };

        controller.instSelected = function (institution_id) {
            for (var i = 0; i < controller.searchTerms.length; i++) {
                if (controller.searchInsts[i] == institution_id) {
                    return true;
                }
            }
            return $.inArray(institution_id, controller.searchInsts) > -1;
        };

        // default UK map coordinates
        controller.map = {
            'latitude': '54.8',
            'longtitude': '-4.40'
        };
        controller.map.coordinates = controller.map.latitude +
            ", " + controller.map.longtitude;

        // map options
        controller.options = {
            styles: [{
                    "featureType": "administrative",
                    "elementType": "all",
                    "stylers": [{
                        "saturation": "-100"
                    }]
                },
                {
                    "featureType": "administrative.province",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "off"
                    }]
                },
                {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [{
                            "saturation": -100
                        },
                        {
                            "lightness": 65
                        },
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [{
                            "saturation": -100
                        },
                        {
                            "lightness": "50"
                        },
                        {
                            "visibility": "simplified"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [{
                        "saturation": "-100"
                    }]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "simplified"
                    }]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "all",
                    "stylers": [{
                        "lightness": "30"
                    }]
                },
                {
                    "featureType": "road.local",
                    "elementType": "all",
                    "stylers": [{
                        "lightness": "40"
                    }]
                },
                {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [{
                            "saturation": -100
                        },
                        {
                            "visibility": "simplified"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [{
                            "hue": "#ffff00"
                        },
                        {
                            "lightness": -25
                        },
                        {
                            "saturation": -97
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "labels",
                    "stylers": [{
                            "lightness": -25
                        },
                        {
                            "saturation": -100
                        }
                    ]
                }
            ]
        };

        controller.selectizeInstConfig = {
            create: false,
            plugins: ['remove_button'],
            delimiter: ',',
            searchField: 'name',
            framework: 'bootstrap',
            valueField: 'id',
            labelField: 'name',
            placeholder: 'Institution(s)'
        };
    });