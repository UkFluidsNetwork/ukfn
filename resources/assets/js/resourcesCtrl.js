angular.module('ukfn')
    .controller('resourcesController', function ($http, $localStorage, $sce) {
        // this scope name
        var controller = this;
        controller.$storage = $localStorage;
        controller.disciplines = []; // disciplines for selectize
        controller.categories = []; // discipline categories for selectize optgroup
        controller.searchTerms = []; // terms entered in recorded search box
        controller.types = {
            Notes: true,
            Code: true,
            Slides: true,
            Audio: true,
            Video: true
        };
        controller.icons = {
            Notes: "glyphicon-file",
            Code: "glyphicon-console",
            Slides: "glyphicon-blackboard",
            Audio: "glyphicon-headphones",
            Video: "glyphicon-film",
            Link: "glyphicon-new-window"
        };

        controller.loading = true; // flag to display loading message

        controller.updateQuery = function(query) {
            controller.loadResources();
        };

        controller.loadDisciplines = function() {
            var url = '/api/resources/tags';
            controller.disciplines = [];

            $http({method: 'GET', url: url}).then(function (response) {
                controller.disciplines = response.data;
            });
        };

        controller.loadResources = function() {
            var url = '/api/resources/';
            controller.loading = true;
            // clear array of available resources before making the request.
            controller.resources = [];

            $http(
                {
                    method: 'GET',
                    url: url,
                    params: {
                        types: JSON.stringify(controller.types),
                        search: JSON.stringify(controller.searchTerms)
                    }
                }
            ).then(function (response) {
                controller.loading = false;
                controller.resources = response.data;
            });
        };

        controller.isUrl = function(s) {
            var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
            return regexp.test(s);
        };

        controller.isPdf = function(s) {
            return s.includes(".pdf");
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
            optgroupValueField: 'category',
            optgroups: controller.categories,
            placeholder: 'Enter subject area(s)'
          };
    });
