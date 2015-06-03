<?php
session_start();
// If user is logged in, header them away
if(isset($_SESSION["username"])){
	header("location: message.php?msg=NO to that weenis");
    exit();
}
?><?php
// Ajax calls this NAME CHECK code to execute
if(isset($_POST["usernamecheck"])){
	include_once("db_conx.php");
	$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
	$sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) {
	    echo '<strong style="color:#F00;">3 - 16 characters please</strong>';
	    exit();
    }
	if (is_numeric($username[0])) {
	    echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
	    exit();
    }
    if ($uname_check < 1) {
	    echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
	    exit();
    } else {
	    echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
	    exit();
    }
}
?><?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["u"])){
	// CONNECT TO THE DATABASE
	include_once("db_conx.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = $_POST['p'];
	$g = preg_replace('#[^a-z]#', '', $_POST['g']);
	$a = $_POST['a'];
	$ph = $_POST['ph'];
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
	$sql = "SELECT id FROM users WHERE username='$u' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$u_check = mysqli_num_rows($query);
	// -------------------------------------------
	$sql = "SELECT id FROM users WHERE email='$e' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$e_check = mysqli_num_rows($query);
	// FORM DATA ERROR HANDLING
	if($u == "" || $e == "" || $p == "" || $g == ""||$a==""||$ph==""){
		echo "The form submission is missing values.";
        exit();
	} else if ($u_check > 0){ 
        echo "The username you entered is alreay taken";
        exit();
	} else if ($e_check > 0){ 
        echo "That email address is already in use in the system";
        exit();
	} else if (strlen($u) < 3 || strlen($u) > 16) {
        echo "Username must be between 3 and 16 characters";
        exit(); 
    } else if (is_numeric($u[0])) {
        echo 'Username cannot begin with a number';
        exit();
    } else {
	// END FORM DATA ERROR HANDLING
	    // Begin Insertion of data into the database
		// Hash the password and apply your own mysterious unique salt
		$p_hash = sha1($p);


		// Add user info into the database table for the main site table
		$sql = "INSERT INTO users (username, email, password, gender, ip,age,phone, signup, lastlogin)       
		        VALUES('$u','$e','$p_hash','$g','$ip','$a','$ph',now(),now())";
		$query = mysqli_query($db_conx, $sql); 
		$uid = mysqli_insert_id($db_conx);
		// Establish their row in the useroptions table
		$sql = "INSERT INTO useroptions (id, username, background) VALUES ('$uid','$u','original')";
		$query = mysqli_query($db_conx, $sql);
		// Create directory(folder) to hold each user's files(pics, MP3s, etc.)
		
			chdir ("../users");
			if (!file_exists("users/$u")) {
			mkdir($u, 0777);
		}
		// Email the user their activation link
		$to = "$e";							 
		$from = "mohindharan13@gmail.com";
		$subject = 'yoursitename Account Activation';
		$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>yoursitename Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"><a href="http://www.yoursitename.com"><img src="http://www.yoursitename.com/images/logo.png" width="36" height="30" alt="yoursitename" style="border:none; float:left;"></a>yoursitename Account Activation</div><div style="padding:24px; font-size:17px;">Hello '.$u.',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="http://www.yoursitename.com/activation.php?id='.$uid.'&u='.$u.'&e='.$e.'&p='.$p_hash.'">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>'.$e.'</b></div></body></html>';
		$headers = "From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		mail($to, $subject, $message, $headers);
		echo "signup_success";
		exit();
	}
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="favicon.ico" type="image/x-icon">

<link rel="stylesheet" href="../css/signin.css">
<link rel="stylesheet" href="../css/normalize.css">

<script src="../js/ajax.js"></script>
<script>
function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	} else if(elem == "username"){
		rx = /[^a-z0-9]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function emptyElement(x){
	_(x).innerHTML = "";
}
function checkusername(){
	var u = _("username").value;
	if(u != ""){
		_("unamestatus").innerHTML = 'checking ...';
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            _("unamestatus").innerHTML = ajax.responseText;
	        }
        }
        ajax.send("usernamecheck="+u);
	}
}
function signup(){
	var u = _("username").value;
	var e = _("email").value;
	var p1 = _("pass1").value;
	var p2 = _("pass2").value;
	var a= _("age").value;
	var ph= _("phone").value;
	var g = _("gender").value;
	var status = _("status");
	var log=_("log");
	var aj;
	if(u == "" || e == "" || p1 == "" || p2 == "" || g == ""||ph==""){
		status.innerHTML = "Fill out all of the form data";
	} else if(p1 != p2){
		status.innerHTML = "Your password fields do not match";
	} else {
		_("signupbtn").style.display = "none";
		status.innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax)==true) {
	            if(ajax.responseText =="signup_success"){aj=1;}
				else{aj=0;}
			    if(aj){
					status.innerHTML = ajax.responseText;
					_("signupbtn").style.display = "block";
							
			
				} else {
					window.scrollTo(0,0);
					_("signupform").innerHTML = "OK "+u+", check your email inbox and junk mail box at <u>"+e+"</u> in a moment to complete the sign up process by activating your account. You will not be able to do anything on the site until you successfully activate your account.";
				}
	        }
        }
        ajax.send("u="+u+"&e="+e+"&p="+p1+"&g="+g+"&a="+a+"&ph="+ph);
	}
}

