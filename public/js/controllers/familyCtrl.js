app.controller('familyController', function (Family, popupService, $filter, $scope) {
    var id = location.search;
    id = id.split('=')[1];


    $scope.canAdd = false;

    if (id == null || id == '' || id == undefined) {
        $scope.canAdd = false

    } else {
        $scope.canAdd = false;
        $scope.familyMember = {'relation': 'Son'};
        Family.get({id: id}, function (response) {
            if (response.success) {
                console.log(response.family);
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

    $scope.addMember = function () {
        var relativeID = -1;
        if (id != undefined || id != '') {
            relativeID = parseInt(id);
            var date = $filter('date')(new Date($scope.familyMember.birth_date), 'yyyy-MM-dd');

            var member = {
                'name': $scope.familyMember.name,
                'birth_date': date,
                'relation': $scope.familyMember.relation,
                'relative_id': relativeID
            };

            Family.save(member, function (response) {
                $scope.family.splice(0, 0, member);
            });
        } else {
            $location.path('index.php');
        }
    };


});