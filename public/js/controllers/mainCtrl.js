/**
 * Created by shabon on 2/11/2017.
 */


angular.module('mainCtrl', [])
    .controller('mainController', function ($scope, $filter, $http, Employee) {


        $scope.object = {
            name: '', address: '', identity: '',
            birth_date: '', image: '', contract_id: 1

        };

        Employee.get().then(
            function (response) {
                $scope.employees = response.data;
            }, function (response) {
                $scope.error = "Something went wrong";
            });

        $http.get('/api/contracts').then(
            function (response) {
                $scope.contracts = response.data;
                $scope.contractSelected = $scope.contracts[0];
            }, function (response) {
                $scope.error = "Something went wrong";
            });

        $scope.deleteEmployee = function (employee) {
            Employee.destroy(employee).then(
                function (response) {
                    if (response.status == 200) {
                        var index = $scope.employees.indexOf(employee);
                        $scope.employees.splice(index, 1);
                    }
                }, function (response) {
                    $scope.error = "Something went wrong";
                });
        };


        $scope.addEmployee = function () {
            var date = $filter('date')(new Date($scope.object.birth_date), 'yyyy-MM-dd')
            $scope.object.contract_id = $scope.contractSelected.id;

            var contarctType = $scope.contractSelected.name;
            var fileInput = document.getElementById("uploaded-image");
            var files = fileInput.files;
            var image = files[0];


            var fd = new FormData();
            fd.append('image', image);
            fd.append('name', $scope.object.name);
            fd.append('identity', $scope.object.identity);
            fd.append('address', $scope.object.address);
            fd.append('contract_id', $scope.object.contract_id);
            fd.append('birth_date', date);

            $http({
                url: 'api/employees',
                method: 'POST',
                data: fd,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity,
            }).then(function (response) {
                if (response.data.success) {
                    var employee = response.data.employee;
                    employee['contract_id'] = contarctType;
                    $scope.employees.splice(0, 0, employee);
                }
            }, function (error) {

            });
        };


    });




