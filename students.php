<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Student Registration Page</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
    <?php
      if ($_GET == null ||
          $_GET['name'] == null ||
          $_GET['address'] == null ||
          $_GET['date_of_birth'] == null) {
    ?>
    <form action="" method="GET">
    <div class="form-group">
      <h2>Student Registration</h2><br>
      <label for="name">Name</label>
      <input class="form-control" type="text" value="" name="name"><br>
      <label for="address">Address</label>
      <input class="form-control" type="text" value="" name="address"><br>
      <label for="date_of_birth">Date of birth</label>
      <input class="form-control" type="text" value="" name="date_of_birth"><br>
      <input class="btn btn-default" type="submit" value="Register">
      </div>
    </form>    
    <?php
      } else {
        $mysqli = new mysqli("localhost", "root", "", "xss");
        if ($mysqli->connect_errno) echo "Failed (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;

        // Variables utilisées pour l'injection SQL
        $name          = $_GET['name'];
        $address       = $_GET['address'];
        $date_of_birth = $_GET['date_of_birth'];

        // Requête SQL vulnérable
        $query = "INSERT INTO students VALUES(\"$name\", \"$address\", \"$date_of_birth\")";

        if (!$mysqli->multi_query($query)) {
          echo "<div class='alert alert-danger' role='alert'><strong>Multi query failed:</strong> (" . $mysqli->errno . ") " . $mysqli->error."</div>";
        } else {
          echo "<br><br><br><div class='alert alert-success' role='alert'><strong>Registration success for student $name !</strong></div>";
          echo "<div style='height:800px'></div>";
          echo "<pre>$query</pre><br><br>";
        }
    }
    ?>
    </div>
  </body>
</html>
<?php

/*
// URL
// name=robert",'',''); delete from students;&address='xss'&date_of_birth='xss'

// ENTER
// name=robert",'',''); delete from students;

CREATE TABLE `students` (
  `name` varchar(64),
  `address` varchar(255),
  `date_of_birth` varchar(10)
);
*/
?>
