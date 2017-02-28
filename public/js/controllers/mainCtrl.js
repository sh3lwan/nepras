/**
 * Created by shabon on 2/11/2017.
 */

app.controller('mainController', function ($scope, $window, $filter, $http, $timeout, popupService, Employee, Contract) {


        //Get contracts from server
        $scope.contracts = Contract.query(function () {
            $scope.contractSelected = $scope.contracts[0];
        });


        //Get employees from server
        var main = {currentPage: 1, numPages: 1};

        var loadEmployees = function () {
            Employee.query({page: main.currentPage}, function (result, headers) {
                $scope.employees = result;

                //Get parameter 'number of pages'
                main.numPages = headers()['Page-Count'];
            });
        };
        loadEmployees();

        //Validate if date is in proper range of values
        $scope.checkDate = function () {
            //filter to form years
            var date = $filter('date')(new Date($scope.object.birth_date), 'yyyy');

            //Check if between 2000 and 1970.
            var disable = date > 2000 || date < 1970;

            //Disable adding button if invalid date
            $scope.invalidDate = disable;
            $scope.disableButton = disable;
        };


        //Deletes Employee (Soft Deletes)
        $scope.deleteEmployee = function (employee) {
            //Show pop up message to ask if user sure about delete
            if (popupService.showPopup('Are you sure?')) {
                employee.$delete(function () {

                    //Remove employee from table without render
                    var index = $scope.employees.indexOf(employee);
                    $scope.employees.splice(index, 1);
                });
            }
        };


        //Default values for Adding button(Add Employee, Choice 1)
        var submitValue = 0;
        showAdd();


        $scope.addEmployee = function () {

            //Choice 1, Adding Employee
            if (submitValue === 1) {


                $scope.disableButton = true;

                //Get files from input:file field
                var fileInput = document.getElementById("uploaded-image");
                var files = fileInput.files;
                var image = files[0];


                //Append image to form data
                var fd = new FormData();
                fd.append('image', image);


                //Send to server to upload image
                $http.post('upload', fd, {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                }).then(
                    function (response) {

                        var imagePath = 'image.jpg';

                        //When upload succeeds, server returns file uploaded name
                        if (response.data.success) {
                            imagePath = response.data.image;
                        }

                        $scope.object.image = imagePath;
                        $scope.object.contract_id = $scope.contractSelected.id;

                        var employee = $scope.object;


                        //Adding request to the server to add new employee
                        Employee.save(employee, function (dataResponse) {

                            if (dataResponse.success) {
                                $scope.errorShown = false;
                                $scope.successShown = true;
                                $scope.success = 'Employee Added Successfuly';
                                employee['contract_id'] = $scope.contractSelected.name;
                                $scope.employees.splice(0, 0, employee);
                            } else {
                                //If adding failed, show error messages
                                $scope.errorShown = true;
                                $scope.error = dataResponse.message.identity[0];
                            }
                        });
                    }, function (error) {
                        //
                    });


                //Choice 2, Update Employee
            } else if (submitValue == 2) {


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


            //After 3 seconds, return to default values
            $timeout(function () {
                $scope.errorShown = false;
                $scope.successShown = false;
                $scope.disableButton = false;
                showAdd();
            }, 3000);
        };


        //Change choice to update employee
        $scope.updateEmployee = function (employee) {
            submitValue = 2;
            $scope.fileShown = false;

            //Fill data from employee chosen to input fields
            $scope.object = employee;
            $scope.object.birth_date = new Date(employee.birth_date);
            $scope.buttonValue = 'Update Employee';
            $scope.fileRequired = false;
            $window.scrollTo(0, 0);

        };


        // Initializes default values for ADD BUTTON
        function showAdd() {
            submitValue = 1;
            $scope.buttonValue = 'Add Employee';
            $scope.fileShown = true;
            $scope.fileRequired = true;
        }


        //Get the next number of paginated employees from server
        $scope.nextPage = function () {
            $scope.disableNext = false;
            if (main.currentPage < main.numPages) {
                main.currentPage++;
                loadEmployees();
            }

        };

        //Get the previous number of paginated employees from server
        $scope.previousPage = function () {
            if (main.currentPage > 1) {
                main.currentPage--;
                loadEmployees();
            }
        };
    }
);



