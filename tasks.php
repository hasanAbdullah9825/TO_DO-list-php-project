<?php
include_once ('config.php');
$connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if(!$connection)
{
	throw new Exception("Can not connect database");
	
}
else
{
	$action=$_POST['action']??'';
	echo $action;
	if(!$action)
	{
		header('Location:index.php');
	}

	else
	{
		if('add'==$action)
		{
			$task=$_POST['task'];
			$date=$_POST['date'];
		
		if($task && $date)
		{
			$query="INSERT INTO ".DB_TABLE. "(task,date) VALUES ('{$task}','{$date}')";
			//$query = "INSERT INTO " . DB_TABLE . "(task,date) VALUES('{$task}','{$date}')";
			mysqli_query($connection,$query);
			header('Location: index.php?added=true');
		}

	   }

	   if('complete'==$action)
	   {
	   	$taskid=$_POST['taskid'];
	   	if($taskid)
	   	{
	   	$query="UPDATE tasks SET complete=1 WHERE id={$taskid} LIMIT 1";
	   	mysqli_query($connection,$query);
	   	header('Location: index.php');	
	   	}
	   }
	   //---
	   if('incomplete'==$action)
	   {
	   	
	   	$taskid=$_POST['taskid'];
	   

	   	if($taskid)
	   	{
	   	$query="UPDATE tasks SET complete=0 WHERE id={$taskid} LIMIT 1";
	   	mysqli_query($connection,$query);
	   	header('Location: index.php');	
	   	}
	   }
	   //--

	   if('delete'==$action)
	   {
	   	
	   	$taskid=$_POST['taskid'];
	   	

	   	if($taskid)
	   	{
	   	$query="DELETE FROM tasks WHERE id={$taskid} LIMIT 1";
	   	mysqli_query($connection,$query);
	   	header('Location: index.php');	
	   	}
	   }
	   //---

	   if('bulkcomplete'== $action)
	   {
	   	
	   	$taskids = $_POST['taskids'];
	   	//echo $action;
	   	$_taskids = join(",",$taskids);

	   	

	   	if ( $taskids ) {
				$query = "UPDATE tasks SET complete=1 WHERE id in ($_taskids)";
				mysqli_query( $connection, $query );
				header('Location: index.php');	
			}
	   }
	   //--

	   if('bulkdelete'==$action)
	   {
	   	
	   	$taskids=$_POST['taskids'];
	   	$_taskids = join(",",$taskids);

	   	

	   	if ( $taskids ) {
				$query="DELETE FROM tasks WHERE id in ($_taskids) ";
				mysqli_query( $connection, $query );
				header('Location: index.php');	
			}
	   }
	}
}
