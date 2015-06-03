var i=1
function slideit(){
	var ele=document.getElementById("slide")
	if(i<4){
	var str="img/stock"+i+".jpg"
	ele.style.transition="background-image 1.0s linear "
	ele.style.backgroundImage="url("+str+")"
	i++
	}
	else{
		i=1

		}
setTimeout("slideit()",5000);
}
