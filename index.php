<?php 
include_once('config.php');
$connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if(!$connection)
{
  throw new Exception("can not connect to database");
  
}

else 
{
  $query="select * from tasks WHERE complete =0 ORDER BY date";
  $result=mysqli_query($connection,$query);

  $CompleteTasksQuery="select * from tasks WHERE complete =1 ORDER BY date";
  $resultCompleteTasks=mysqli_query($connection, $CompleteTasksQuery);
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ToDo/Tasks</title>
    <title>Todo/Tasks</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
     <style>
        body {
            margin-top: 30px;
        }
        #main {
            padding: 0px 150px 0px 150px;;
        }
        #action {
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="container" id="main">
        <h1>Tasks Manager</h1>
        <p>This is a simple project for managing our daily tasks. we are going to use HTML,CSS,PHP,JAVASCRIPT for this project</p>

        
<?php
        if(mysqli_num_rows( $resultCompleteTasks)>0){
          ?>
          <h4>Complete Tasks</h4>
          <table>

                <thead>  
                <tr>
                <th></th>
                <th>Id</th>
                <th>Task</th>
                <th>Date</th>
                <th>Action</th>
                
                </tr> 
           </thead>
             <tbody>
       
        
           <?php
        while($cdata=mysqli_fetch_assoc($resultCompleteTasks))
        {
               $timestamp=strtotime($cdata['date']);
               $cdate=date("jS M,Y",$timestamp);

          ?>

          
         
               <tr>
                <td><input class="label-inline" type="hidden" value="<?php echo $cdata['id']; ?>"></td>
                <td><?php echo $cdata['id']; ?></td>
                <td><?php echo $cdata['task']; ?></td>
                <td> <?php echo $cdate; ?></td>
                <td><a class="delete" data-taskid="<?php echo $cdata['id'] ?>" href='#'>Delete</a> | <a
                                class="incomplete" data-taskid="<?php echo $cdata['id'] ?>" href='#'>Mark Incomplete</a>
                    </td>
                   
               </tr>
               

        <?php
      }
        ?>

        </tbody>
             </table>
             
  <?php
      }
        ?>

        <?php
        if(mysqli_num_rows($result)==0){
          echo "No Task Found";
        }
        else 
        {
        ?>
          <h4>Upcoming Tasks</h4>
          <form  method="POST" action="tasks.php">
        
            <table>

                <thead>  
                <tr>
                <th></th>
                <th>Id</th>
                <th>Task</th>
                <th>Date</th>
                <th>Action</th>
                
                </tr> 
           </thead>
           <tbody>
            <?php while($data=mysqli_fetch_assoc($result)){ 
               $timestamp=strtotime($data['date']);
               $date=date("jS M,Y",$timestamp);

              ?>
               <tr>
  <td><input  name="taskids[]" class="label-inline"  type="checkbox" value="<?php echo $data['id']; ?>"></input></td>
                <td><?php echo $data['id']; ?></td>
                <td><?php echo $data['task']; ?></td>
                <td> <?php echo $date; ?></td>
                <td>
                 <td><a class="delete" data-taskid="<?php echo $data['id']; ?>" href='#'>Delete</a> | <a class="complete" data-taskid="<?php echo $data['id']; ?>" href='#'>Complete</a></td>

                </td>
                   
               </tr>
            <?php }
              mysqli_close($connection);

             ?>
               
           </tbody>

            </table>

            <select id="action" name="action">
              <option value="0">With Selected</option>  
               <option value="bulkdelete">Delete</option>
               <option value="bulkcomplete">Mark As Complete</option>
            </select>
             
              <input class="button-primary" id="bulksubmit" type="submit" value="Submit"></input>
           </form>
        
      <?php } ?>
<p>.....</p>
<h4>Add Task</h4>
<form method="POST" action="tasks.php">
    <fieldset>
        <?php 
      $added=$_GET['added']??'';
      if($added)
      {
        echo "<p>Task Successfullly Added</p>";
      }
        ?>
    <label for="task">Task</label>
    <input type="text" placeholder="EX:Task Details" name="task" id="task" >
    <label for="date">Date</label>
    <input type="text" placeholder="EX:2019-8-16|" name="date" id="date">
    <input type="hidden" name="action" value="add" >
    <input class="button-primary" type="submit" value="submit"> </input>
</fieldset>
    

</form>
        
    </div>
    <form action="tasks.php" method="post" id="completeform">
    <input type="hidden" name="action" value="complete">
    <input type="hidden" id="taskid" name="taskid">
</form>

<form action="tasks.php" method="post" id="incompleteform">
    <input type="hidden" name="action" value="incomplete">
    <input type="hidden" id="itaskid" name="taskid">
</form>

<form action="tasks.php" method="post" id="deleteform">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" id="dtaskid" name="taskid">
</form>

</body>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>

<script >

  ;(function ($)
  { $(document).ready(function ()
{
  $(".complete").on('click', function () {
                var id = $(this).data("taskid");
                $("#taskid").val(id);
                $("#completeform").submit();
            });

  $(".incomplete").on('click', function () {
                var id = $(this).data("taskid");
                $("#itaskid").val(id);
                $("#incompleteform").submit();
            });
  

  $(".delete").on('click', function () {
    if(confirm("Are you sure to delete this task?"))
      {
                var id = $(this).data("taskid");
                $("#dtaskid").val(id);
                $("#deleteform").submit();}
                
            });

 $("#bulksubmit").on('click', function () {
                if($("#action").val()=='bulkdelete')
                {
                  if(!confirm("Are you sure to delete?"))
                  {
                    return false;
                  }
                }
            });





});
  })(jQuery);
</script>
  


</html>