/**
 * Created by shabon on 2/16/2017.
 */
app.controller('contractController', function (Contract, $filter, popupService, $location, $scope) {

    $scope.contracts = Contract.query();


    $scope.deleteContract = function (contract) {
        if (popupService.showPopup('Are you sure?')) {
            contract.$delete(function () {
                var index = $scope.contracts.indexOf(contract);
                $scope.contracts.splice(index, 1);
            });
        }
    };

    $scope.addContract = function () {
        Contract.save($scope.newContract, function (response) {
            $scope.newContract.id = response.contract.id;
            $scope.contracts.splice(0, 0, $scope.newContract);
        });
    };


});