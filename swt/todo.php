


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet"
     href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <title>My ToDo</title>    
</head> 
<body>

<div class="container">
<h1> My ToDo     
  <form action="todo.php" method="post">    
    <div class="mb-3 mt-3">     
      <label for="taskdesc" class="form-label">Task</label>
      <input type="text" class="form-control" name="taskdesc" /> 
    </div>
    <div class="mb-3">
      <label for="duedate" class="form-label">Due date
      <input type="text" class="form-control" name="duedate" />
    </div>            
    <div class="form-check">
      <input class="form-check-input" type="radio" name="priority" value="normal" />
      <label class="form-check-label" for="normalRadio">Normal</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="priority" value="high" />
      <label class="form-check-label" for="highRadio">High</label>
    </div>             
    <div class="d-grid gap-2 mt-3">
      <input type ="submit" value="Add Task" name="add"  
             class="btn btn-dark" title="Add a task to My ToDo" />   
    </div>                
  </form>
</div>
<?php 
//GOT THIS FROM UPSORN RECORDING LAST YEAR
session_start();
$current_id = 0;
if(isset($_SESSION))
  $current_id = count($_SESSION) + 1;
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
   if (!empty($_POST['taskdesc']) && 
       !empty($_POST['duedate']) && 
       !empty($_POST['priority']))
   {
    //GOT THIS FROM UPSORN RECORDING FROM LAST YEAR
    $_SESSION['task'.$current_id] = $_POST['taskdesc']. " | " . 
    $_POST['taskdesc'] . " | " . $_POST['priority'];
      echo "You entered " . $_POST['taskdesc'] . " | " . 
            $_POST['taskdesc'] . " | " . $_POST['priority'] . "<br/>";
   }
   foreach($_SESSION as $k => $v)
    echo $k . " -->" . $v ."<br>";


} 


?> 
</body>