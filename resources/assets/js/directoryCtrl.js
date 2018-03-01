angular.module('ukfn')
    .controller('directoryController', function ($http, $localStorage, $sce) {
        // this scope name
        var controller = this;
        controller.$storage = $localStorage;
        controller.searchTerms = []; // terms entered in recorded search box
        controller.loading = true; // flag to display loading message

        controller.initialise = function() {
            controller.clearCache();
            controller.loadUsers();
        }

        controller.updateQuery = function(query) {
            controller.loadUsers();
        };

        controller.clearCache = function () {
            var oneWeekAgo = new Date();
            oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
            if (oneWeekAgo > controller.$storage['directory-date']) {
                controller.$storage.$reset();
            }
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
                var today = new Date();
                today.setDate(today.getDate());
                controller.$storage['directory-date'] = today;
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
    });
