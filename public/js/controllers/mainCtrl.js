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
            var disable = date > 2000 || date < 1950;

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

        var imagePath = 'image.jpg';

        $scope.uploadImage = function (files) {

            var image = files[0];

            if (image != undefined && image != null) {

                $scope.disableButton = true;

                //Append image to form data
                var fd = new FormData();
                fd.append('image', image);

                //Send to server to upload image
                $http.post('upload', fd, {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                }).then(
                    function (response) {
                        //When upload succeeds, server returns file uploaded name
                        if (response.data.success) {
                            imagePath = response.data.image;
                            console.log(imagePath);
                        }
                        $scope.disableButton = false;
                    }
                );
            }
        };


        $scope.cancelSubmit = function () {
            submitValue = 0;
            viewTab();
            $scope.object = null;
        };

        $scope.addEmployee = function () {
            //
            // var family = getFamily();
            //
            // //Get files from input:file field
            // var fileInput = document.getElementById("uploaded-image");
            // var files = fileInput.files;
            // var image = files[0];
            //
            // //
            // // //Choice 1, Adding Employee
            // // if (submitValue === 1) {
            //
            //
            // if (image != undefined && image != null) {
            //
            //     $scope.disableButton = true;
            //     //Append image to form data
            //     var fd = new FormData();
            //     fd.append('image', image);
            //
            //     //Send to server to upload image
            //     $http.post('upload', fd, {
            //         transformRequest: angular.identity,
            //         headers: {'Content-Type': undefined}
            //     }).then(
            //         function (response) {
            //
            //             var imagePath = 'image.jpg';
            //
            //             //When upload succeeds, server returns file uploaded name
            //             if (response.data.success) {
            //                 imagePath = response.data.image;
            //             }
            console.log(submitValue);
            var uploadedImage = getImage();

            var family = getFamily();
            var employee = angular.copy($scope.object);
            employee.birth_date = $filter('date')(employee.birth_date, 'yyyy-MM-dd');
            employee.image = imagePath;
            employee.family = family;
            employee.contract_id = $scope.contractSelected.id;

            if (submitValue == 0) {
                //Adding request to the server to add new employee
                if (uploadedImage != undefined && uploadedImage != null) {

                    Employee.save(employee, function (dataResponse) {

                        if (dataResponse.success) {
                            // $scope.errorShown = false;
                            // $scope.successShown = true;
                            // $scope.success = 'Employee Added Successfuly';
                            window.location.href = 'index.php';
                        } else {
                            //If adding failed, show error messages
                            $scope.errorShown = true;
                            $scope.error = dataResponse.message.identity[0];
                        }

                    });
                }
            }

            else if (submitValue == 1) {

                if (uploadedImage == undefined) {
                    employee.image = '';
                }

                Employee.update(employee, function (dataResponse) {
                    if (dataResponse.success) {

                    } else {
                        //If adding failed, show error messages
                        $scope.errorShown = true;
                        $scope.error = dataResponse.message.identity[0];
                    }

                });

                $scope.object = null;
                submitValue = 0;
            }


            //
//
// //Choice 2, Update Employee
//             } else if (submitValue == 2) {
//
//
//                 $scope.object.birth_date = $filter('date')(new Date($scope.object.birth_date), 'yyyy-MM-dd');
//                 $scope.object.contract_id = $scope.contractSelected.id;
//                 $scope.disableButton = true;
//                 Employee.update($scope.object, function (response) {
//                     if (response.success) {
//                         $scope.success = response.message;
//                         $scope.successShown = true;
//                         $window.location.reload();
//                     } else {
//                         $scope.error = response.message;
//                         $scope.errorShown = true;
//                     }
//                 });
//
//             } else {
//
//             }
            // //After 3 seconds, return to default values
            // $timeout(function () {
            //     $scope.errorShown = false;
            //     $scope.successShown = false;
            //     $scope.disableButton = false;
            //     showAdd();
            // }, 3000);
            //
            //

        };

        //Change choice to update employee
        $scope.updateEmployee = function (employee) {
            submitValue = 1;
            updateTab(employee.image);
            $scope.object = angular.copy(employee);
            $scope.object.birth_date = new Date($scope.object.birth_date);
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


        //Get Family member using JQuery from Family Tab
        var getFamily = function () {
            var family = [];
            $('.mt-repeater-item').each(function (index, element) {
                    var valid = true;
                    var member = {name: '', date: '', relation: ''};

                    $(element).find('input,select').each(function (index, element) {

                        var value = $(this).val();
                        if (index != 1 && value != null && value != undefined) {
                            value = value.trim();
                        }

                        if (value == '' || value == "? undefined:undefined ?" || value == null || value == undefined) {
                            valid = false;
                        }

                        switch (index) {
                            case 0:
                                member.name = value;
                                break;
                            case 1:
                                member.date = value;
                                break;
                            case 2:
                                member.relation = value;
                                break;
                        }
                    });

                    if (valid) {
                        family.push(member);
                    }
                }
            );
            // console.log(family);
            return family;
        };


        var updateTab = function (image) {
            $('#tab1').parent().removeClass('active');
            $('#tab2').parent().addClass('active');
            $('#portlet_comments_1').removeClass('active');
            $('#portlet_comments_2').addClass('active');
            $('#image-preview').attr('src', 'avatars/' + image);
        };

        var viewTab = function (image) {
            $('#tab2').parent().removeClass('active');
            $('#tab1').parent().addClass('active');
            $('#portlet_comments_2').removeClass('active');
            $('#portlet_comments_1').addClass('active');
            var file = $("#uploaded-image");
            $('#image-preview').attr('src', "/avatars/image.jpg").val('');
            file.val('');
        };


        var getImage = function () {
            var fileInput = document.getElementById('uploaded-image');
            var files = fileInput.files;
            var image = files[0];
            return image;
        }
    }
);



