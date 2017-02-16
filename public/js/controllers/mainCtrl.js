/**
 * Created by shabon on 2/11/2017.
 */

app.controller('mainController', function ($scope, $window, $timeout, $filter, $http) {


    // Start Contracts
    $http.get('/api/contracts').then(
        function (response) {
            $scope.contracts = response.data;
            $scope.contractSelected = $scope.contracts[0];
        }, function (response) {
            $scope.error = "Something went wrong";
        });


    // End Contracts


    //Start Employees
    $scope.object = {
        name: '', address: '', identity: '',
        birth_date: '', image: '', contract_id: 1

    };


    // $scope.validDate = true;
    // $scope.disableButton = false;

    $scope.checkDate = function () {
        var date = $filter('date')(new Date($scope.object.birth_date), 'yyyy');
        var disable = date > 2000 || date < 1970;
        $scope.invalidDate = disable;
        $scope.disableButton = disable;
    };


    $http.get('api/employees').then(
        function (response) {
            console.log('Here');
            $scope.employees = response.data;
        }, function (response) {
            $scope.error = "Something went wrong";
        });


    $scope.deleteEmployee = function (employee) {
        $http.delete('/api/employees/' + employee.id).then(
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
        $scope.disableButton = true;
        var date = $filter('date')(new Date($scope.object.birth_date), 'yyyy-MM-dd');
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
                $scope.errorShown = false;
                $scope.successShown = true;
                $scope.success = 'Employee Added Successfuly';
                var employee = response.data.employee;
                employee['contract_id'] = contarctType;
                $scope.employees.splice(0, 0, employee);
            } else {
                $scope.errorShown = true;
                $scope.error = response.data.message.identity[0];

            }

            $timeout(function () {
                $scope.errorShown = false;
                $scope.successShown = false;
                $scope.disableButton = false
            }, 5000);
        }, function (error) {
            console.log(error);
        });

    };

    //
    // var employeeID = -1;
    //
    //
    // $scope.fileRequired = true;
    // $scope.showUpdate = function (employee) {
    //     $scope.updateShown = true;
    //     $scope.fileRequired = false;
    //     employeeID = employee.id;
    //     $scope.object = employee;
    //     $scope.object.birth_date = new Date(employee.birth_date);
    //     // $scope.contractSelected = $scope.employee.contract_id;
    //     $window.scrollTo(0, 0);
    //     $scope.unChanged = $scope.object;
    //
    //
    // };

});



