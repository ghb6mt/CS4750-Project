
<?php
require("connect-db.php");
require("friend-db.php");
$list = getAllFriends();

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['addBtn'])){
      addFriends($_POST['friendname'],$_POST['major'],$_POST['year']);
     // $list = getAllFriends(); // name, major, year
     // var_dump($list);
    }
    else if(!empty($_POST['updateBtn'])){

    }
    else if(!empty($_POST['updateConfirmBtn'])){
      updateFriendByName($_POST['friendname'],$_POST['major'],$_POST['year']);
      //$list = getAllFriends();
    }
    else if(!empty($_POST['deleteBtn'])){
      deleteFriend($_POST['friendToDelete']);

    }
    $list = getAllFriends();

  }
?>


<?php include("header.html"); ?>



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<form name="mainForm" action="simpleform.php" method="post"> 
  <div class="row mb-3 mx-3">
    Your name:
    <input type="text" class="form-control" name="friendname" required 
    value="<?php echo $_POST['friendToUpdateName']; ?>"/>  
    </div> 
    <div class="row mb-3 mx-3">
    Major:
    <input type="text" class="form-control" name="major" required 
    value="<?php echo $_POST['friendToUpdateMajor']; ?>"/>
    </div> 
    <div class="row mb-3 mx-3">
    Year:
    <input type="text" class="form-control" name="year" required 
    value="<?php echo $_POST['friendToUpdateYear']; ?>"/>
    </div> 
    <div class="row mb-3 mx-3">
        <input type="submit" value="Add friend" name="addBtn"
        class="btn btn-primary" title="Insert a friend ito a friends list">
  </div> 
  <div class="row mb-3 mx-3">
        <input type="submit" value="Confirm Update" name="updateConfirmBtn"
        class="btn btn-primary" title="Confirm update for the friend">
  </div> 
</form>   

<hr/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<h3> List of Friends </h3>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="30%">Name        
    <th width="30%">Major        
    <th width="30%">Year 
    <th width="30%">Update ?</th>
    <th width="30%">Delete?</th>
      

  </tr>
  </thead>
<?php foreach ($list as $friend): ?>
  <tr>
     <td><?php echo $friend['name']; ?></td>
     <td><?php echo $friend['major']; ?></td>        
     <td><?php echo $friend['year']; ?></td> 
    <form action="simpleform.php" method = "post">    
        <td><input type="submit" value ="Update" name="updateBtn" ></input></td>
        <input type="hidden" name="friendToUpdateName" value="<?php echo $friend['name']; ?>" />
        <input type="hidden" name="friendToUpdateMajor" value="<?php echo $friend['major']; ?>" />
        <input type="hidden" name="friendToUpdateYear" value="<?php echo $friend['year']; ?>" />
    </form>
    <form action="simpleform.php" method = "post">    
        <td><input type="submit" value ="Delete" name="deleteBtn" ></input></td>
        <input type="hidden" name="friendToDelete" value="<?php echo $friend['name']; ?>" />
    </form>         
  </tr>
<?php endforeach; ?>
</table>
</div>   
<?php include("footer.html"); ?>