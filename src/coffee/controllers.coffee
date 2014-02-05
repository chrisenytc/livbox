#
#Module: livbox
#Name: Christopher EnyTC
#Username: chrisenytc
#Site: http://chris.enytc.com
#Github: https://github.com/chrisenytc/livbox
#Twitter: @chrisenytc
#

window.aboutCtrl = ($scope, $http, $window, $routeParams) ->
  $ = jQuery
  $http.get("https://api.github.com/repos/enytc/livbox/contributors").success (data) ->
    $scope.status = true
    $scope.contributors = data
