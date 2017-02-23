app.controller('familyController', function (Family, popupService, $window, $filter, $scope) {
    var id = location.search;
    id = id.split('=')[1];


    $scope.canAdd = false;

    if (id == null || id == '' || id == undefined) {
        $scope.canAdd = false
        window.location.href = 'index.php';
    } else {
        $scope.canAdd = false;
        $scope.familyMember = {'relation': 'Son'};

        Family.get({id: id}, function (response) {
            if (response.success) {
                $scope.family = response.family;
                $scope.canAdd = true;
            }
        });
    }


    $scope.deleteMember = function (member) {
        if (popupService.showPopup('Are you sure?')) {
            Family.delete({id: member.id}, function (response) {
                if (response.success) {
                    var index = $scope.family.indexOf(member);
                    $scope.family.splice(index, 1);
                }
            });
        }
    };


    $scope.buttonValue = 'Add';
    var submitValue = 1;


    $scope.addMember = function () {

        var relativeID = -1;
        if (id != undefined || id != '') {
            relativeID = parseInt(id);
            var date = $filter('date')(new Date($scope.familyMember.birth_date), 'yyyy-MM-dd');
            var relation = $scope.familyMember.relation;
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
                        $window.location.reload();
                    } else {
                        $scope.error = "Update failed";
                        $scope.errorShown = true;
                    }
                });
            }

        } else {
            window.location.href = 'index.php';
        }

    };


    $scope.updateMember = function (member) {
        $scope.familyMember = {
            id: member.id,
            name: member.name,
            relation: member.relation,
            birth_date: new Date(member.birth_date)
        };
        console.log($scope.familyMember);
        submitValue = 2;
        $scope.buttonValue = 'Update';
        $window.scrollTo(0, 0);
    }


});