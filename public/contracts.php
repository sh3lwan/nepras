<!-- app/views/index.php -->

<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Task</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script src="js/lib/angular.min.js"></script>
    <script src="js/lib/angular-resource.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/services/popup.service.js"></script>
    <script src="js/services/contract.service.js"></script>
    <script src="js/controllers/contractsCtrl.js"></script>

</head>
<body ng-app="mainApp" ng-controller="contractController">
<div class="container">
    <div class="add-contract">

        <h3>ADD CONCTRACT</h3>
        <form method="post" ng-submit="addContract()">
            <input hidden="true" value="{{csrf_token()}}">


            <div class="form-group">
                <input type="text" class="form-control " placeholder="Name"
                       ng-model="newContract.name" required pattern="\D{1,}" tilte="Only letters allowed">
            </div>

            <div class="form-group">
                <input type="text" class="form-control " placeholder="Description"
                       ng-model="newContract.description" required>
            </div>

            <input type="submit" class="btn btn-info">

        </form>

    </div>

    <table class="contract-table text-center">
        <tr class="top-row">
            <td>ID</td>
            <td>Name</td>
            <td>Description</td>
            <td>Delete</td>
        </tr>

        <tr ng-repeat="contract in contracts">
            <td>{{contract.id}}</td>
            <td>{{contract.name}}</td>
            <td>{{contract.description | limitTo:200}}</td>
            <td>
                <button href="#" ng-click="deleteContract(contract)" class="btn btn-danger">Delete</button>
            </td>
        </tr>
    </table>
</div>
</body>
</html>