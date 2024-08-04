<?php
$showalert = false;
$showerror = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include "dbConnection.php";
  $username = $_POST["username"];
  $password = $_POST["password"];
  $cpassword = $_POST["cpassword"];
  //check whether a recoard was exist or not
  $exiestSql = "SELECT * FROM `user` WHERE `username`='$username'";
  $exiestResult = mysqli_query($conn,$exiestSql);
  $exiestNum = mysqli_num_rows($exiestResult);
  if ($exiestNum > 0) {
    $showerror = "Username Already Exiest";
  } else {
    //  Insert recoard
      if ($password == $cpassword) {
        $hash = password_hash($password,PASSWORD_DEFAULT);
        $sql = "INSERT INTO `user` (`username`, `password`) VALUES ('$username', '$hash');";
        $result = mysqli_query($conn, $sql);
        if ($result) {
          $showalert = true;
        } else {
          echo "Error : " . mysqli_error($conn);
        }
      } else {
        $showerror = "Password & confirmPassword do not match";
      }
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
  <?php require "nav.php";
  if ($showalert) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              Signup Successfully. Now you can Login 
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }
  if ($showerror) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              ' . $showerror . '
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }
  ?>

  <div class="container col-4 mt-5">
    <h2 class="text-center">SignUp to our Website</h2>
    <form action="signup.php" method="POST" class="mt-5">
      <div class="mb-3">
        <label for="username" class="form-label">UsernName</label>
        <input maxlength="11" type="text" class="form-control" id="username" name="username">
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input maxlength="8" type="password" class="form-control" id="password" name="password">
      </div>
      <div class="mb-3">
        <label for="cpassword" class="form-label">Confirm Password</label>
        <input maxlength="8" type="password" class="form-control" id="cpassword" name="cpassword">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>