<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Employees</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport">


    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet"
          type="text/css">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/simple-line-icons.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-switch.min.css" rel="stylesheet">
    <link href="css/components.min.css" rel="stylesheet" id="style_components" type="text/css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/lib/angular.min.js"></script>
    <script src="js/lib/angular-resource.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script>
    <script src="js/lib/jquery.min.js"></script>

    <script src="js/app.js"></script>
    <script src="js/controllers/mainCtrl.js"></script>
    <script src="js/services/employee.service.js"></script>
    <script src="js/services/contract.service.js"></script>
    <script src="js/services/popup.service.js"></script>
    <script src="js/script.js"></script>

</head>


<body ng-app="mainApp" ng-controller="mainController">

<tabset>
    <tab heading="Static title" ng-attr-active="st">"; </tab>
    <tab heading="Static 2" ng-attr-active="nd">"; </tab>
</tabset>

</body>
</html>