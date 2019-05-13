<!DOCTYPE html>
<html>
  <head>
    <title> Add Visit </title>
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
  </head>
  <body>
    <nav class="navmain">
      <div class="homeLogout">
        <?php  echo $_SESSION['user']; ?>
        <a href="logout.php"> Logout</a>
        <a href="addClient.php"> New Client </a>
      </div>
      <h1>HealthOne Medical</h1>
    </nav>

    <?php

        # requires that we are able to connect to the database using are hidden php file
        require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

        # checks that the form was submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // errors array
            $errors = [];

            // checks for a the date of the visit
            if (empty($_POST['visitDate'])) {
                $errors[] = 'You forgot to enter the date of the visit.';
            } else {
                $date = mysqli_real_escape_string($dbc, trim($_POST['visitDate']));
            }

            // checks for the doctor
            if (empty($_POST['doctor'])) {
                $errors[] = 'You forgot to enter the doctor the visit was with.';
            } else {
                $doc = mysqli_real_escape_string($dbc, trim($_POST['doctor']));
            }

            // checks for the type of the visit
            if (empty($_POST['type'])) {
                $errors[] = 'You forgot to enter the type of the visit.';
            } else {
                $type = mysqli_real_escape_string($dbc, trim($_POST['type']));

                // checks the type of visit to see what other information should have been included
                if ($type == "New Issue") {

                    // checks for a initial diagnosis
                    if (empty($_POST['diagnosis'])) {
                        $errors[] = 'You forgot to enter the initial diagnosis of the prescription.';
                    } else {
                        $diagnosis = mysqli_real_escape_string($dbc, trim($_POST['diagnosis']));
                    }

                } else if ($type == "Follow-Up") {

                    // checks for a status
                    if (empty($_POST['diagnosis'])) {
                        $errors[] = 'You forgot to enter the status at this visit.';
                    } else {
                        $status = mysqli_real_escape_string($dbc, trim($_POST['status']));
                    }

                    // checks for a diagnosis
                    if (empty($_POST['diagnosis'])) {
                        $errors[] = 'You forgot to enter the initial diagnosis at the visit.';
                    } else {
                        $diagnosis = mysqli_real_escape_string($dbc, trim($_POST['diagnosis']));
                    }

                } else if ($type == "Checkup") {

                    // checks for the current blood pressure
                    if (empty($_POST['bloodPressure'])) {
                        $errors[] = 'You forgot to enter the client\'s blood pressure at the visit.';
                    } else {
                        $pressure = mysqli_real_escape_string($dbc, trim($_POST['bloodPressure']));
                    }

                    // checks for a height
                    if (empty($_POST['height'])) {
                        $errors[] = 'You forgot to enter the client\'s height at the visit.';
                    } else {
                        $height = mysqli_real_escape_string($dbc, trim($_POST['height']));
                    }

                    // checks for a weight
                    if (empty($_POST['weight'])) {
                        $errors[] = 'You forgot to enter the client\'s weight at the visit.';
                    } else {
                        $weight = mysqli_real_escape_string($dbc, trim($_POST['weight']));
                    }

                }
            }

            // checks for patient's id
            if (isset($_GET['id'])) {
                $pat = $_GET['id'];
            }

            // then it checks if the visit already exists
            $q = "SELECT COUNT(visit_id) FROM VISIT where patient_id = $pat and doctor_id = $doc and visitDate = '$date' and type = '$type' and diagnosis = '$diagnosis' and status = '$status' and bloodPressure = '$bloodPressure' and height = '$height' and weight = '$weight'";
            $r = @mysqli_query($dbc, $q);
            $row = mysqli_fetch_array($r, MYSQLI_NUM);
            $visits = $row[0];

            // checks if there were no errors
            if ($visits == 0) {
                if (empty($errors)) {
                    // inserts the new patient
                    $q = "INSERT INTO VISIT (patient_id, doctor_id, visitDate, type, diagnosis, status, bloodPressure, height, weight) VALUES ('$pat', '$doc', '$date', '$type', '$diagnosis',  '$status', '$bloodPressure', '$height', '$weight')";
                    $r = @mysqli_query($dbc, $q);
                } else {
                    # reports the errors
                    echo '<p> The following error(s) occured:<br>';
                    foreach ($errors as $msg) {
                        echo " - $msg<br>\n";
                    }
                    echo '</p><p> Please try again. </p>';
                }
            } else {
                echo '<p> The following error(s) occured:<br>';
                echo " - Visit already exists.";
            }

            // redirects user back to client page
            $patient_page = "http://shantim.smtchs.org/HealthOne_Medical/patient.php?id=" . $pat;
            echo "<script type='text/javascript'>window.top.location='$patient_page';</script>"; exit;

        }

        mysqli_close($dbc);
    ?>

  </body>
</html>
