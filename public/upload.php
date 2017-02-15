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


</head>
<body ng-app="mainApp">
<div class="container">

    <div class="add-data" ng-controller="familyController">

        <h1>Add Family Member</h1>

        <form method="POST" name="add-form" ng-submit="addFamilyMember()">

            <input hidden="true" value="{{csrf_token()}}">


            <div class="form-group">
                <input type="text" class="form-control " placeholder="Full Name"
                       ng-model="family.name" required pattern="\D{1,}" tilte="Only letters allowed">
            </div>
            <div class="form-group">
                <input type="date" class="form-control "
                       placeholder="Birth Date"
                       ng-model="family.birth_date" required>
            </div>

            <select ng-model="family.relative">
                <option value="Wife"></option>
                <option value="Husband"></option>
                <option value="Son"></option>
                <option value="Daughter"></option>
                <option value="Other"></option>
            </select>

            <div class="action">
                <button type="submit" class="btn btn-default">Add</button>
            </div>
        </form>


    </div>


    <div class="text-center" ng-controller="mainController">
        <table>
            <tr class="top-row">
                <td>Name</td>
                <td>Relationship</td>
                <td>Birth Date</td>
                <td>Delete</td>
                <td>Update</td>
            </tr>
            <tr ng-repeat="employee in employees">
                <td>{{member.name}}</td>
                <td>{{member.relation}}</td>
                <td>{{member.birth_date | date:'dd/MM/yyyy'}}</td>

                <td>
                    <button href="#" ng-click="deleteMember(employee)" class="btn btn-danger">Delete</button>
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