/* function addEvents(){
	_("elemID").addEventListener("click", func, false);
}
window.onload = addEvents; */
</script>
</head>
<body>
<style>
*{
	margin:0;
	padding:0;
	}
.nav{
	width:100%;
	height:50px;
	background-color:#D13AFF;
	position:fixed;
	top:0;
	box-shadow:0 0 10px #888;
	z-index:1000;
	
	}
.nav>.log{
	margin-top:15px;
	width:300px;
	height:30px;
	position:absolute;
	right:10px;
	}	
	
.nav>.log>a{
	text-decoration:none;
	color:#FFF;
	font-size:1.2em;
	font-family:Arial, Helvetica, sans-serif;
	margin:20px;
	padding:10px;
	border-radius:5px;
	transition:all .5s ease;
	
	}		
	.nav>.log>a:hover{
		background-color:darkorange;
		box-shadow:2px 4px 8px #000;
border-radius:8px;		
	}

</style>

 <nav class="nav">
        <div class="log">
               
                <a  style="font-size:1.2em"href="login.php">Login</a>
                 <a  style="font-size:1.2em"href="#">Sign Up</a>
        </div>
 </nav>

  <h3>Sign Up Here</h3>
 
  <form name="signupform" id="signupform" onsubmit="return false">
  <legend>Your Profile info</legend>
   <label for="name">Userame:</label>
   <input id="username" type="text" onblur="checkusername()" onkeyup="restrict('username')" maxlength="16" />
    <span id="unamestatus"></span>
    
      <label for="mail">Email:</label>
      <input type="email" id="email" name="user_email"  required="required" onfocus="emptyElement('status')"  id="email" type="text" onfocus="emptyElement('status')" onkeyup="restrict('email')" maxlength="88"/>


<label for="password">Password:</label>
          <input type="password" id="pass1" name="user_password1" required="required" onfocus="emptyElement('status')" maxlength="16" />
  
    
     <label for="cpassword">Comfirm Password:</label>
          <input type="password" id="pass2" name="user_password2" required="required" onfocus="emptyElement('status')" maxlength="16">
          	<label for="age">Age:</label>
    		<input type="number" id="age" name="age" required="required" min="12" />
            	<label for="phone">Phone:</label>
    		<input type="tel" id="phone" name="phone" required="required" />
            
            
     <label>Gender:</label>
    <select id="gender" onfocus="emptyElement('status')">
      <option value=""></option>
      <option value="m">Male</option>
      <option value="f">Female</option>
    </select>

  
    <div>
   
    </div>
   
    
    <br /><br />
    <button id="signupbtn" onclick="signup()">Create Account</button>
    <span id="status"></span>
    
  </form>
</div>

</body>
</html>