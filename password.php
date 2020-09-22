<?php include_once('php/database.php');
  if(isset($_SESSION['email'])){
    header("location: index.php");
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Hospital - Forget Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/password.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bree+Serif">
  <script type="text/javascript" src="scripts/functions.js"></script>
</head>
<body>
  <div class="container">
      <div class="forget_form">
        <form action="" method="post">
          <h2>Forget Password?</h2>
          <p>Username </p>
          <input type="Email" name="password_user_email" placeholder="Enter email" required>
          <p>Birth Date </p>
          <input type="Date" name="password_birth_date" onchange="ChangeDateFormat(this, 'y');" required>
          <input type="submit" name="password_submit_button" onclick="ChangePasswordRequest()" value="Send Request">
          <p class="extra_link">Remember Password? <a href="login.php">Login</a></p>
          <p id="extra_link_register">Don't have account? <a href="registration.php">Register</a></p>
        </form>
        <?php
          $url = "change.php";
          if(isset($_POST['password_user_email']) && isset($_POST['password_birth_date'])) {
            $password_email = $_POST['password_user_email'];
            $password_date = $_POST['password_birth_date'];

            $PasswordSql = "SELECT bdate FROM users WHERE email = '$password_email'";
            $PasswordResult = $conn->query($PasswordSql);

            if ($PasswordResult->num_rows > 0) {
              while($row = $PasswordResult->fetch_assoc()) {
                if($password_date == $row["bdate"]){
                  $_SESSION['password_email'] = $password_email;
                  header('Location: '.$url);
                }
                else {
                  echo "<p style='text-align:center; color:black; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: red;'>Incorrect Birth Date!</p>";
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