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


    <script src="js/lib/angular.min.js"></script> <!-- load angular -->
    <script src="js/lib/angular-resource.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/services/family.service.js"></script>
    <script src="js/controllers/familyCtrl.js"></script>


</head>
<body ng-app="mainApp" ng-controller="familyController">
<div class="container">

    <div class="add-data" ng-show="canAdd">

        <h1>Add Family Member</h1>

        <form method="POST" name="add-form" ng-submit="addMember()">

            <input hidden="true" value="{{csrf_token()}}">


            <div class="form-group">
                <input type="text" class="form-control " placeholder="Full Name"
                       ng-model="familyMember.name" required pattern="\D{1,}" tilte="Only letters allowed">
            </div>
            <div class="form-group">
                <input type="date" class="form-control " placeholder="Birth Date"
                       ng-model="familyMember.birth_date" required>
            </div>

            <div class="form-group">
                <select ng-model="familyMember.relation">
                    <option value="Wife">Wife</option>
                    <option value="Husband">Husband</option>
                    <option value="Son">Son</option>
                    <option value="Daughter">Daughter</option>
                    <option value="Other">Other</option>
                </select>
            </div>


            <div class="action">
                <button ng-disable="disableButton" type="submit" class="btn btn-default">Add</button>
            </div>
        </form>


    </div>


    <div class="text-center">
        <table>
            <tr class="top-row">
                <td>Related Employee's ID</td>
                <td>Name</td>
                <td>Relationship</td>
                <td>Birth Date</td>
                <td>Delete</td>
            </tr>
            <tr ng-repeat="member in family">
                <td>{{member.relative_id}}</td>
                <td>{{member.name}}</td>
                <td>{{member.relation}}</td>
                <td>{{member.birth_date | date:'dd/MM/yyyy'}}</td>

                <td>
                    <button href="#" ng-click="deleteMember(member)" class="btn btn-danger">Delete</button>
                </td>
            </tr>
        </table>
    </div>
</div>


</body>
</html>