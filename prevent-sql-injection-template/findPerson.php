<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">      
  <title>Example: Prevent SQL injection</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
</head>

<body>
<div class="container">

<h1>Find person's Info</h1>

<form name="mainForm" action="findPerson.php" method="post">
  <div class="form-group">
    Name:
    <input type="text" class="form-control" name="name" required />       
    <br/>    
    <font size=-1>(Try to retrieve all persons instead of a particular one/name, 
    using 
    <code>" OR "1=1</code> &nbsp;
    <br/>or combine the Person table with a table that has the same number of attributes 
    <code>" OR 1=1 UNION SELECT * FROM private where "1</code>)  
  </div>       
  <input type="submit" value="find" name="action" class="btn btn-dark" title="Find friend's info" />  
</form>  

  
</table>
        
</div>    
</body>
</html>
  