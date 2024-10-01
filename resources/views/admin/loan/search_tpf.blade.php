@extends('layouts.admin.admin_angular_template')

@section('content')
<link rel="stylesheet" href="{!! asset('admin_panel/css/agnu/structure.css') !!}" />
<link rel="stylesheet" href="{!! asset('admin_panel/css/agnu/angucomplete.css') !!}" />
<link rel="stylesheet" href="{!! asset('admin_panel/css/agnu/fonts/bariol/bariol.css') !!}" />

<div class="row" ng-app="app">
    <!-- left column -->
    <div class="col-md-12" ng-controller="MainController">
        <!-- general form elements -->
        <div class="box box-primary" >
            <!-- form start -->
            <div class="box-body">
                <div class="col-md-3"><label>Search TPF Number</label></div>
                <form name="searchTPFForm" id="searchTPFForm" autocomplete="off">
                        
                   <div class="col-md-3">
                    <div  angucomplete-alt                    
                      id="ex10"
                      placeholder="Search TPF Number"
                      pause="100"
                      text-searching="Searching..."
                      selected-object="selectedTPF"
                      local-search="localSearch"
                      local-data="tpfs"
                      search-fields="tpf"
                      title-field="tpf"
                      minlength="1"
                      input-class="form-control"
                      match-class="highlight"
                      field-required="true"
                      input-changed="inputChanged"
                      input-name="tpfsearch">
                    </div>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-block btn-info" ng-click="searchTPF()">Search</button>
                    </div> 
                </form>
            </div>
            <customer-detail></customer-detail>
        </div>
    </div>
</div>

<script>
var app = angular.module('app', ["ngTouch", "angucomplete-alt"]);

app.controller('MainController', ['$scope', '$http', '$rootScope','$sce',
  function MainController($scope, $http, $rootScope,$sce) {
    $scope.remoteUrlRequestFn = function(str) {
      return {q: str};
    };

    var search_text='';
    

    $scope.localSearch = function(str,tpfs) {
      //alert(str);
      var matches = [];
      $scope.tpfs.forEach(function(tpfobj) {
        var fulltpf = tpfobj.tpf;
        //alert(fulltpf.indexOf(str)+"=="+str+"=="+fulltpf);

        if (fulltpf.indexOf(str) == 0) {
          matches.push(tpfobj);
        }
      });
      
       return matches;
      
    };

    $scope.tpfs = <?php echo json_encode($customerObj->tpf_number_array);?>;


    $scope.inputChanged = function(str) {
      search_text = str;
    }


  $scope.searchTPF = function(keyEvent) {

    if($scope.selectedTPF){
      console.log($scope.selectedTPF);
      search_text=$scope.selectedTPF.originalObject.tpf;
      }
      
     if(search_text!='' || search_text==null){
      $http({
      method: 'POST',
      url:"{!! url('/admin/loan_section/getTPFDetails') !!}",
      data:{search:search_text},
      //headers: {'Content-Type': 'text/html'},
      }).then(function successCallback(response) {

        $scope.rawHtml=$sce.trustAsHtml(response.data.html);

      }, function errorCallback(response){
        $scope.rawHtml='There is something wrong'
      });

    }
    else{
      $scope.rawHtml='';
    }
    
  }


  }
]);
app.directive('customerDetail', function($compile, $parse) {
    return {
      restrict: 'E',
      template: '<div ng-bind-html="rawHtml"></div>',
      link: function(scope, element, attr) {
        scope.$watch(attr.content, function() {
          element.html($parse(attr.content)(scope));
          $compile(element.contents())(scope);
        }, true);
      }
    }
  });
</script> 
@endsection