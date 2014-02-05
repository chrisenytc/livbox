(function() {
  window.aboutCtrl = function($scope, $http, $window, $routeParams) {
    var $;
    $ = jQuery;
    return $http.get("https://api.github.com/repos/enytc/livbox/contributors").success(function(data) {
      $scope.status = true;
      return $scope.contributors = data;
    });
  };

}).call(this);
