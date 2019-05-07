<!DOCTYPE html>
<html>
  <head>
    <title> Add Client </title>
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
  </head>
  <body>
    <nav class="navmain">
      <div class="homeLogout">
        <?php  echo $_SESSION['user']; ?><br>
        <a href="logout.php"> Logout</a><br>
        <a href="addClient.php"> New Client </a>
      </div>
      <a href="home.php"><h1>HealthOne Medical</h1></a>
    </nav>

    <form action = "addClient.php" method = "post">
      <h3>First Name: <input type = "text" name = "fName" size = "15" maxlength="30"></h3>
      <h3>Last Name: <input type = "text" name = "lName" size = "15" maxlength="30"></h3>
      <h3>Address: <input type = "text" name = "address" size = "30" maxlength="50"></h3>
      <h3>Phone Number: <input type="numbernumber" name = "pNum" pattern="\d*" minLength="10" maxlength="10"></h3>
      <h3>Email: <input type = "email" name = "email" size = "25" maxlength="30"></h3>
      <h3>Primary Doctor: </h3>
        <label>First Name - </label><input type = "text" name = "dFirstName" size = "15" maxlength="30"></h3>
        <label>Last Name - </label><input type = "text" name = "dLastName" size = "15" maxlength="30"></h3>
      <h3>Level of Coverage: </h3>
        <select name = "coverage">
          <option value = "Bronze">Bronze</option>
          <option value = "Silver">Silver</option>
          <option value = "Gold">Gold</option>
        </select>
        <br>
      <a href="home.php"> <input id="submit" type="submit" name="submit" value="Add Client"></a>
    </form>

  </body>
</html>

<?php
    # requires that we are able to connect to the database using are hidden php file
    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    # checks that the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // errors array
        $errors = [];

        // checks for a first name
        if (empty($_POST['fName'])) {
            $errors[] = 'You forgot to enter the client\'s first name.';
        } else {
            $first_name = mysqli_real_escape_string($dbc, trim($_POST['fName']));
        }

        // checks for a last name
        if (empty($_POST['lName'])) {
            $errors[] = 'You forgot to enter the client\'s last name.';
        } else {
            $last_name = mysqli_real_escape_string($dbc, trim($_POST['lName']));
        }

        // checks for an address
        if (empty($_POST['address'])) {
            $errors[] = 'You forgot to enter the client\'s address.';
        } else {
            $address = mysqli_real_escape_string($dbc, trim($_POST['address']));
        }

        // checks for a phone number
        if (empty($_POST['pNum'])) {
            $errors[] = 'You forgot to enter the client\'s phone number.';
        } else {
            $phone_number = mysqli_real_escape_string($dbc, trim($_POST['pNum']));
        }

        // checks for an email
        if (empty($_POST['email'])) {
            $errors[] = 'You forgot to enter the client\'s email.';
        } else {
            $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
        }

        // checks for a primary care doctor first name
        if (empty($_POST['dFirstName'])) {
            $errors[] = 'You forgot to enter the client\'s primary care doctor\'s first name.';
        } else {
            $dFirst = mysqli_real_escape_string($dbc, trim($_POST['dFirstName']));
        }

        // checks for a primary care doctor first name
        if (empty($_POST['dLastName'])) {
            $errors[] = 'You forgot to enter the client\'s primary care doctor\'s last name.';
        } else {
            $dLast = mysqli_real_escape_string($dbc, trim($_POST['dLastName']));
        }

        // checks for the level of coverage
        if (empty($_POST['coverage'])) {
            $errors[] = 'You forgot to enter the client\'s level of insurance coverage.';
        } else {
            $coverage = mysqli_real_escape_string($dbc, trim($_POST['coverage']));
        }




        $q = "SELECT COUNT(patient_id) FROM PATIENT where firstName = '$first_name' and lastName = '$last_name' and address = '$address'";
        $r = @mysqli_query($dbc, $q);
        $row = mysqli_fetch_array($r, MYSQLI_NUM);
        $patients = $row[0];

        // checks if there were no errors
        if ($patients == 0) {
          if (empty($errors)) {

              // gets the primary care doctors id
              $q = "SELECT doctor_id FROM DOCTOR where firstName = '$dFirst' and lastName = '$dLast'";
              $r = @mysqli_query($dbc, $q);
              $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

              // checks if that doctor exists
              if (mysqli_num_rows($r) == 1) {
                $doc = $row['doctor_id'];

                // inserts the new patient
                $q = "INSERT INTO PATIENT (firstName, lastName, address, phoneNumber, email, primaryDoctor) VALUES ('$first_name', '$last_name', '$address', '$phone_number', '$email',  $doc)";
                $r = @mysqli_query($dbc, $q);

                // inserts patient's insurance plan
                $q = "INSERT INTO INSURANCE (name) VALUES ('$coverage')";
                $r = @mysqli_query($dbc, $q);

          if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['hospitalname'])){
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $hospitalname = $_POST['hospitalname'];
            $q = "INSERT INTO HOSPTAL (firstname, lastname, hospitalname) VALUES ('$firstname', '$lastname', '$hospitalname')";
          }


                // go back to home page


              } else {
                echo '<p> The following error(s) occured:<br>';
                echo " - Doctor entered doesn't exist in table.";
                echo '<p> Please enter the doctor\'s information </p>';

                // go to doctor form

                echo '<form action="addClient.php" method="post">';
                echo '<label>First Name</label><input type="text" name="firstname">';
                echo '<label>Last Name</label><input type="text" name="lastname">';
                echo '<select name="hospitalname">';
                  $q = "SELECT * FROM HOSPITAL";
                  $r = @mysqli_query($dbc, $q);
                  $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

                  foreach($r as $results){
                    echo '<option value='. $results['name'] . '>' . $results['name'] . '</option>';
                  }
                echo '</select>';
                echo '<input type="submit" name="addDoctor" id="submit">';
                echo '</form>';

              }

          } else {

              # reports the errors
              echo '<p> The following error(s) occured:<br>';
              foreach ($errors as $msg) {
                  echo " - $msg<br>\n";
              }
              echo '</p><p> Please try again. </p>';

            // end of errors if statement
          }
        } else {
            echo '<p> The following error(s) occured:<br>';
            echo " - Patient already exists.";
        }

    }

    echo "<a href='home.php'>Go Back</a>";
    mysqli_close($dbc);
    include("footer.html");
?>
