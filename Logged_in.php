<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="text" name="id" placeholder="id" required/>
<input type="text" name="product_id" placeholder="product_id" required/>
<input type="submit" value="purchase"/>
<?php
/*
5,2.5,1.25,0.63,0.32

 */
require("employee_connect.php");
$product_id=$_REQUEST['product_id'];
$price=100;
$com=$price*0.05;
$sponser_id=$_REQUEST['id'];
//$rate=array($com,$x=$com/2,$y=$x/2,$z=$y/2,$p=$z/2,$q=$p/2);
$rate=array($com,$x=$com/2,$y=$x/2,$z=$y/2,$p=$z/2,$q=$p/2);
$level=array();
$i=0;
$level[$i]=$_REQUEST['id'];
$i++;
if(!empty(trim($_REQUEST['id'])) && !empty(trim($_REQUEST['id'])))
{
	$extract=mysqli_query($con,"SELECT * FROM `mlmdb` WHERE `id`='{$sponser_id}'");
	$row=mysqli_fetch_array($extract);
	$level[$i]=$row['sponser_id'];
	$sponser_id=$row['sponser_id'];
	$root_extract=mysqli_query($con,"SELECT count(*) as `count` FROM `mlmdb` WHERE `sponser_id`='{$_REQUEST['id']}'");
	$root=mysqli_fetch_array($root_extract);
	$i++;
	echo $root['count'];
	echo "</br>";
	if($root['count']>5)
	{
		//add as a fresh node
		//mysqli_query($con,"INSERT INTO `mlmdb` (`name`,`sponser_id`,`commision`) VALUES ('{$_REQUEST['name']}','0','5')");
		unset($level);
		$level=array();		
	}
	else
	{
		//add as a sponser node
		//mysqli_query($con,"INSERT INTO `mlmdb` (`name`,`sponser_id`,`commision`) VALUES ('{$_REQUEST['name']}','{$_REQUEST['id']}','5')");
		while($sponser_id!=0)
		{		
			$extract=mysqli_query($con,"SELECT * FROM `mlmdb` WHERE `id`='$sponser_id'");
			$row=mysqli_fetch_array($extract);		
			$sponser_id=$row['sponser_id'];
			if($sponser_id!=0)
			{
				$level[$i]=$row['sponser_id'];	
				$i++;
			}
			else
				break;
		}
	}
}
print_r($level);
echo "</br>";
print_r($rate);
echo "</br>";

//update commision
for($j=0;$j<count($level);$j++)
{	
	if($j==count($rate))//number of level is count or rate per level. so here count is 5 so only five level commision
		{
			echo $j.count($rate);
			break;
		}	
	$query=mysqli_query($con,"SELECT `commision` FROM `mlmdb` WHERE `id`='{$level[$j]}'");
	$com=mysqli_fetch_array($query);
	$commision=$com['commision']+$rate[$j];
	echo $level[$j]." - ".$commision;
	echo "</br>";
	mysqli_query($con,"UPDATE `mlmdb` SET `commision`='$commision' WHERE `id`='{$level[$j]}'");
}
?>
</form>
</body>
</html>