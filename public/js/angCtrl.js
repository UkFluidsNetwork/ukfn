/**
 * SIG Controler
 * 
 * @author Robert Barczyk <robert@barczyk.net>
 * @param {storage} $localStorage 
 * @param {$http} $http
 */
angular.module('ukfn')
    .controller('sigController', function ($http, $localStorage) {
        // this scope name
        var controller = this;
        controller.GOOGLE_API = "AIzaSyBfPzqmEJJdLfOXiaoTeGfSH2qDyxrIoD4";
        controller.$storage = $localStorage;

        /**
         * Get all sig and their linked institutions
         * 
         * @author Robert Barczyk <robert@barczyk.net>
         * @returns {undefined}
         */
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

                for (var i = 0; i < response.data.length; i++) {
                    if (typeof response.data[i].institutions !== 'undefined') {
                        for (var z = 0; z < response.data[i].institutions.length; z++) {
                            sigInstitutions.push(response.data[i].institutions[z]);
                        }
                    }
                }

                // get unique institutions
                var all = [];
                var output = [];
                for (var x = 0; x < sigInstitutions.length; x++) {
                    if(all[sigInstitutions[x].id]) continue;
                    all[sigInstitutions[x].id] = true;
                    output.push(sigInstitutions[x]);
                }
                // tell ng repeat to display it
                controller.displayAll = true;
                // return unique institutions
                controller.distinctInstitutions = output;
            });
        })();

        /**
         * Get selected sig and its institutions
         * 
         * @author Robert Barczyk <robert@barczyk.net>
         * @param {intiger} id
         * @returns {json}
         */
        controller.getSigInstitution = function (id) {
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
    });

/**
 * Talks Controler
 * 
 * @author Robert Barczyk <robert@barczyk.net>
 * @param {storage} $localStorage 
 * @param {$http} $http
 */
angular.module('ukfn')
    .controller('talksController', function ($http, $localStorage) {
        // this scope name
        var controller = this;
        controller.$storage = $localStorage;

        // filter types
        controller.filterAggregators = [];
        controller.types = 
                {
                    'Recording': false, 
                    'Streaming': false
                };

        // aggregators for this talks set
        controller.thisAggregators = [];

        /**
         * Get all future talks
         * 
         * @author Robert Barczyk <robert@barczyk.net>  
         * @returns {json}
         */
        (function () {
            $http(
                {
                    method: 'GET',
                    url: '/api/talks'
                }
            ).then(function (response) {
                controller.talks = response.data;

                var lookup = {};

                // get uniqe aggregators for this set of talks
                for (var i = 0; i < controller.talks.length; i++)  {
                    var aggregator = controller.talks[i].longname;
                    if (!(aggregator in lookup)) {
                        lookup[aggregator] = true;
                        controller.filterAggregators.push(aggregator);
                        controller.thisAggregators.push(aggregator);
                    }                        
                }
            });
        })();


        /**
         * Update list of aggragators used for litering, extracted from this talk set 
         * 
         * @author Robert Barczyk <robert@barczyk.net>
         * @param {string} value
         * @returns {void}
         */
        controller.updateFilterAggregators = function(value) {
            var index = controller.filterAggregators.indexOf(value);
            if (index > -1) {
                controller.filterAggregators.splice(index, 1);
            } else {
                controller.filterAggregators.push(value);
            }
        };
    });

/**
 * Talks filter
 * @author Robert Barczyk <robert@barczyk.net>
 */
angular.module('ukfn').filter('allTalksFilter', function() {
    /**
     * Filter all talks
     * 
     * @author Robert Barczyk <robert@barczyk.net>
     * @param {array} items
     * @param {object} types
     * @param {array} thisAggregators
     * @returns {array}
     */
    return function( items, types, thisAggregators) {
        var filtered = [];
    
        angular.forEach(items, function(item) {
            if (!types['Recording'] && item.displayRecording === true && types['Streaming'] && thisAggregators.indexOf(item.longname) !== -1) {
                filtered.push(item);
            } 
            
            if (!types['Streaming'] && item.displayStreaming === true && types['Recording'] && thisAggregators.indexOf(item.longname) !== -1) {
                filtered.push(item);
            }
            
            if (types['Streaming'] && types['Recording'] && thisAggregators.indexOf(item.longname) !== -1) {
                filtered.push(item);
            }
            
            if (!types['Streaming'] && !types['Recording'] && thisAggregators.indexOf(item.longname) !== -1) {
                filtered.push(item);
            }
            
        });
        return filtered;
    };
});
             
/**
 * Talks filter directive for inverting checkboxes values
 */
angular.module('ukfn').directive('inverted', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function(val) { return !val; });
            ngModel.$formatters.push(function(val) { return !val; });
        }
    };
});