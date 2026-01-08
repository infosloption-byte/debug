angular.module('ngtbl-sort', []).directive("sort", function() {
  return {
      restrict: 'A',
      transclude: true,
      template : 
        '<a class="sortable" ng-click="onClick()">'+
          '<span ng-transclude></span>'+ 
          '<i class="fas fas fa-sort-up deactive" ng-class="{\'active\' : order === by && !reverse,  \'deactive\' : order===by && reverse}"></i>'+
          '<i class="fas fa-sort-down deactive" ng-class="{\'deactive\' : order === by && !reverse,  \'active\' : order===by && reverse}"></i>'+
        '</a>',
      scope: {
        order: '=',
        filter : '='
      },
      link: function(scope, element, attrs) {


        scope.onClick = function () {
          if( scope.order === scope.by ) {
             scope.reverse = !scope.reverse 
          } else {
            scope.by = scope.order ;
            scope.reverse = false; 
          }

          scope.filter= {
            order:scope.order,
            by:scope.reverse?'asc':'desc'
          };
        }
      }
  }
});