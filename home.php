<!DOCTYPE html>
<html lang="en" ng-app="mainApp">
  <head>
    <meta charset="utf-8">
    <title>HR Manager Questionnaire</title>
    <meta name="description" content="Flat UI Kit Free is a Twitter Bootstrap Framework design and Theme, this responsive framework includes a PSD and HTML version."/>

    <meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="dist/css/vendor/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="dist/css/flat-ui.css" rel="stylesheet">
    <link href="docs/assets/css/demo.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

    <link rel="shortcut icon" href="img/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="dist/js/vendor/html5shiv.js"></script>
      <script src="dist/js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body ng-controller="MainCtrl" >
    <div class="container" >
      <div class="demo-headline">
       
      </div> <!-- /demo-headline -->
      </div>
		<div class="row">
			<div class="col-lg-12 align-center lato-font">
				<p class="home-title">Welcome back {{userObj.username}}!</p>
		  </div>
       </div>
	   <div class="row">
			<div class="col-lg-12 align-center lato-font">
				<a class="lato-font nav-button" href="challenges.php">challenge me!</a><br/>
				<a class="lato-font nav-button" href="inbox.php">my inbox</a><br/>
				<a class="lato-font nav-button" href="#">my achievements</a><br/>
				<a class="lato-font nav-button" href="#" ng-click="showHall()">hall of fame</a><br/>
				<a class="lato-font nav-button" href="#" ng-click="logout()">sign out</a><br/>
		  </div>
       </div>

	   
	   		<div class="modal fade" data-keyboard="false" data-backdrop="static" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-body">
				
				<h4>Hall of Fame</h4>
				<table class="table table-striped">
					<tr><th>Username</th><th>Score</th></tr>
					<tr ng-class="{info: user.username==userObj.username}" ng-repeat="user in leaderboard">
						<td>{{user.username}}</td><td>{{user.score}}</td>
					</tr>
				</table>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Back to Main</button>
			  </div>
			</div>
		  </div>
		</div>
	   


    <script src="js/vendor/jquery.min.js"></script>
	<script src="js/lib/angular.min.js"></script>
	<script src="js/lib/bootstrap.js"></script>
  <script src='js/lib/firebase.js'></script>
  <script src='js/lib/angularfire.min.js'></script>
  
  

	
	<script>
	
		function getCookie(cname) {
			var name = cname + "=";
			var ca = document.cookie.split(';');
			for(var i=0; i<ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1);
				if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
			}
			return "";
		}
		
		function deleteCookie(){
			document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
		}
		var mainApp=angular.module('mainApp',['firebase']);
		mainApp.controller('MainCtrl',['$scope','$firebase',function($scope,$firebase){
			
			var ref=new Firebase("https://hrmanager.firebaseio.com/users");
			$scope.users=$firebase(ref).$asArray();
			
			function userComparator(a,b){
				return b.score-a.score;
			}
			
			$scope.username=getCookie("username");
			if($scope.username==""){
				window.location.replace("index.php");
			}
			$scope.logout=function(){
				deleteCookie();
				window.location.replace("index.php");
			}
			
			$scope.showHall=function(){
				$("#successModal").modal('show');
			}
			
			$scope.users.$loaded(function(){
				
					for(var i=0;i<$scope.users.length;i++){
					if($scope.users[i].username==$scope.username){
						$scope.userObj=$scope.users[i];
						
					}
				}
				
				var list= $scope.users.slice();
				list.sort(userComparator);
				$scope.leaderboard=list.slice(0,10).sort(userComparator);
				
			
				
			});
		}]);
	</script>
  </body>
</html>
