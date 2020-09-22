<?php include_once('php/database.php');
  if(!isset($_SESSION['password_email'])) {
    header('location: password.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Bachelor - Change Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/password.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bree+Serif">
</head>
<body>
  <div class="container">
      <div class="change_form">
        <form action="" method="post">
          <h2>Create Password</h2>
          <p>New Password *</p>
          <input type="Password" name="change_user_password" placeholder="Enter new password" required>
          <p>Re-Enter Password *</p>
          <input type="Password" name="change_re_password" placeholder="Re enter password" required>
          <input type="submit" name="change_submit_button" value="Change Password">
          <p class="extra_link">Remember Password? <a href="login.php">Login</a></p>
        </form>

        <?php
        if(isset($_SESSION['password_email']) && isset($_POST['change_user_password']) && isset($_POST['change_re_password'])) {
          $change_email = $_SESSION['password_email'];
          $newPassword = $_POST['change_user_password'];
          $rePassword = $_POST['change_re_password'];

          if($newPassword == $rePassword) {
            $sql = "UPDATE users SET password = '$newPassword' WHERE email = '$change_email'";
            mysqli_query($conn, $sql);
            header('location: php/logout.php');
          }
          else {
            echo "<p style='text-align:center; color:black; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: red;'>Passwords Didn't Match!</p>";
          }
        }
      ?>
      </div>
    </div>
</body>
</html>