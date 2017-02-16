/**
 * Created by shabon on 2/16/2017.
 */
app.controller('contractController', function ($http, $filter, $location, $scope) {

    $http.get('api/contracts').then(
        function (response) {
            $scope.contracts = response.data;
        }, function (error) {

        });


    $scope.deleteContract = function (contract) {
        $http.delete('/api/contracts/' + contract.id).then(
            function (response) {
                if (response.status == 200) {
                    var index = $scope.contracts.indexOf(contract);
                    $scope.contracts.splice(index, 1);
                }
            }, function (error) {
                $scope.error = "Something went wrong";
            });
    };


    $scope.addContract = function () {
        $http({
            url: 'api/contracts/',
            method: 'POST',
            data: $scope.newContract,
        }).then(function (response) {

            $scope.contracts.splice(0, 0, $scope.newContract);
        }, function (error) {
            console.log(error);
        });


    };


});