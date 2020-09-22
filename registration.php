<?php include_once('php/database.php');
  if(isset($_SESSION['email'])){
    header("location: index.php");
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Hospital - Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/registration.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bree+Serif">
  <script type="text/javascript" src="scripts/functions.js"></script>
</head>
<body>
  	<div class="container">
    	<div class="left">
    		<div class="left_text">
    			<h1>Welcome to Hospital</h1>
    			<p>The ultimate solution of Bachelor. Bachelor will calculate and save your everydays meal and cost, don't need to note them. So it will be helpful, accurate and time saving for your bachelor life. If you are a new then register now.</p>
          <button type="button" onclick="alert('Please register first offer will automatically come to you, thanks. It was a joke :)')">Offer Available for new registration *</button>
    		</div>
    	</div>
    	<div class="right">
      		<div class="registration">
        		<form id="registration_form" action="" method="post">
          			<h2>Create New Account</h2>
          			<p>Full Name *</p>
          			<input type="text" name="registration_user_name" placeholder="Enter full name" required>
          			<p>Username *</p>
          			<input type="Email" name="registration_user_email" placeholder="Enter email" required>
          			<p>Birth Date *</p>
                <input type="Date" name="registration_user_date" onchange="ChangeDateFormat(this, 'y');" required>
                <p>Occupation *</p>
                <select name="registration_user_occupation" required>
                  <option value="patient">Patient</option>
                  <option value="doctor">Doctor</option>
                  <option value="student">Student</option>
                  <option value="others">Others</option>
                </select>
                <p>Phone No *</p>
          			<input type="text" name="registration_user_phone" placeholder="Enter phone number" required>
          			<p>Password *</p>
          			<input type="Password" name="registration_user_password" placeholder="Enter password" required>
          			<input id="registration_submit" type="submit" value="Register">
          			<h5 style="font-size: 11px;"><i>* required</i></h5>
          			<h3 style="font-size: 16px;">Already Registered? <a href="login.php">Login</a></h3>
                <h3 style="font-size: 13px;"><a href="https://salekur.blogspot.com/p/privacy-policy.html" target="_blank">Terms & conditions</a></h3>
        		</form>

            <?php
              if (isset($_POST['registration_user_name'])) {
                $name = $_POST['registration_user_name'];
                $email = $_POST['registration_user_email'];
                $bdate = $_POST['registration_user_date'];
                $occupation = $_POST['registration_user_occupation'];
                $phone = $_POST['registration_user_phone'];
                $password = $_POST['registration_user_password'];
                
                $search = "SELECT * FROM users WHERE email = '$email'";
                $account = mysqli_query($conn, $search);
                if(mysqli_num_rows($account) > 0) {
                    echo "<p style='text-align:center; color:black; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: red;'>Account already exist!</p>";
                }
                else {
                  $sql = "INSERT INTO users (name, email, bdate, occupation, phone, password)
                  VALUES('$name', '$email', '$bdate', '$occupation', '$phone', '$password')";

                  if(mysqli_query($conn, $sql)) {
                    header("location: php/logout.php");
                  }
                  else {
                    echo "<p style='text-align:center; color:red; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: #bbb;'>Registration Failed!</p>";
                  }
                }
              }
            ?>
      		</div>
    	</div>
  	</div>
</body>
</html>