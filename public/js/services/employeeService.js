/**
 * Created by shabon on 2/11/2017.
 */


angular.module('employeeService', [])

    .factory('Employee', function ($http) {

        return {
            get: function () {
                return $http.get('/api/employees');
            },

            save: function (data) {
                return $http({
                    method: 'POST',
                    url: '/api/employees',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(data)
                });
            },

            destroy: function (employee) {
                return $http.delete('/api/employees/' + employee.id);
            }
        }

    });