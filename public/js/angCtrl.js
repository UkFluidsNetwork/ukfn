/**
 * SIG Controlelr
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
           
            controller.setActive = function(id) {
                controller.sigActive = id;
            };
            
            controller.dispAll = function() {
                controller.displayAll = true;
            };
            
            // default UK map coordinates
            controller.map =
                    {
                        'latitude'  : '54.8',
                        'longtitude': '-4.40'
                    };
                             
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
 * Talks Controlelr
 * @param {storage} $localStorage 
 * @param {$http} $http
 */
angular.module('ukfn')
        .controller('talksController', function ($http, $localStorage) {
            
            // this scope name
            var controller = this;
            controller.$storage = $localStorage;
            
            // filter types
            controller.types = {};
        
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
                    controller.talks = response;
                    var lookup = {};
                    var talks = response.data;
                    var aggregators = [];
                   
                        
                    //for (var item, i = 0; item = talks[i++];) {
                    
                    for (var i = 0; i < talks.length; i++)  {
                        var aggregator = talks[i].longname;

                        if (!(aggregator in lookup)) {
                            lookup[aggregator] = 1;
                            //controller.types[aggregator] = false;
                            aggregators.push(aggregator);
                        }
                        
                        
                    }
                    
                    controller.thisAggregators = aggregators;
                });
            })();
            
            controller.types = {
              teradekip: false,
              recordingurl: false
              //streamingurl: false 
            };
            
            controller.search=[];
            
        });






angular.module('ukfn').filter('myfilter', function() {
    return function( items, types) {
        var filtered = [];
    
        angular.forEach(items, function(item) {
            // show all
            if(types.teradekip === false && types.recordingurl === false) {
                filtered.push(item);
            }
            // all with recording
            else if(types.teradekip === true && types.recordingurl === false && item.recordingurl !== null && item.recordingurl !== '') {
                filtered.push(item);
            }
            // all with teradekip
            else if(types.teradekip === false && types.recordingurl === true && item.teradekip !== null && item.teradekip !== '' ) {
                filtered.push(item);
            }
        });

        return filtered;
      };
});
             
angular.module('ukfn').directive('inverted', function() {
  return {
    require: 'ngModel',
    link: function(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function(val) { return !val; });
      ngModel.$formatters.push(function(val) { return !val; });
    }
  };
});