/**
 * Created by shabon on 2/12/2017.
 */


angular.module('contractService', [])

    .factory('Contract', function ($http) {

        return {
            get: function () {
                return $http.get('/api/contracts');
            },

            save: function (data) {
                return $http({
                    method: 'POST',
                    url: '/api/contracts',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(data)
                });
            },

            show: function (id) {
                return $http.show('/api/contracts/' + id);
            }
        }

    });