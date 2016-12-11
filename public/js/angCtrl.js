/**
 * SIF Controlelr
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
        });
