<?php
  $login = false;
  $showError = false;
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    include "dbConnection.php";
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM `user` WHERE `username` = '$username'";
    $result = mysqli_query($conn,$sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
      while ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
          $login = true;
          session_start();
          $_SESSION["logedin"] = true;
          $_SESSION["username"] = $username;
          header("location: welcome.php");
        }else {
          $showError =  "Password dont match";
        }
      }
    
    }else {
      $showError =  "Username dont exiest";
    } 
    
  }
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome to loginSystem</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <?php include "nav.php";
    if ($login) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Login Successfully
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    if ($showError) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                ' . $showError . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
  ?>
  <div class="container col-4 mt-5">
    <h2 class="text-center">LogIn to our Website</h2>
    <form action="login.php" method="POST" class="mt-5">
      <div class="mb-3">
        <label for="username" class="form-label">UsernName</label>
        <input type="text"  class="form-control" id="username" name="username">
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>