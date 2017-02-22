app.controller('familyController', function ($http, Family, $filter, $location, $scope) {
    var id = location.search;
    id = id.split('=')[1];


    $scope.canAdd = false;

    var generalUrl = 'api/family/';

    if (id != undefined) {
        generalUrl += id;
        $scope.canAdd = true;
        $scope.familyMember = {'relation': 'Son'};
    }

    $scope.family = Family.query();
    var index = $scope.family.indexOf(member);
    $scope.family.splice(index, 1);

    $scope.deleteMember = function (member) {

    };


    $scope.addMember = function () {
        var relativeID = parseInt(id);
        var member = {
            'name': $scope.familyMember.name,
            'birth_date': $scope.familyMember.birth_date,
            'relation': $scope.familyMember.relation,
            'relative_id': relativeID
        };


        member['birth_date'] = $filter('date')(new Date($scope.familyMember.birth_date), 'yyyy-MM-dd');


        console.log(member);
        $http({
            url: 'api/family/',
            method: 'POST',
            data: member,
        }).then(function (response) {
            $scope.family.splice(0, 0, member);
        }, function (error) {
            console.log(error);
        });


    };


});