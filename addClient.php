<!DOCTYPE html>
<html>
  <head>
    <title> Add Client </title>
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
  </head>
  <body>

    <form action = "addClient.php" method = "post">
      <h3>First Name: <input type = "text" name = "fName" size = "15"></h3>
      <h3>Last Name: <input type = "text" name = "lName" size = "15"></h3>
      <h3>Address: <input type = "text" name = "address" size = "15"></h3>
      <h3>Phone Number: <input type = "text" name = "pNum" size = "15"></h3>
      <h3>Email: <input type = "text" name = "email" size = "15"></h3>
      <h3>Level of Coverage:
        <input type = "radio" name = "coverage" id = "b" value = "Bronze"><label for = "b">Bronze</label>
        <input type = "radio" name = "coverage" id = "s" value = "Silver"><label for = "s">Silver</label>
        <input type = "radio" name = "coverage" id = "g" value = "Gold"><label for = "g">Gold</label>
      </h3>
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

        // checks for song name
        if (empty($_POST['song_name'])) {
            $errors[] = 'You forgot to enter the song name.';
        } else {
            $song_name = mysqli_real_escape_string($dbc, trim($_POST['song_name']));
        }

        // checks for a/an artist(s)
        if (empty($_POST['artist'])) {
            $errors[] = 'You forgot to enter the artist(s).';
        } else {
            $artist = mysqli_real_escape_string($dbc, trim($_POST['artist']));
        }

        // checks for a duration (ms)
        if (empty($_POST['time'])) {
            $errors[] = 'You forgot to enter the duration (ms).';
        } else {
            $time = mysqli_real_escape_string($dbc, trim($_POST['time']));
        }

        // checks if there were no errors
        if (empty($errors)) {

            // checks that the song is unique
            $q = "SELECT * FROM Top_Spotify_Tracks where name = '$song_name' and artists = '$artist' and duration_ms = $time";
            $r = @mysqli_query($dbc, $q);

            // if song wasn't already in table
            if (mysqli_num_rows($r) == 0) {

                // makes the query
                $q = "UPDATE Top_Spotify_Tracks SET name = '$song_name', artists = '$artist', duration_ms = $time WHERE id = $id";
                $r = @mysqli_query($dbc, $q);

                // checks if the query affected 1 row like it should have
                if (mysqli_affected_rows($dbc) == 1) {
                    // print a message
                    echo '<p> The song has been edited. </p>';
                } else {
                    // print a message
                    echo '<p> The song could not be edited due to a system error. We apologize for any inconvenience. </p>';
                    // print an error message
                    echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>';
                }

            } else {

                # song already in table
                echo '<p> That song already exists in the table. </p>';

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
    }

    mysqli_close($dbc);
?>
