<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Student Registration Page</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <style>
  table {
    width: 100%;
  }
  td {
    margin:10px;
    padding:10px;
  }
  </style>
    <div class="container">
    <?php
      $mysqli = new mysqli("localhost", "root", "", "xss");
      if ($mysqli->connect_errno) echo "Failed (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;


      if ($_GET == null ||
          $_GET['name'] == null ||
          $_GET['address'] == null ||
          $_GET['date_of_birth'] == null) {
    ?>
    <form action="" method="GET">
    <div class="form-group">
      <br>
      <h2>Student List</h2><br>
<table border=1>
<?php
$sql = "SELECT name, address, date_of_birth FROM students";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<tr><td>".$row["name"]."</td><td>".$row["address"]."</td><td>".$row["date_of_birth"]."</td></tr>";
    }
} else {
    echo "0 results";
}
?>
</table>
      <br>
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

CREATE TABLE IF NOT EXISTS `students` (
  `name` varchar(64) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_of_birth` varchar(10) DEFAULT NULL,
  UNIQUE KEY `name` (`name`)
)

INSERT INTO `students` (`name`, `address`, `date_of_birth`) VALUES
('Nicolas', '12 chemin du Village A', '12.12.2012'),
('Pierre', '27 chemin du village B', '12.12.2012'),
('Paul', '27 chemin du village C', '13.12.2012'),
('Alain', '23 chemin du village D', '14.12.2012');

*/
?>
