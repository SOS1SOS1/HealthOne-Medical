<!DOCTYPE html>
<html>
  <head>
    <title> Add Client </title>
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
  </head>
  <body>

    <form action = "addClient.php" method = "post">
      <h3>First Name: <input type = "text" name = "fName" size = "15" maxlength="30"></h3>
      <h3>Last Name: <input type = "text" name = "lName" size = "15" maxlength="30"></h3>
      <h3>Address: <input type = "text" name = "address" size = "30" maxlength="50"></h3>
      <h3>Phone Number: <input type="text" name = "pNum" pattern="\d*" maxlength="10"></h3>
      <h3>Email: <input type = "text" name = "email" size = "25" maxlength="30"></h3>
      <h3>Level of Coverage: </h3>
        <select name = "coverage">
          <option value = "Bronze"><label>Bronze</label>
          <option value = "Silver"><label>Silver</label>
          <option value = "Gold"><label>Gold</label>
        </select>
      <h3><input class = "submit" type = "submit" name - "submit" value = "Add Client"></h3>
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

        // checks for the level of coverage
        if (empty($_POST['coverage'])) {
            $errors[] = 'You forgot to enter the client\'s level of insurance coverage.';
        } else {
            $coverage = mysqli_real_escape_string($dbc, trim($_POST['coverage']));
        }


        // WORK HERE

        // checks if there were no errors
        if (empty($errors)) {

            // checks that the song is unique
            $q = "INSERT INTO PATIENT (firstName, lastName, address, phoneNumber, email) VALUES ('$first_name', '$last_name', '$address', '$phone_number', '$email')";
            $r = @mysqli_query($dbc, $q);
            $q = "INSERT INTO INSURANCE (name) VALUES ('$coverage')";
            $r = @mysqli_query($dbc, $q);

        } else {

            # reports the errors
            echo '<p> The following error(s) occured:<br>';
            foreach ($errors as $msg) {
                echo " - $msg<br>\n";
            }
            echo '</p><p> Please try again. </p>';

          // end of errors if statement
        }
    }

    mysqli_close($dbc);
?>
