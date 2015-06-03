<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>login/sign up</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="js/main.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>	
<script type="text/javascript" language="javascript" src="js/app.js"></script>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<link rel="stylesheet" href="css/lander.css">
 

</head>

<?php include 'php/connect.php'; 
if(connect()==0){echo'<div class="boom">
<h1>404 ERROR</h1><br>
<p class="error">SORRY we are working on it</p>

</div>';
}	

else{ 
include "php/lander-nav.php";
include "php/lander.php";

}?>


</body>
</html>