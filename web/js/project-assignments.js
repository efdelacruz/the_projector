var app = angular.module('projAssignments', ['ngRoute']);

app.config([ '$interpolateProvider', '$httpProvider', '$routeProvider', '$locationProvider', function($interpolateProvider, $httpProvider, $routeProvider, $locationProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
    $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    $locationProvider.html5Mode(true);
  }
]);

app.controller('projAssignmentsCtrl', ['$scope', '$window', '$http', '$location', function($scope, $window, $http, $location) {

    $scope.init = function() {
      $http({
        url : $location.path(),
        method : "GET"
      }).then(function (response) {
        $scope.data = JSON.parse(response.data);
        $scope.assignedPax = $scope.data.project_assignments;
        $scope.unassignedPax = $scope.data.project_unassigned_list;
        $scope.projectName = $scope.data.project_name;
        $scope.projectId = $scope.data.project_id;
      }, function(response) {
        console.log(response);
      });

      return false;
    };
    $scope.init();

    $scope.assignPerson = function (e) {
      e.preventDefault();

      if (typeof ($scope.personToAdd) == "undefined" || $scope.personToAdd == "") {
        $window.alert("Please select a person a to add!");
        return false;
      }

      var url = "/projector/projects/assign";
      var personObj = $.param({
        'project_id' : $scope.projectId,
        'person_id' : $scope.personToAdd.id
      });

      $http({
        url : url,
        method : "POST",
        data : personObj
      }).then(function (response) {
          var index = -1;
          var upArr = eval( $scope.unassignedPax );
          for( var i = 0; i < upArr.length; i++ ) {
            if( upArr[i].id === $scope.personToAdd.id ) {
              index = i;
              break;
            }
          }
          if( index === -1 ) {
            $window.alert( "Something gone wrong" );
          }
          $scope.assignedPax.push($scope.unassignedPax[index]);
          $scope.unassignedPax.splice( index, 1 );
      }, function(response) {
          console.log(response);
      });

      return false;
    }

    $scope.unassignPerson = function (e, personId) {
      e.preventDefault();

      var url = "/projector/projects/assign";
      var personObj = $.param({
        'project_id' : $scope.projectId,
        'person_id' : personId
      });

      $http({
        url : url,
        method : "POST",
        data : personObj
      }).then(function (response) {
        var index = -1;
        var apArr = eval( $scope.assignedPax );
        for( var i = 0; i < apArr.length; i++ ) {
          if( apArr[i].id === personId ) {
            index = i;
            break;
          }
        }
        if( index === -1 ) {
          $window.alert( "Something gone wrong" );
        }
        $scope.unassignedPax.push($scope.assignedPax[index]);
        $scope.assignedPax.splice( index, 1 );
      }, function(response) {
        console.log(response);
      });

      return false;
    }
}]);
