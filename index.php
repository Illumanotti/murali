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
	  <!---Login-->
	  
		<div class="row">
		
			<div class="col-lg-offset-4 col-lg-5">
			<p class="home-title inbox-title lato-font align-center">HR CHALLENGE
			<small class="lato-font align-center" style="font-size:20px">are you game?</small></p>
			<div id="loginMsg" style="display:none;"class="alert alert-danger" role="alert"></div>
			
            <div class="form-group">
              <input type="text" class="login-field" value="" placeholder="username" id="login-name" />
             
            </div>

            <div class="form-group">
              <input type="password" class="login-field" value="" placeholder="password" id="login-pass" />
              
            </div>

            <div class="row align-center"><a class="login-btn" ng-click="login()" href="">LOGIN<span class="glyphicon glyphicon-circle-arrow-right login-arrow"></span></a></div>
			<br/>
			
			<div class="row align-center">

			<div class="col-sm-6">
			<a class="signup" data-toggle="modal" data-target="#signupModal" href="#"><span class="fui-new"></span> Sign up</a>
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



    <script src="js/vendor/jquery.min.js"></script>
	<script src="js/lib/angular.min.js"></script>
	<script src="js/lib/bootstrap.js"></script>
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
						window.location.replace("home.php");
					}
				};
				displayLoginError("Invalid username/password");
			}
			
			$scope.register=function(){
				var username=$("#username").val();
				var password=$("#password").val();
				var confirm=$("#confirm").val();
				
				if(password==confirm){
					$scope.users.$add({username:username,password:password,score:0});
					console.log(username);
					setCookie("username",username,1);
					window.location.replace("home.php");
				}else{
					displayError("Password and confirm password not matched");
				}
			}
			
			var displayError=function(errorMsg){
				$("#errorMsg").empty();
					$("#errorMsg").append(errorMsg);
					
					$("#errorMsg").fadeIn().delay(2000).fadeOut();
			};
			
			var displayLoginError=function(errorMsg){
				$("#loginMsg").empty();
					$("#loginMsg").append(errorMsg);
					
					$("#loginMsg").fadeIn();
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
