angular.module('ukfn')
        .controller('ecController', function ($http, $localStorage) {
        // this scope name
        var controller = this;
        controller.$storage = $localStorage;

        controller.ukfnUsers = [];
        controller.thisMembers = [];
        controller.files = [];
        controller.addMemberSearch = '';

        controller.initialise = function() {
            controller.loadEcMembers();
            controller.loadAllUsers();
            controller.loadFiles();
        };

        /**
         * Load this EC members
         *
         * @returns {void}  Sets array thisMembers
         */
        controller.loadEcMembers = function() {
            $http(
                    {
                        method: 'GET',
                        url: '/api/ecmembers/'
                    }
                ).then(function (response) {
                    controller.thisMembers = response.data;
                });
        };

        /**
         * Load all UKFN users, unset the ones that are already a member of this sig
         *
         * @returns {void}
         */
        controller.loadAllUsers = function() {
            controller.ukfnUsers = [];
            $http(
                    {
                        method: 'GET',
                        url: '/api/users'
                    }
                ).then(function (response) {
                    var users = response.data;
                    // for each ukfn user
                    for (var i = 0; i < users.length; i++) {
                        var existing = controller.belongsToEc(users[i].id);
                        // if thgis user is not not a member of this sig add him to all users list
                        if (!existing) {
                            // at his default property for not associated memebrs
                            users[i].selected = 0;
                            controller.ukfnUsers.push(users[i]);
                        }
                    }
                });
        };

        /**
         * Load files
         *
         * @returns {void}  Sets array files
         */
        controller.loadFiles = function() {
            $http(
                    {
                        method: 'GET',
                        url: '/api/ecphotos/'
                    }
                ).then(function (response) {
                    controller.files = response.data;
                });
        };

        controller.belongsToEc = function(userId)
        {
            var existing = false;
            if (controller.thisMembers.length !== 0) {
                for (var i =0; i< controller.thisMembers.length; i++) {
                    if(userId === controller.thisMembers[i].id) {
                        existing = true;
                        break;
                    }
                }
            }

            return existing;
        };

        /**
         * Add selected user to this sig + set membership
         *
         * @param {int} userId
         * @param {int} sigMain
         * @returns {void}
         */
        controller.addMember = function(userId)
        {
            var existing = controller.belongsToEc(userId);

            if (!existing) {
                $http({
                    method : 'POST',
                    url: '/users/ec/add/',
                    data: {
                        user_id: userId
                    }
                })
                .success(function(){
                    controller.loadEcMembers();
                });

                // reset search
                controller.addMemberSearch = '';
            }
        };

        controller.updateMember = function(userId, fileId, role)
        {
            $http({
                method : 'POST',
                url: '/users/ec/update/',
                data: {
                    user_id: userId,
                    file_id: fileId,
                    role: role
                }
            })
            .success(function(){
                controller.loadEcMembers();
            });
        };

        /**
         * Delete this user from the EC
         *
         * @param {int} userId
         * @returns {void}
         */
        controller.deleteMember = function(userId)
        {
            $http({
                method : 'POST',
                url: '/users/ec/delete/',
                data: {
                    user_id: userId
                }
            })
            .success(function(){
                controller.loadEcMembers();
            });
        };

        controller.selectizeFileConfig = {
            create: false,
            plugins: ['remove_button'],
            delimiter: ',',
            searchField: 'name',
            framework: 'bootstrap',
            valueField: 'id',
            labelField: 'name',
            placeholder: 'Photo',
            maxItems: 1
        };
    });
