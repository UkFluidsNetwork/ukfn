angular.module('ukfn')
    .controller('directoryController', function ($http, $localStorage, $sce) {
        // this scope name
        var controller = this;
        controller.$storage = $localStorage;
        controller.disciplines = []; // disciplines for selectize
        controller.categories = []; // discipline categories for selectize optgroup
        controller.searchTerms = []; // terms entered in recorded search box

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
            var url = '/api/public/users/';
            controller.loading = true;
            // clear array of available users before making the request.
            controller.users = [];

            $http(
                {
                    method: 'GET',
                    url: url,
                    params: {
                        search: JSON.stringify(controller.searchTerms)
                    }
                }
            ).then(function (response) {
                controller.loading = false;
                controller.users = response.data;
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
            optgroups: controller.categories,
            placeholder: 'Enter subject area(s)'
          };
    });
