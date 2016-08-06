<?php
$con=mysqli_connect("localhost","root","","mlmdb");
if(mysqli_connect_errno()){
	print_r(mysqli_connect_error());
	exit();
}
?>