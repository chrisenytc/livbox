(function() {
  var app;

  app = angular.module('livboxApp', []);

  $(document).ready(function() {
    return $('[data-toggle=tooltip]').tooltip();
  });

  $('.collapse').collapse();

}).call(this);
