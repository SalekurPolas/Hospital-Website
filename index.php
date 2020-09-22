<?php include_once('php/database.php');
  if(!isset($_SESSION['email'])){
    header("location: registration.php");
  }
  else {
    $user_id = $_SESSION['id'];
    $user_name = $_SESSION['name'];
    $user_email = $_SESSION['email'];
    $user_occupation = $_SESSION['occupation'];

    if($user_occupation == "doctor") {
      $doctors_check = mysqli_query($conn, 'select 1 from `doctors`');

      if ($doctors_check == TRUE) {
        $doctor_info_sql = "SELECT hospital, specialist, fee, availability FROM doctors WHERE id = '$user_id'";
        $doctor_info_result = $conn->query($doctor_info_sql);
        if ($doctor_info_result->num_rows > 0) {
          while($doctor_info_row = $doctor_info_result->fetch_assoc()) {
            $_SESSION['doctor_hospital'] = $doctor_info_row["hospital"];
            $_SESSION['doctor_specialist'] = $doctor_info_row["specialist"];
            $_SESSION['doctor_fee'] = $doctor_info_row["fee"];
            $_SESSION['doctor_availability'] = $doctor_info_row["availability"];
          }
        }
      } else {
        $doctors_create = "CREATE TABLE doctors (
          id INT(10) PRIMARY KEY,
          hospital VARCHAR(30),
          specialist VARCHAR(50),
          fee VARCHAR(20),
          availability VARCHAR(30)
        )";

        if (!mysqli_query($conn, $doctors_create)) {
          echo "Error found! Please try again later. <br>";
        }
      }

      echo '<style type="text/css">
        #id_doctor_search {
          display: none;
        }
        #id_doctor_info, #id_appointment_search {
          display: block;
        }
      </style>';
    }
    else{
      echo '<style type="text/css">
        #id_doctor_search {
          display: block;
        }
        #id_doctor_info, #id_appointment_search {
          display: none;
        }
      </style>';
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Hospital - Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bree+Serif">
  <script src="scripts/chat.js" type="text/javascript"></script>
  <script src="scripts/functions.js" type="text/javascript"></script>
  
  <!--css design-->
  <style>
    table {
      width: 100%;
      padding: 5px;
      margin-top: 10px;
      border-radius: 4px;
      background-color: #bbb;
    }
    th, td{
      border: 1px solid black;
      border-collapse: collapse;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <!--header start-->
  <header>
    <div class="top_nav">
      <!--header logo start-->
      <div class="nav_left">
        <a href="../Hospital">Hospital</a>
      </div>
      <!--header logo end-->

      <!--header menu start-->
      <div class="nav_right">
        <a href="../Hospital">Home</a>
        <a href="doctors.php">Doctors</a>
        <a href="members.php">Members</a>
        <a class="active_menu" href="php/logout.php">Logout</a>
      </div>
      <!--header menu end-->
    </div>
  </header>
  <!--header end-->

  <!--container start-->
  <div class="container">
    <!--container left start-->
    <div class="left">
      <div class="user">
        <h3>Welcome <?php if(isset($user_name)) echo $user_name; ?></h3>
        <h4><?php if(isset($user_email)) echo $user_email; ?></h4>
      </div>

      <div id="id_doctor_info" class="doctor_info">
        <h3>Doctor Infomations</h3>
        <h4>Hospital: <?php if(isset($_SESSION['doctor_hospital'])){echo $_SESSION['doctor_hospital'];} ?></h4>
        <p>Specialist: <?php if(isset($_SESSION['doctor_specialist'])){echo $_SESSION['doctor_specialist'];} ?></p>
        <p>Fee: <?php if(isset($_SESSION['doctor_fee'])){echo $_SESSION['doctor_fee'];} ?></p>
        <p>Status: <?php if(isset($_SESSION['doctor_availability'])){echo $_SESSION['doctor_availability'];} ?></p>
        <p style="cursor: pointer; color: green;" onclick="ShowEditDoctorInfo()">Edit Info</p>
      </div>
    </div>
    <!--container left start-->

    <!--container middle start-->
    <div class="main">

      <!--editing doctor info-->
      <div id="id_edit_doctor_info" class="edit_doctor_info">
        <form method="post" action="">
          <p>Doctor Hospital</p>
          <input type="text" name="edit_doctor_hospital" value="<?php if(isset($_SESSION['doctor_hospital'])){echo $_SESSION['doctor_hospital'];} ?>">
          <p>Doctor Specialist</p>
          <input type="text" name="edit_doctor_specialist" value="<?php if(isset($_SESSION['doctor_specialist'])){echo $_SESSION['doctor_specialist'];} ?>">
          <p>Doctor Fee</p>
          <input type="text" name="edit_doctor_fee" value="<?php if(isset($_SESSION['doctor_fee'])){echo $_SESSION['doctor_fee'];} ?>">
          <p>Doctor Avaiability</p>
          <select name="edit_doctor_availability" required>
            <option value="Available">Available</option>
            <option value="Unavailable">Unavailable</option>
          </select><br>
          <input type="submit" value="Update">
        </form>

        <!--handling php for editing doctor info-->
        <?php
          if(isset($_POST['edit_doctor_fee']) && isset($user_id)) {
            $doctor_hospital = $_POST['edit_doctor_hospital'];
            $doctor_specialist = $_POST['edit_doctor_specialist'];
            $doctor_fee = $_POST['edit_doctor_fee'];
            $doctor_availability = $_POST['edit_doctor_availability'];
            
            $DoctorSearchSql = "SELECT id FROM doctors WHERE id = '$user_id'";
            $DoctorSearchResult = $conn->query($DoctorSearchSql);

            if ($DoctorSearchResult->num_rows > 0) {
              $UpdateSql = "UPDATE doctors SET hospital = '$doctor_hospital', specialist = '$doctor_specialist', fee = '$doctor_fee', availability = '$doctor_availability' WHERE id = '$user_id'";

              if (mysqli_query($conn, $UpdateSql)) {
                header("location: ../Hospital");
              }
            } else {
              $CreateSql = "INSERT INTO doctors (id, hospital, specialist, fee, availability) VALUES('$user_id', '$doctor_hospital', '$doctor_specialist', '$doctor_fee', '$doctor_availability')";

              if (mysqli_query($conn, $CreateSql)) {
                header("location: ../Hospital");
              }
            }
          }
        ?>
      </div>

      <!--creating doctor appointment-->
      <div id="id_create_appointment" class="create_appointment">
        <form method="post">
          <p id="doctor_info"></p>
          <input type="number" name="appointment_doctor_id" placeholder="Enter Doctor ID">
          <p>Fee</p>
          <input type="text" name="appointment_fee" placeholder="Enter Appointment Fee">
          <p>Patient Name</p>
          <input type="text" name="appointment_patient_id" value="<?php echo($user_name) ?>" disabled>
          <p>Date</p>
          <input type="Date" name="appointment_adate" onchange="ChangeDateFormat(this, 'y');" required>
          <p>Disease</p>
          <input type="text" name="appointment_disease" required><br>
          <input type="submit" value="Submit">
        </form>

        <!--handling php for creating doctor appointment-->
        <?php
          if (isset($_POST['appointment_doctor_id']) && isset($_POST['appointment_fee']) && isset($_POST['appointment_adate']) && isset($_POST['appointment_disease'])) {
            $doctor_id = $_POST['appointment_doctor_id'];
            $doctor_fee = $_POST['appointment_fee'];
            $appointment_adate = $_POST['appointment_adate'];
            $appointment_disease = $_POST['appointment_disease'];

            $appointments_check = mysqli_query($conn, 'select 1 from `appointments`');
        
            if ($appointments_check == FALSE) {
              $appointments_table = "CREATE TABLE appointments (
                id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                doctor INT(10),
                patient INT(10),
                fee VARCHAR(20),
                adate VARCHAR(20),
                disease VARCHAR(100)
              )";

              if (!mysqli_query($conn, $appointments_table)) {
                echo "Error found! Please try again later. <br>";
              }
            }

            $CreateAppointmentSql = "INSERT INTO appointments (doctor, patient, fee, adate, disease) VALUES('$doctor_id', '$user_id', '$doctor_fee', '$appointment_adate', '$appointment_disease')";

            if (mysqli_query($conn, $CreateAppointmentSql)) {
              header("location: ../Hospital");
            }
          }
        ?>
      </div>

      <!--viewing doctor appointment-->
      <div id="id_view_appointment" class="view_appointment">
        <form>
          <p id="appointment_id"></p>
          <p id="patient_name"></p>
          <p id="appointment_fee"></p>
          <p id="appointment_adate"></p>
          <p id="appointment_disease"></p>
        </form>
      </div>

    </div>
    <!--container middle end-->


    <!--container right start-->
    <div class="right">
      <div class="important_info">
        <marquee>Welcome to Bachelor website. It's a group Database project developed by <a href="https://www.facebook.com/SalekurPolas3">Salekur Rahaman</a>, <a href="https://www.facebook.com/profile.php?id=100003164965915">Ania Chowdhury</a> and <a href="https://www.facebook.com/profile.php?id=100006116749308">Syeda Tasmiah Asad</a>.</marquee>
      </div>
      <div class="notice">
        <h3 style="text-align: center;">Notice</h3>
        <p>There is no notice at this moment please try again later or refresh your browser, thank you.</p>
      </div>

      <!--searching appointment-->
      <div id="id_appointment_search" class="appointment_search">
        <form action="" method="post">
          <h3>Search Appointment</h3>
          <input type="Date" name="appointment_search_date" onchange="ChangeDateFormat(this, 'y');" required>
          <input type="submit" name="appointment_search_button" value="Search">
        </form>

        <!--handling appointment appointment search in php-->
        <?php
          if (isset($_POST['appointment_search_date'])) {
            $appointments_check = mysqli_query($conn, 'select 1 from `appointments`');

            if ($appointments_check == FALSE) {
              echo "<p style='text-align:center; color:red; width: 100%; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: #bbb;'>No Appointment Found!</p>";
            } else {
              $AppointmentSearchValue = $_POST['appointment_search_date'];
            
              $AppointmentSearchSql = "SELECT id, doctor, patient, fee, adate, disease FROM appointments WHERE adate = '$AppointmentSearchValue'";
              $AppointmentSearchResult = $conn->query($AppointmentSearchSql);

              if ($AppointmentSearchResult->num_rows > 0) {
                $counter = 0;
                ?>
                  <table>
                    <tr>
                      <th>No.</th>
                      <th>Name</th>
                      <th>Action</th>
                    </tr>
                    <?php
                      while ($AppointmentRow = $AppointmentSearchResult -> fetch_assoc()) {
                        if($AppointmentRow["doctor"] == $user_id) {
                          $appointment_id = $AppointmentRow["id"];
                          $appointment_doctor_id = $AppointmentRow["doctor"];
                          $appointment_patient_id = $AppointmentRow["patient"];
                          $appointment_fee = $AppointmentRow["fee"];
                          $appointment_adate = $AppointmentRow["adate"];
                          $appointment_disease = $AppointmentRow["disease"];

                          $sql = "SELECT name FROM users WHERE id = '$appointment_patient_id'";
                          $Result = $conn->query($sql);

                          if ($Result->num_rows > 0) {
                            while ($ResultRow = $Result -> fetch_assoc()) {
                              $patient_name = $ResultRow["name"];

                              $counter = $counter + 1;
                              ?>
                                <!--adding new row start-->
                                <tr>
                                  <th><?php echo "<p>".$counter.".</p>"; ?></th>
                                  <th><?php echo $patient_name; ?></th>
                                  <th><p style="cursor: pointer; color: green" onclick="ShowAppointmentDetails('<?php echo $appointment_id ?>', '<?php echo $patient_name ?>', '<?php echo $appointment_fee ?>', '<?php echo $appointment_adate ?>', '<?php echo $appointment_disease ?>')">Details</p></th>
                                </tr>
                                <!--adding new row end-->
                              <?php
                            }
                          }
                        }
                      }
                      if($counter == 0) {
                        echo "<p style='text-align:center; color:red; width: 100%; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: #bbb;'>No Appointment Found!</p>";
                      }
                    ?>
                  </table>
                <?php
              } else {
                echo "<p style='text-align:center; color:red; width: 100%; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: #bbb;'>No Appointment Found!</p>";
              }
            }
          }
        ?>
      </div>

      <div id="id_doctor_search" class="doctor_search">
        <form action="" method="post">
          <h3>Search Doctor</h3>
          <input type="text" name="search_doctor" placeholder="Search Doctor" required>
          <input type="submit" name="search_doctor_button" value="Search">
        </form>

        <!--displaying search value start-->
        <?php
          if (isset($_POST['search_doctor'])) {
            $DoctorSearchValue = $_POST['search_doctor'];
            
            $DoctorSearchSql = "SELECT id, name, occupation FROM users WHERE name LIKE '%".$DoctorSearchValue."%'";
            $DoctorSearchResult = $conn->query($DoctorSearchSql);

            if ($DoctorSearchResult->num_rows > 0) {
              $counter = 0;
              ?>
                <table>
                  <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Action</th>
                  </tr>
                  <?php
                    while ($DoctorRow = $DoctorSearchResult -> fetch_assoc()) {
                      if($DoctorRow["occupation"] == "doctor") {
                        $doctor_id = $DoctorRow["id"];
                        $doctor_name = $DoctorRow["name"];
                        $counter = $counter + 1;

                        $DoctorsInfoSql = "SELECT hospital, specialist, fee FROM doctors WHERE id = '$doctor_id'";
                        $DoctorsInfoResult = $conn->query($DoctorsInfoSql);

                        if ($DoctorsInfoResult->num_rows > 0) {
                          while ($DoctorsInfoRow = $DoctorsInfoResult -> fetch_assoc()) {
                            $doctor_hospital = $DoctorsInfoRow["hospital"];
                            $doctor_specialist = $DoctorsInfoRow["specialist"];
                            $doctor_fee = $DoctorsInfoRow["fee"];
                              ?>
                              <!--adding new row start-->
                              <tr>
                                <th><?php echo "<p>".$counter.".</p>"; ?></th>
                                <th><?php echo $doctor_name; ?></th>
                                <th><p style="cursor: pointer; color: green" onclick="ShowCreateAppointment('<?php echo $doctor_id ?>', '<?php echo $doctor_name ?>', '<?php echo $doctor_hospital ?>', '<?php echo $doctor_specialist ?>', '<?php echo $doctor_fee ?>')">Book</p></th>
                              </tr>
                              <!--adding new row end-->
                            <?php
                          }
                        }
                      }
                    }
                    if($counter == 0) {
                      echo "<p style='text-align:center; color:red; width: 100%; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: #bbb;'>No Doctor Found!</p>";
                    }
                  ?>
                </table>
              <?php
            } else {
              echo "<p style='text-align:center; color:red; width: 100%; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: #bbb;'>No Doctor Found!</p>";
            }
          }
        ?>
        <!--displaying search value end-->
      </div>
    </div>
    <!--container right end-->

  </div>
  <!--container end-->

  <!--page footer start-->
  <footer>
    <p>Copyright all right reserved by <a href="../Hospital">Hospital</a></p>
  </footer>
  <!--page footer end-->
</body>
</html>