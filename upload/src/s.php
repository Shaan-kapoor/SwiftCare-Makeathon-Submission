<?php
// Database configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'swifty';

// Create database connection
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else{
    echo"Connection was successful<br>";
// If the form is submitted, insert the data into the database
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $desc = $_POST['desc'];
    $sql = "INSERT INTO registration (Name, Age, Gender, Description) VALUES ('$name', $age, '$gender', '$desc')";

if ($conn->query($sql) === TRUE) {
  // Get the weight of the problem from the disease table
  $sql = "SELECT weight FROM disease WHERE ill = '$desc'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Calculate the cost using the weight and age
    $row = $result->fetch_assoc();
    $weight = $row['weight'];
    $cost = $weight * $age;

    // Add the name and cost to the priority queue
    $priority_queue = new SplPriorityQueue();
    $priority_queue->insert($name, $cost);

    // Get the order of the name
    $order = null;
    foreach ($priority_queue as $key => $value) {
      if ($value === $name) {
        $order = $key + 1;
        break;
      }
    }

    // Get the doctor's name, location, and set number
    $sql = "SELECT name, location FROM doctor_db WHERE set_s = $order";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $doctor_name = $row['name'];
      $location = $row['location'];

      // Display the output
      echo "Name: $doctor_name<br>";
      echo "Location: $location";
    } else {
      echo "No doctors found for the given order.";
    }
  } else {
    echo "No weight found for the given problem.";
  }
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
}
}

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>SwiftCare Form</title>
  </head>
  <body>
    <h1>SwiftCare</h1>
    <form action ="/cwhph/s.php"  method = "POST">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required>

      <label for="age">Age</label>
      <input type="text" id="age" name="age" required>

      <label for="gender">Gender</label>
      <input type="text",id = "gender" name = "gender">

      <label for="medical-problem">Medical Problem</label>
      <input type="text", id = "desc" name = "desc">

      <button onclick="window.location.href='index.html'">Submit</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-HaIBNhB+G2QTW8jkgqrbqL0t2vvSpvO8dC2G7mO4zfsxA1vVb8J+6VoRXIaS+aSj" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js" integrity="sha512-P8zNYMDQf4uMA7V1dJc8B7ehzt+X9u+E7CEaDZkgPUECye6w5mJPKLOU6OaU6eDJP5QrA6O5+5Z5E5K3qzN0pg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="script.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>
 