/**
 * Created by shabon on 2/16/2017.
 */
app.controller('contractController', function (Contract, $window, popupService, $scope) {


    //Set default value for add function
    $scope.buttonValue = 'Add Contract';
    var submitValue = 1;
    var contractID = -1;

    //Get all contracts from database.
    $scope.contracts = Contract.query();


    //Delete contract method
    $scope.deleteContract = function (contract) {
        //Pop up message to ask user if he's sure about delete
        if (popupService.showPopup('Are you sure?')) {
            contract.$delete(function () {
                //Remove contract from table without render
                var index = $scope.contracts.indexOf(contract);
                $scope.contracts.splice(index, 1);
            });
        }
    };


    // Adding a new contract
    $scope.addContract = function () {

        //Adding Choice
        if (submitValue == 1) {
            Contract.save($scope.newContract, function (response) {

                //Adding contract to the top of the tabel without render
                $scope.newContract.id = response.contract.id;
                $scope.contracts.splice(0, 0, $scope.newContract);
            });
        }

        //Choice is update
        else if (submitValue == 2) {
            Contract.update({id: contractID, data: $scope.newContract},
                function (response) {

                    //When update succeed
                    if (response.success) {

                        //Return to default value (Add Contract)
                        $scope.buttonValue = 'Add Contract';
                        submitValue = 1;

                    }
                });
        }

        else {
            //Move to home page
            window.location.href = 'index.php';
        }
    };


    //Change to update contract
    $scope.updateContract = function (contract) {

        $scope.newContract = contract;
        $scope.buttonValue = 'Update Contract';
        submitValue = 2;
        $window.scrollTo(0, 0);
        contractID = contract.id;
    };


});