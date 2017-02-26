app.controller('familyController', function (Family, popupService, $window, $filter, $scope) {

    //Get relative id from Url using JavaScript
    var id = location.search;
    id = id.split('=')[1];


    //If error in relative id, user can't do anything, redirected to home page.
    if (id == null || id == '' || id == undefined) {
        $scope.canAdd = false;
        window.location.href = 'index.php';
    } else {

        $scope.canAdd = true;
        $scope.familyMember = {'relation': 'Son'};


        //Get family for relative id provided from server
        Family.get({id: id}, function (response) {
            if (response.success) {
                $scope.family = response.family;
                $scope.canAdd = true;
            }
        });
    }


    $scope.deleteMember = function (member) {

        //Pop up message service to ask if the user is sure to delete
        if (popupService.showPopup('Are you sure?')) {
            Family.delete({id: member.id}, function (response) {
                if (response.success) {

                    //When deleted successfully, remove from table without render
                    var index = $scope.family.indexOf(member);
                    $scope.family.splice(index, 1);
                }
            });
        }
    };


    //Default value for add button ('Add family member', choice 1)
    $scope.buttonValue = 'Add';
    var submitValue = 1;


    //Add and update function
    $scope.addMember = function () {

        var relativeID = -1;
        if (id != undefined || id != '') {

            relativeID = parseInt(id);

            //filter date to form accepted by the server
            var date = $filter('date')(new Date($scope.familyMember.birth_date), 'yyyy-MM-dd');


            var member = {
                'id': $scope.familyMember.id,
                'name': $scope.familyMember.name,
                'birth_date': date,
                'relation': $scope.familyMember.relation,
                'relative_id': relativeID
            };


            //Choice is Add
            if (submitValue == 1) {
                Family.save(member, function (response) {
                    $scope.family.splice(0, 0, member);
                });

            }
            //Choice is update
            else if (submitValue == 2) {
                Family.update({id: member.id, data: member}, function (response) {
                    if (response.success) {
                        //Reload page after update
                        $window.location.reload();
                    } else {
                        //Change and show error message
                        $scope.error = "Update failed";
                        $scope.errorShown = true;
                    }
                });
            }
        } else {

            //Any error in relative id, redirect to home page
            window.location.href = 'index.php';
        }

    };


    // Updating family member
    $scope.updateMember = function (member) {

        $scope.familyMember = {
            id: member.id,
            name: member.name,
            relation: member.relation,
            birth_date: new Date(member.birth_date)
        };
        //Change button choice to update
        submitValue = 2;

        //Change button text value to update instead of Add.
        $scope.buttonValue = 'Update';

        //Scroll to the top
        $window.scrollTo(0, 0);
    }


});