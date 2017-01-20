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

        // aggregator objects are added here from multiselect
        controller.filterAggregatorsLookup = [];
        
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
                    var aggregatorId = controller.talks[i].aggregator_id;
                    if (!(aggregator in lookup)) {
                        lookup[aggregator] = true;
                        controller.thisAggregators.push({id: aggregatorId, label: aggregator});
                    }                        
                }
            });
        })();
                
        /**
         * Reset aggregator filter array to empty
         * @author Robert Barczyk <robert@barczyk.net>
         * @returns {void}
         */
        controller.deleteAggregatorFilter = function() {
             controller.filterAggregators = [];
        };
        
        /**
         * Create array with selected aggregator ids used by talks filter
         * @author Robert Barczyk <robert@barczyk.net>
         * @returns {array}
         */
        controller.generateAggregatorFilter = function() {
            controller.filterAggregators = [];
            for (var f = 0; f < controller.filterAggregatorsLookup.length; f++) {
                controller.filterAggregators.push(controller.filterAggregatorsLookup[f].id);
            }
        };
              
        // multiselect aggregator settings
        controller.multiselectSettings = {
            enableSearch: true,
            smartButtonMaxItems: 1000
        };
           
        //multiselect aggregator tranlations
        controller.multiselectTranslations = {
            buttonDefaultText: 'Select Aggregators'
        };

        // multiselect aggregator events
        controller.multiselectEvents = {
            onItemSelect: controller.generateAggregatorFilter, 
            onItemDeselect: controller.generateAggregatorFilter,
            onSelectAll: controller.generateAggregatorFilter,
            onDeselectAll: controller.deleteAggregatorFilter
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
     * @param {array} filterAggregators
     * @returns {array}
     */
    return function( items, types, filterAggregators) {
        var filtered = [];
    
        angular.forEach(items, function(item) {
            // if everything is unticked
            if (!types['Streaming'] && !types['Recording'] && filterAggregators.length === 0) {
                filtered.push(item);
            }
            
            // if recording and streaming is unticked but one of the aggregators is selected
            if (!types['Streaming'] && !types['Recording'] && filterAggregators.indexOf(item.aggregator_id) !== -1) {
                filtered.push(item);
            }
            
            // recording only ticked
            if (types['Recording'] && item.displayRecording && !types['Streaming'] && filterAggregators.length === 0) {
                filtered.push(item);
            } 
            
            // streaming only ticked
            if (types['Streaming'] && item.displayStreaming && !types['Recording'] && filterAggregators.length === 0) {
                filtered.push(item);
            }
            
            // if streaming and recording is ticked
            if (types['Streaming'] && types['Recording'] && (item.displayStreaming || item.displayRecording) && filterAggregators.length === 0) {
                filtered.push(item);
                
            }

            // if streaming and recording is ticked and at least one of the aggreagators
            if (types['Streaming'] && types['Recording'] && (item.displayStreaming || item.displayRecording) && filterAggregators.indexOf(item.aggregator_id) !== -1) {
                filtered.push(item);   
            }
            
            // if streaming is ticked and one of the aggregators 
            if (types['Streaming'] && item.displayStreaming && !types['Recording'] && filterAggregators.indexOf(item.aggregator_id) !== -1) {
                filtered.push(item);
            }
            
            // if recording is ticked and one of the aggregators 
            if (types['Recording'] && item.displayRecording && !types['Streaming'] && filterAggregators.indexOf(item.aggregator_id) !== -1) {
                filtered.push(item);
            }
        });
        return filtered;
    };
});