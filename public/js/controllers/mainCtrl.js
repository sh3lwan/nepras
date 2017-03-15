/**
 * Created by shabon on 2/11/2017.
 */

app.controller('mainController', function ($scope, $filter, $http, $timeout, popupService, Family, Employee, Contract) {


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
                            $scope.imageMessage = false;
                        }
                        $scope.disableButton = false;
                    }
                );
            }
        };

        var submitValue = 0;

        $scope.cancelSubmit = function () {
            submitValue = 0;
            $scope.object = null;
            $scope.canAdd = false;
            employeeID = -1;
        };

        var employeeID = -1;

        $scope.addEmployee = function () {

            var fileInput = document.getElementById('uploaded-image');
            var files = fileInput.files;
            var uploadedImage = files[0];


            var employee = angular.copy($scope.object);
            employee.birth_date = $filter('date')(employee.birth_date, 'yyyy-MM-dd');
            employee.image = imagePath;
            employee.contract_id = $scope.contractSelected.id;

            if (submitValue == 0) {

                //Adding request to the server to add new employee
                if (uploadedImage != undefined && uploadedImage != null) {

                    Employee.save(employee, function (response) {

                        if (response.success) {
                            $scope.canAdd = true;
                            $scope.errorShown = false;
                            $scope.showMessage = true;
                            $scope.message = 'Employee Added Successfully';
                            employeeID = response.employee.id;
                            allFamily(employeeID);

                        } else {
                            //If adding failed, show error messages
                            $scope.errorShown = true;
                            $scope.error = response.message.identity[0];
                        }

                    });
                } else {
                    $scope.imageMessage = true;
                }
            }

            else if (submitValue == 1) {

                if (uploadedImage == undefined) {
                    employee.image = '';
                }

                Employee.update(employee, function (response) {
                    if (response.success) {
                        $scope.showMessage = true;
                        $scope.message = response.message;


                    } else {
                        //If adding failed, show error messages
                        $scope.errorShown = true;
                        $scope.error = response.message;
                    }

                });

            }

            //After 3 seconds, return to default values
            $timeout(function () {
                $scope.errorShown = false;
                $scope.showMessage = false;
                $scope.disableButton = false;
            }, 5000);

        };


        //Change choice to update employee
        $scope.updateEmployee = function (employee) {
            submitValue = 1;
            updateTab(employee.image);
            $scope.object = angular.copy(employee);
            $scope.object.birth_date = new Date($scope.object.birth_date);
            $scope.canAdd = true;
            employeeID = employee.id;
            allFamily(employee.id);

        };


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


        //Start Family Section


        //Get all family members for current employee.
        var allFamily = function (id) {
            Family.get({id: id}, function (response) {
                if (response.success) {
                    $scope.family = response.family;
                    $scope.familyNumber = $scope.family.length;
                }
            });
        };


        //Add family member to database.

        var memberID = -1;


        //Add new family member to database.
        $scope.addMember = function () {
            if (employeeID > 0) {
                var familyMember = {
                    'name': $scope.familyMember.name,
                    'relative_id': employeeID,
                    'birth_date': $filter('date')(new Date($scope.familyMember.birth_date), 'yyyy-MM-dd')
                };

                Family.save(familyMember, function (response) {

                    if (response.success) {

                        var member = response.member;
                        $scope.family.splice(0, 0, member);
                        $scope.familyNumber++;
                        showFamilyMessage('Added Successfully');

                    } else {

                        showFamilyMessage('Adding failed!');

                    }
                });

            }
        };

        //Delete family member from database.
        $scope.deleteMember = function (member) {

            if (popupService.showPopup('Are you sure?')) {
                Family.delete({id: member.id}, function (response) {
                    if (response.success) {

                        var index = $scope.family.indexOf(member);
                        $scope.family.splice(index, 1);
                        $scope.familyNumber--;
                        showFamilyMessage('Deleted Successfully');
                    } else {
                        showFamilyMessage('Deleting failed!');
                    }
                });
            }
        };


        //Updating member on database
        $scope.updateMember = function () {
            var member = angular.copy($scope.familyMember);
            member.relative_id = employeeID;
            member.birth_date = $filter('date')(member.birth_date, 'yyyy-MM-dd');

            if (memberID > 0) {

                Family.update({id: memberID, data: member}, function (response) {
                    if (response.success) {

                        //Show update without render
                        var index = $scope.memberIndex;
                        var member = response.member;
                        $scope.family[index] = member;
                        $scope.updateShown = false;

                        showFamilyMessage('Updated Successfully');
                    } else {
                        showFamilyMessage('Updating failed!');
                    }
                });

            }
        };


        //Show update button and move data for selected object to form below.
        $scope.enableUpdate = function (member, index) {
            console.log('Enable:');
            console.log(index);
            $scope.updateShown = true;
            $scope.familyMember = angular.copy(member);
            $scope.familyMember.birth_date = new Date(member.birth_date);
            $scope.memberIndex = index;
            memberID = member.id;

        };


        //Used to show messages for limited time.
        var showFamilyMessage = function (message) {
            $scope.familyMessage = message;
            $scope.showFamilyMessage = true;
            $timeout(function () {
                $scope.showFamilyMessage = false;
            }, 3000);
        };


        // End family section



        //JQuery
        var updateTab = function (image) {
            $('#tab1').parent().removeClass('active');
            $('#tab2').parent().addClass('active');
            $('#portlet_comments_1').removeClass('active');
            $('#portlet_comments_2').addClass('active');
            $('#image-preview').attr('src', 'avatars/' + image);
        };

        // var viewTab = function () {
        //     $('#tab2').parent().removeClass('active');
        //     $('#tab1').parent().addClass('active');
        //     $('#portlet_comments_2').removeClass('active');
        //     $('#portlet_comments_1').addClass('active');
        //     var file = $("#uploaded-image");
        //     $('#image-preview').attr('src', "/avatars/image.jpg").val('');
        //     file.val('');
        // };


        // var imageTab = function () {
        //     $('.sub-tab .tab-pane').removeClass('active');
        //     $('#Image-tab').addClass('active');
        //     $('#sub_tab li').removeClass('active');
        //     $('#image-sub-tab').parent().addClass('active');
        // };


    }
);