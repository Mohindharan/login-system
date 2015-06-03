<?php
include_once("check_login_status.php");
// If user is already logged in, header that weenis away
if($user_ok == true){
	header("location: user.php?u=".$_SESSION["username"]);
    exit();
}
?><?php
// AJAX CALLS THIS LOGIN CODE TO EXECUTE
if(isset($_POST["e"])){
	// CONNECT TO THE DATABASE
	include_once("db_conx.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = sha1($_POST['p']);
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// FORM DATA ERROR HANDLING
	if($e == "" || $p == ""){
		echo "login_failed";
        exit();
	} else {
	// END FORM DATA ERROR HANDLING
		$sql = "SELECT id, username, password FROM users WHERE email='$e' AND activated='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
		$db_id = $row[0];
		$db_username = $row[1];
        $db_pass_str = $row[2];
		if($p != $db_pass_str){
			echo "login_failed";
            exit();
		} else {
			// CREATE THEIR SESSIONS AND COOKIES
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE); 
			// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
			$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
			echo $db_username;
		    exit();
		}
	}
	exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../js/ajax.js"></script>
<script  type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>


<link href="../css/signup-style.css" rel="stylesheet" type="text/css" />

<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700' rel='stylesheet' type='text/css'>

<title>Untitled Document</title>
</head>

<body style=" overflow:hidden; background-image:url(../img/fabric-light.png); width:100%;height:100%;">
<div class="wrapper">
<nav class="nav">
        <div class="log">
                <a style="background-color:#F90" class="login-sign" href="signup.php">SignUp</a>
              
        </div>
 </nav>

<div class="gin">
<!--/start-login-one-->

		<div class="login">	
  
			<div class="ribbon-wrapper h2 ribbon-red">
				<div class="ribbon-front">
					<h2>User Login</h2>
				</div>
				<div class="ribbon-edge-topleft2"></div>
			<div class="ribbon-edge-bottomleft"></div>
		</div>
			<form class="form"id="loginform" onsubmit="return false;">
				<ul>
       
                <li>
				<input type="text" id="email" class="text"  placeholder="Email Address"  onfocus="emptyElement('status')" required="required"><a href="#" class=" icon user"></a>
					</li><li><input id="password" type="password" placeholder="Password" onfocus="emptyElement('status')" required="required"><a href="#" class=" icon lock"></a>
					</li>
				</ul>
                
                 <p id="status"></p>
				</form>
                 <div class="submit">
  				<input type="submit" id="loginbtn"onclick="login()" value="Log in" >
				</div>
		</div>
        </div>
        </ul>
</div>
 <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
</script>
<div class="mix">
<div class='bg'></div>
<div class='clock'>
  <figure class='hour-ten'>
    <span val='1'></span>
    <span val='0'></span>
    <span val='0'></span>
    <span val='0'></span>
  </figure>
  <figure class='hour'>
    <span val='1'></span>
    <span val='2'></span>
    <span val='3'></span>
    <span val='4'></span>
    <span val='5'></span>
    <span val='6'></span>
    <span val='7'></span>
    <span val='8'></span>
    <span val='9'></span>
    <span val='0'></span>
    <span val='1'></span>
    <span val='2'></span>
  </figure>
  <figure class='min'>
    <span val='0'></span>
    <span val='1'></span>
    <span val='2'></span>
    <span val='3'></span>
    <span val='4'></span>
    <span val='5'></span>
    <span val='6'></span>
    <span val='7'></span>
    <span val='8'></span>
    <span val='9'></span>
  </figure>
  <figure class='min-ten'>
    <span val='5'></span>
    <span val='4'></span>
    <span val='3'></span>
    <span val='2'></span>
    <span val='1'></span>
    <span val='0'></span>
  </figure>
  <figure class='sec'>
    <span val='0'></span>
    <span val='1'></span>
    <span val='2'></span>
    <span val='3'></span>
    <span val='4'></span>
    <span val='5'></span>
    <span val='6'></span>
    <span val='7'></span>
    <span val='8'></span>
    <span val='9'></span>
  </figure>
  <figure class='sec-ten'>
    <span val='5'></span>
    <span val='4'></span>
    <span val='3'></span>
    <span val='2'></span>
    <span val='1'></span>
    <span val='0'></span>
  </figure>
  <img src="../img/clock-mask.svg">
</div>
</div>
</div>

<script>$(function(){

	$(".login-sign").on("click",function(){		   
			  $(".pop-log-wrap").css("display","block");	
				 $(".pop-log").css("display","block");	
			   
	});
	$(".close").on("click",function(){		   
			 
				 $(".pop-log").css("display","none");	
				 $(".pop-log-wrap").css("display","none");	
			   
			   
	});
			   });</script>

<script>
$(function(){
	$(".login-sign").on("click",function(){
		$("#sign").append("<link rel='stylesheet' href='http://yui.yahooapis.com/pure/0.6.0/pure-min.css'>" );
				$("#sign").addClass("active");
		
		});
	});
</script>
<script>
$(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});

function emptyElement(x){
	_(x).innerHTML = "";
}

function login(){
	var e = _("email").value;
	
	var p = _("password").value;
	if(e == "" || p == ""){
		_("status").innerHTML = "Fill out all of the form data";
	}
	
	else {
		_("loginbtn").style.display = "none";
		_("status").innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "login.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "login_failed"){
					_("status").innerHTML = "Login unsuccessful, please try again.";
					_("loginbtn").style.display = "block";
				} else {
					window.location = "user.php?u="+ajax.responseText;
				}
	        }
        }
        ajax.send("e="+e+"&p="+p);
	}
}
</script>


</script>
</body>
</html>