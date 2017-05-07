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
        controller.showframe = [];

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
