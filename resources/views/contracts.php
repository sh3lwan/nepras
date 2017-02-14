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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script> <!-- load angular -->
    <script src="js/controllers/mainCtrl.js"></script>
    <script src="js/services/employeeService.js"></script>
    <script src="js/app.js"></script>


</head>
<body ng-app="mainApp">
<div class="container">

    <div class="add-data" ng-controller="Ctrl">

        <h1>Add Data</h1>

        <form method="POST" name="add-form" ng-submit="addEmployee()">

            <?php echo csrf_field(); ?>


            <div class="form-group form-inline">
                <input id="identity" class="form-control input-sm" placeholder="SSN" pattern="[0-9]{10}" required
                       title="Only 10 numbers allowed"
                       ng-model="object.identity" ng-blur="validateID()">
                <span ng-show="validIdentity">ID number not available!</span>
            </div>
            <div class="form-group">
                <input type="text" class="form-control " placeholder="Full Name"
                       ng-model="object.name" required pattern="\D{1,}" tilte="Only letters allowed">
            </div>
            <div class="form-group">
                <input type="date" class="form-control "
                       placeholder="Birth Date"
                       ng-model="object.birth_date" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control " placeholder="Address"
                       ng-model="object.address" required>
            </div>

            <!--            <div class="form-group">-->
            <!--                Image:-->
            <!--                <input type="file" class="form-control " value="load" required-->
            <!--                       accept="image/*">-->
            <!--            </div>-->

            <div class="form-group">
                Contract Type:
                <select ng-options="contract as contract.name for contract in contracts"
                        ng-model="contractSelected"></select>
            </div>

            <div class="action">
                <button type="submit" class="btn btn-default">Add</button>
            </div>
        </form>


    </div>


    <div class="text-center" ng-controller="mainController">
        <table>
            <tr class="top-row">
                <td>#ID</td>
                <td>SSN</td>
                <td>Name</td>
                <td>Address</td>
                <td>Birth Date</td>
                <td>Contract Type</td>
                <td>Delete</td>
                <td>Update</td>
            </tr>
            <tr ng-repeat="employee in employees">
                <td>{{employee.id}}</td>
                <td>{{employee.identity}}</td>
                <td>{{employee.name}}</td>
                <td>{{employee.address}}</td>
                <td>{{employee.birth_date | date:'dd/MM/yyyy'}}</td>
                <td>{{employee.contract_id}}</td>
                <td>
                    <button href="#" ng-click="deleteEmployee(employee)" class="btn btn-danger">Delete</button>
                </td>

                <td>
                    <button href="#" class="btn btn-info">Update
                    </button>
                </td>
            </tr>
        </table>
    </div>
</div>


</body>
</html>