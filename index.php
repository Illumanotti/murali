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

    <link rel="shortcut icon" href="img/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="dist/js/vendor/html5shiv.js"></script>
      <script src="dist/js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body ng-controller="MainCtrl" style="background-color:cadetblue">
    <div class="container">
      <div class="demo-headline">
        <h1 class="demo-logo">
          <img src="img/icons/svg/clipboard.svg" alt="Clipboard">HR Manager
          <small style="color:#E3E3E3">Are you game?</small>
        </h1>
      </div> <!-- /demo-headline -->
	  
	  <!---Login-->
	  
		<div class="row">
			<div class="col-lg-offset-3 col-lg-6">
          <div class="login-form">
            <div class="form-group">
              <input type="text" class="form-control login-field" value="" placeholder="Enter your name" id="login-name" />
              <label class="login-field-icon fui-user" for="login-name"></label>
            </div>

            <div class="form-group">
              <input type="password" class="form-control login-field" value="" placeholder="Password" id="login-pass" />
              <label class="login-field-icon fui-lock" for="login-pass"></label>
            </div>

            <a class="btn btn-primary btn-lg btn-block" ng-click="login()" href="">Log in</a>
			<br/>
			<div class="row">
			<div class="col-sm-6">
			<a class="btn btn-warning btn-block " data-toggle="modal" data-target="#leaderboard" href="#"><span class="fui-list-bulleted"></span> Leaderboard</a>
			
			</div>
			<div class="col-sm-6">
			<a class="btn btn-success btn-block" data-toggle="modal" data-target="#signupModal" href="#"><span class="fui-new"></span> Sign up</a>
			</div>
			</div>
          </div>
		  </div>
       </div>
	   
	   
<!-- Sign Up Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Register User</h4>
      </div>
      <div class="modal-body">
					<form class="form-horizontal">
		  <div class="form-group">
			<label for="username" class="col-sm-2 control-label">Username</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="username" placeholder="Username" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="password" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10">
			  <input type="password" class="form-control" id="password" placeholder="Password" required>
			</div>
		  </div>
		 
		 <div class="form-group">
			<label for="confirm" class="col-sm-2 control-label">Confirm</label>
			<div class="col-sm-10">
			  <input type="password" class="form-control" id="confirm" placeholder="Password" required>
			</div>
		  </div>
		  
		  <div id="errorMsg" style="display:none;"class="alert alert-danger" role="alert"></div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" ng-click="register()" class="btn btn-success">Sign up</button>
			</div>
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			
      </div>
    </div>
  </div>
</div>


<!--LeaderBoard Modal-->

<div class="modal fade" id="leaderboard" tabindex="-1" role="dialog" aria-labelledby="leaderLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="leaderLabel">Leaderboard</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
					<tr><th>Username</th><th>Score</th></tr>
					<tr  ng-repeat="user in leaderboard">
						<td>{{user.username}}</td><td>{{user.score}}</td>
					</tr>
				</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


    <script src="dist/js/vendor/jquery.min.js"></script>
	<script src="js/lib/angular.min.js"></script>
  <script src='js/lib/firebase.js'></script>
  <script src='js/lib/angularfire.min.js'></script>
  
  

	
	<script>
	
		function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays*24*60*60*1000));
			var expires = "expires="+d.toUTCString();
			document.cookie = cname + "=" + cvalue + "; " + expires;
		}
		var mainApp=angular.module('mainApp',['firebase']);
		mainApp.controller('MainCtrl',['$scope','$firebase',function($scope,$firebase){
			
			var ref=new Firebase("https://hrmanager.firebaseio.com/users");
			$scope.users=$firebase(ref).$asArray();
			
			$scope.login=function(){
				for(var i=0;i<$scope.users.length;i++){
					if($scope.users[i].username==$("#login-name").val() && $scope.users[i].password==$("#login-pass").val()){
						setCookie("username",$scope.users[i].username,1);
						window.location.replace("question.html");
					}
				};
			}
			
			$scope.register=function(){
				var username=$("#username").val();
				var password=$("#password").val();
				var confirm=$("#confirm").val();
				
				if(password==confirm){
					$scope.users.$add({username:username,password:password,score:0});
					console.log(username);
					setCookie("username",username,1);
					window.location.replace("question.html");
				}else{
					displayError("Password and confirm password not matched");
				}
			}
			
			var displayError=function(errorMsg){
				$("#errorMsg").empty();
					$("#errorMsg").append(errorMsg);
					
					$("#errorMsg").fadeIn().delay(2000).fadeOut();
			};
			function userComparator(a,b){
				
				return b.score-a.score;
			}
			
			$scope.users.$loaded(function(){
				var list= $scope.users.slice();
				list.sort(userComparator);
				$scope.leaderboard=list.slice(0,10).sort(userComparator);
				
				
			});
		}]);
	</script>
  </body>
</html>
