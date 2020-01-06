<?php
include_once "config.php";
$connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if(!$connection)
{
	throw new Exception("can not connect to database");
	
}
else
{
	echo "connected";
	//echo "\n";
// echo mysqli_query($connection,"INSERT INTO tasks(task,date)VALUES('do something good',2019-8-16) ");

	// $result=mysqli_query($connection,"SELECT * FROM tasks");

	// while($data=mysqli_fetch_assoc($result))
	// {
	// 	echo "<pre>";
	// 	print_r($data);
	// 	echo "</pre>";
	// }

	mysqli_query($connection,"DELETE FROM tasks");
	mysql_close($connection);

}
