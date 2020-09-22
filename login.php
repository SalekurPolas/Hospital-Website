<?php include_once('php/database.php');
  if(isset($_SESSION['email'])){
    header("location: index.php");
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Hospital - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/login.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bree+Serif">
</head>
<body>
  <div class="title"><h1>Hospital</h1></div>
  <div class="container">
    <div class="login_form">
        <form id="submit_login_form" action="" method="post">
          <h2>Login</h2>
          <p>Username </p>
          <input type="Email" name="login_user_email" placeholder="Enter email" autocomplete="on" required>
          <p>Password</p>
          <input type="Password" name="login_user_password" placeholder="Enter password" required>
          <input type="submit" value="Sign In">
          <a href="password.php">Forget Password?</a>
          <p id="new_account">Don't have account? <a style="font-size: 16px;" href="registration.php">Register</a></p>
        </form>

        <?php
          if(isset($_POST['login_user_email']) && isset($_POST['login_user_password'])){
            $login_email = $_POST['login_user_email'];
            $login_password = $_POST['login_user_password'];
            
            $sql = "SELECT id, name, email, occupation, phone, password FROM users WHERE email = '$login_email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                if($login_password == $row["password"]){
                  $user_id = $row["id"];
                  $user_name = $row["name"];
                  $user_email = $row["email"];
                  $user_occupation = $row["occupation"];
                  $user_phone = $row["phone"];
                  $user_password = $row["password"];

                  $_SESSION['id'] = $user_id;
                  $_SESSION['name'] = $user_name;
                  $_SESSION['email'] = $user_email;
                  $_SESSION['occupation'] = $user_occupation;
                  $_SESSION['phone'] = $user_phone;
                  $_SESSION['password'] = $user_password;
                  header("location: index.php");
                }
                else {
                  echo "<p style='text-align:center; color:black; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: red;'>Incorrect Password!</p>";
                }
              }
            }
            else {
              echo "<p style='text-align:center; color:red; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: #bbb;'>Account Does not Exist!</p>";
            }
          }
        ?>
      </div>
  </div>
</body>
</html>