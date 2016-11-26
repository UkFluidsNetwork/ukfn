/**
 * SIF Controlelr
 * @param {storage} $localStorage 
 */
angular.module('ukfn')
        .controller('sigController', function ($http, $localStorage) {
            // no undeclared variables

            // this scope name
            var controller = this;
            controller.test = "HELLO";
            controller.GOOGLE_API = "AIzaSyBfPzqmEJJdLfOXiaoTeGfSH2qDyxrIoD4";
            controller.$storage = $localStorage;


            controller.markers = [];

            controller.institutions =[];
                    $http({
                    method: 'GET',
                    url: '/api/institutions'
                            }).then(function (response) {
            
                //console.log(response);
                controller.$storage.inst = response;
            });

           

            controller.map =
                    {
                        'latitude': '54.3781',
                        'longtitude': '-4.05'
                    };
        });
