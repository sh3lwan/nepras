/**
 * Created by shabon on 2/11/2017.
 */

app.controller('mainController', function ($scope, $window, $filter, $http, $timeout, popupService, Employee, Contract) {

        $scope.contracts = Contract.query(function () {
            $scope.contractSelected = $scope.contracts[0];
        });

        $scope.employees = Employee.query();


        $scope.checkDate = function () {
            var date = $filter('date')(new Date($scope.object.birth_date), 'yyyy');
            var disable = date > 2000 || date < 1970;
            $scope.invalidDate = disable;
            $scope.disableButton = disable;
        };


        $scope.deleteEmployee = function (employee) {
            if (popupService.showPopup('Are you sure?')) {
                employee.$delete(function () {
                    var index = $scope.employees.indexOf(employee);
                    $scope.employees.splice(index, 1);
                });
            }
        };


        var submitValue = 0;
        showAdd();
        $scope.addEmployee = function () {
            if (submitValue === 1) {
                $scope.disableButton = true;
                var fileInput = document.getElementById("uploaded-image");
                var files = fileInput.files;
                var image = files[0];

                var fd = new FormData();
                fd.append('image', image);

                $http.post('upload', fd, {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                }).then(
                    function (response) {

                        var imagePath = 'image.jpg';
                        if (response.data.success) {
                            imagePath = response.data.image;
                        }
                        $scope.object.image = imagePath;
                        $scope.object.contract_id = $scope.contractSelected.id;

                        var employee = $scope.object;

                        Employee.save(employee, function (dataResponse) {
                            if (dataResponse.success) {
                                $scope.errorShown = false;
                                $scope.successShown = true;
                                $scope.success = 'Employee Added Successfuly';
                                employee['contract_id'] = $scope.contractSelected.name;
                                $scope.employees.splice(0, 0, employee);
                            } else {
                                // console.log('Failure:');
                                // console.log(dataResponse);
                                $scope.errorShown = true;
                                $scope.error = dataResponse.message.identity[0];
                            }
                        });


                    }, function () {

                    });

            } else if (submitValue == 2) {
                console.log('Update');
                showAdd();
                $scope.object.birth_date = $filter('date')(new Date($scope.object.birth_date), 'yyyy-MM-dd');
                $scope.object.contract_id = $scope.contractSelected.id;
                $scope.disableButton = true;
                Employee.update($scope.object, function (response) {
                    if (response.success) {
                        $scope.success = response.message;
                        $scope.successShown = true;
                        $window.location.reload();
                    } else {
                        $scope.error = response.message;
                        $scope.errorShown = true;
                    }
                });

            } else {

            }

            $timeout(function () {
                $scope.errorShown = false;
                $scope.successShown = false;
                $scope.disableButton = false
            }, 3000);
        };


        $scope.updateEmployee = function (employee) {

            submitValue = 2;
            $scope.fileShown = false;
            $scope.object = employee;
            $scope.object.birth_date = new Date(employee.birth_date);
            $scope.buttonValue = 'Update Employee';
            $scope.fileRequired = false;
            $window.scrollTo(0, 0);

        };


        function showAdd() {
            submitValue = 1;
            $scope.buttonValue = 'Add Employee';
            $scope.fileShown = true;
            $scope.fileRequired = true;
        }
    }
);



