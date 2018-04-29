angular.module('ukfn')
    .controller('directoryController', function ($http, $localStorage, $sce) {
        var controller = this;
        controller.GOOGLE_API = "AIzaSyBfPzqmEJJdLfOXiaoTeGfSH2qDyxrIoD4";
        controller.MAPS_API_URL = "https://maps.google.com/maps/api/js";
        controller.MAPS_API_KEY = "AIzaSyBARkpTMK_9AmqRV967Lrjtx3UUkZrp_HI";
        controller.MAP_URL = controller.MAPS_API_URL
                             + "?key="
                             + controller.MAPS_API_KEY;
        controller.$storage = $localStorage;
        controller.searchTerms = []; // terms entered in recorded search box
        controller.loading = true; // flag to display loading message

        controller.initialise = function() {
            controller.loadUsers();
        };

        controller.updateQuery = function(query) {
            controller.loadUsers();
        };

        controller.loadUsers = function() {
            var url = '/api/public/users/';
            var query = JSON.stringify(controller.searchTerms);
            controller.loading = true;

            // clear array of available users before making the request.
            controller.users = [];
            $http(
                {
                    method: 'GET',
                    url: url,
                    params: {
                        search: query
                    }
                }
            ).then(function (response) {
                controller.users = response.data;
                controller.loading = false;

                // prepare array with institutions only
                var institutions = [];

                for(i=0; i<response.data.length; i++) {
                    if (typeof response.data[i].institutions !== 'undefined') {
                        for (z=0; z <response.data[i].institutions.length; z++) {
                            institutions.push(response.data[i].institutions[z]);
                        }
                    }
                }

                // get unique institutions
                var all = [];
                var output = [];
                for (x=0; x<institutions.length;x++) {
                    if(all[institutions[x].id]) continue;
                    all[institutions[x].id] = true;
                    output.push(institutions[x]);
                }
                // return unique institutions
                controller.distinctInstitutions = output;
            });
          };

        controller.tagSelected = function(tag_id) {
            for (var i=0; i < controller.searchTerms.length; i++) {
                if (controller.searchTerms[i] == tag_id) {
                    return true;
                }
            }
            return $.inArray(tag_id, controller.searchTerms) > -1;
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
    });
