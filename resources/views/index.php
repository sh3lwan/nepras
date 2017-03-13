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


<div class="container">
    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <i class="icon-bubbles font-dark hide"></i>
                <span class="caption-subject font-dark bold uppercase">Employees</span>
            </div>

            <ul class="nav nav-tabs">
                <li class="active">
                    <a id="tab1" href="#portlet_comments_1" data-toggle="tab"> View </a>
                </li>
                <li>
                    <a id="tab2" href="#portlet_comments_2" data-toggle="tab"> ADD </a>
                </li>

            </ul>

        </div>

        <div class="portlet-body">

            <div class="tab-content">

                <div class="tab-pane active" id="portlet_comments_1">

                    <!-- BEGIN: Employees -->
                    <div id="content" class="mt-comments">

                        <div class="mt-comment" ng-repeat="employee in employees">

                            <div class="mt-comment-img">
                                <img ng-src="/avatars/{{employee.image}}">
                            </div>

                            <div class="mt-comment-body">

                                <div class="mt-comment-info">
                                    <span class="mt-comment-author">{{employee.name}}</span>
                                    <span class="mt-comment-date">{{employee.birth_date}}</span>
                                </div>

                                <div class="mt-comment-text">
                                    <span class="mt-comment-ssn">{{employee.identity}}</span><br>
                                    {{employee.address}}
                                </div>

                                <div class="mt-comment-details">

                                    <span class="mt-comment-status mt-comment-status-pending">
                                        {{employee.contract_id}}
                                    </span>
                                    <ul class="mt-comment-actions">
                                        <li>
                                            <a ng-click="updateEmployee(employee)">Edit</a>
                                        </li>
                                        <li>
                                            <a href="family.php?relative_id={{employee.id}}">View</a>
                                        </li>
                                        <li>
                                            <a href="#" ng-click="deleteEmployee(employee)">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- END: Employees -->
                    </div>
                </div>

                <div class="tab-pane" id="portlet_comments_2">

                    <div class="tab-content sub-tab">

                        <ul id="sub_tab" class="nav nav-tabs">

                            <li class="active">
                                <a href="#" data-toggle="tab">Information</a>
                            </li>

                            <li>
                                <a id="image-sub-tab" href="#" data-toggle="tab">Image</a>
                            </li>

                            <li>
                                <a href="#" data-toggle="tab">Family</a>
                            </li>

                            <li>
                                <a href="#" data-toggle="tab">Contract</a>
                            </li>

                        </ul>


                        <div class="tab-pane active" id="Information-tab">

                            <div class="portlet light form-fit bordered">


                                <div class="portlet-title">
                                    <div class="caption">
                                            <span
                                                class="caption-subject font-green sbold uppercase">Basic Information</span>
                                    </div>
                                </div>


                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form novalidate ng-submit="addEmployee()" method="POST"
                                          enctype="multipart/form-data"
                                          class="form-horizontal form-bordered">


                                        <?php echo csrf_field(); ?>


                                        <div class="form-body">

                                            <div class="form-group">
                                                <label class="control-label col-md-3">SSN</label>
                                                <div class="col-md-4">
                                                    <input class="form-control" id="identity" type="text"
                                                           placeholder="SSN" pattern="[0-9]{10}" required
                                                           title="Only 10 numbers allowed" maxlength="10"
                                                           ng-model="object.identity">
                                                    <span ng-show="errorShown">{{error}}</span>
                                                    <span ng-show="successShown">{{success}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Name</label>
                                                <div class="col-md-4">
                                                    <input class="form-control" placeholder="Full Name" id="fullName"
                                                           ng-model="object.name" required pattern="\D{1,}"
                                                           tilte="Only letters allowed" maxlength="20">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Birth Date</label>
                                                <div class="col-md-4">
                                                    <input type="date" class="form-control "
                                                           id="birthDate"
                                                           ng-change="checkDate()" class="form-control"
                                                           placeholder="Birth Date" max="30-12-2000"
                                                           ng-model="object.birth_date" required>

                                                    <span
                                                        ng-show="invalidDate">Please Enter date between 1950 and 2000!</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Address</label>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="text" id="address"
                                                           placeholder="Address"
                                                           ng-model="object.address" required>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button ng-disabled="disableButton" type="submit" id="submit-form"
                                                            class="btn blue">
                                                        Submit
                                                    </button>
                                                    <button ng-click="cancelSubmit()" type="button" class="btn default">Cancel</button>
                                                </div>
                                            </div>
                                        </div>


                                    </form>
                                    <!-- END FORM-->
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="Image-tab">

                            <div class="portlet light form-fit bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                            <span
                                                class="caption-subject font-green sbold uppercase">Choose Image</span>
                                    </div>
                                </div>


                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <div class="form-horizontal form-bordered">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Image Upload</label>
                                                <div class="col-md-9">

                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail"
                                                             style="width: 200px; height: 150px; padding-top: 15px">
                                                            <img id="image-preview"
                                                                 src="/avatars/image.jpg"
                                                                 alt=""></div>
                                                        <div class="upload-image">
                                                            <label class="btn btn-success custom-file-upload">
                                                                <input type="file" accept="image/*"
                                                                       onchange="angular.element(this).scope().uploadImage(this.files)"
                                                                       name="uploaded-image" id="uploaded-image">
                                                                Select Image
                                                            </label>

                                                            <a href="#" id="image-remove"
                                                               class="btn red fileinput-exists"
                                                               data-dismiss="fileinput">Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane" id="Family-tab">

                            <div class="portlet light form-fit bordered">


                                <div class="portlet-title">
                                    <div class="caption">
                                            <span
                                                class="caption-subject font-green sbold uppercase">Family Members</span>
                                    </div>
                                </div>

                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <div class="form-body">
                                        <div class="form-group">
                                            <form action="#" class="mt-repeater form-horizontal">

                                                <div class="mt-repeater-item">
                                                    <!-- jQuery Repeater Container -->
                                                    <div class="mt-repeater-input">
                                                        <label class="control-label">Name</label>
                                                        <br>
                                                        <input type="text" pattern="\D{1,}" tilte="Only letters allowed"
                                                               required ng-model="familyMember.name"
                                                               class="form-control">
                                                    </div>

                                                    <div class="mt-repeater-input">
                                                        <label class="control-label">Birth Date</label>
                                                        <br>
                                                        <input
                                                            class="input-group form-control form-control-inline date date-picker"
                                                            size="16" type="date" required
                                                            ng-model="familyMember.birth_date"
                                                        >
                                                    </div>

                                                    <div class="mt-repeater-input">
                                                        <label class="control-label">Relation</label>
                                                        <br>
                                                        <select ng-model="familyMember.relation" class="form-control">
                                                            <option value="Wife">Wife</option>
                                                            <option value="Husband">Husband</option>
                                                            <option value="Son">Son</option>
                                                            <option value="Daughter">Daughter</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div>

                                                    <div class="mt-repeater-input">
                                                        <a href="#"
                                                           class="btn btn-danger mt-repeater-delete">
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                        </div>

                                        <a href="#" id="add-family-member"
                                           class="btn btn-success mt-repeater-add">
                                            Add
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--Start Contract Tab-->
                        <div class="tab-pane" id="Contract-tab">

                            <div class="col-lg-12">
                                <div class="portlet light portlet-fit bordered inline-block">

                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-green bold uppercase">
                                                Contracts
                                            </span>
                                        </div>


                                    </div>


                                    <div class="portlet-body">

                                        <div class="form-group">
                                            <div class="col-md-9">
                                                <select class="form-control input-small"
                                                        ng-options="contract as contract.name for contract in contracts"
                                                        ng-model="contractSelected">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mt-element-list">

                                            <div class="mt-list-container list-news">
                                                <ul>
                                                    <li class="mt-list-item">
                                                        <div class="list-item-content">
                                                            <h2 class="uppercase">
                                                                {{contractSelected.name}}
                                                            </h2>
                                                            <p class="lead text-justify">
                                                                {{contractSelected.description}}
                                                            </p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>