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
            controller.test = "HELLO";
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
           
            controller.setActive = function(id) {
                controller.sigActive = id;
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
