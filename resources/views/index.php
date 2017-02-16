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

    <script src="js/lib/jquery.min.js"></script>
    <script src="js/lib/angular.min.js"></script>

    <script src="js/app.js"></script>
    <script src="js/services/saveData.js"></script>
    <script src="js/controllers/mainCtrl.js"></script>


</head>
<body ng-app="mainApp" ng-controller="mainController">


<div class="container">


    <div class="add-data">

        <span class="success" ng-show="successShown">
        {{success}}
        </span>
        <h1>Add Employee</h1>

        <form method="POST" enctype="multipart/form-data" name="add-form" ng-submit="addEmployee()">

            <?php echo csrf_field(); ?>


            <div class="form-group form-inline">
                <input id="identity" class="form-control input-sm" placeholder="SSN" pattern="[0-9]{10}" required
                       title="Only 10 numbers allowed" maxlength="10"
                       ng-model="object.identity">

                <span class="error" ng-show="errorShown">
                {{error}}
                </span>
                <!--                <span ng-show="!validIdentity">ID number not available!</span>-->
            </div>
            <div class="form-group">
                <input type="text" class="form-control " placeholder="Full Name"
                       ng-model="object.name" required pattern="\D{1,}" tilte="Only letters allowed" maxlength="20">
            </div>
            <div class="form-group form-inline">
                <input type="date" class="form-control "
                       ng-change="checkDate()"
                       placeholder="Birth Date" max="30-12-2000"
                       ng-model="object.birth_date" required>

                <span ng-show="invalidDate">Please Enter date between 1950 and 2000!</span>
            </div>

            <div class="form-group">
                <input type="text" class="form-control " placeholder="Address"
                       ng-model="object.address" required>
            </div>

            <div class="form-group" ng-hide="fileShown">
                Image:
                <input type="file" class="btn  btn-block" name="uploaded-image" id="uploaded-image"
                       ng-required="fileRequired"
                       value="Change Image" accept=" image/*">

            </div>

            <div class="form-group">
                Contract Type:
                <select ng-options="contract as contract.name for contract in contracts"
                        ng-model="contractSelected"></select>
            </div>

            <div class="action">
                <button ng-disabled="disableButton" type="submit" class="btn btn-default" ng-hide="updateShown">Add
                </button>
            </div>

        </form>


    </div>

    <a href="contracts.php" class="btn btn-info">Contracts Page</a>

    <div class="text-center">
        <table>
            <tr class="top-row">
                <td>Image</td>
                <td>SSN</td>
                <td>Name</td>
                <td>Address</td>
                <td>Birth Date</td>
                <td>Contract Type</td>
                <td>Delete</td>
                <td>Family</td>
            </tr>


            <tr ng-repeat="employee in employees" class="row-entry">
                <td><img ng-src="/avatars/{{employee.image}}"></td>
                <td>{{employee.identity}}</td>
                <td>{{employee.name}}</td>
                <td>{{employee.address}}</td>
                <td>{{employee.birth_date | date:'dd/MM/yyyy'}}</td>
                <td>{{employee.contract_id}}</td>
                <td>
                    <button href="index.php" ng-click="deleteEmployee(employee)" class="btn btn-danger">Delete</button>
                </td>
                <td>
                    <a href="/family.php?relative_id={{employee.id}}" class="btn btn-info">
                        Family
                    </a>
                </td>
            </tr>

        </table>
    </div>


</div>


</body>
</html>