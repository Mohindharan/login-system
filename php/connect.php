<?php

function connect(){
try{
$db = new PDO("mysql:host=localhost;dbname=project","root","");
return 1;
}
catch(Exception $e){
	return 0;
}

}
	
?>