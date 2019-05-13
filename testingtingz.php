<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>anna ou!</title>
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

    <form action="testingtingz.php" method="post">
      <input type="submit" name="test" value="test" id="submit">
    </form>
  </body>
</html>

<?php
require_once('/moredata/shantim/etc/mysqli_connect_medical.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

 if(isset($_POST['hospitalname'])){
   $q = "SELECT name FROM HOSPITAL where id = $hospitalname";
   $r = @mysqli_query($dbc, $q);

   $hospitalnamevar = $_POST['hospitalname'];
   echo "$hospitalnamevar";
 }
echo '<form action="testingtingz.php" method="post">';
echo '<label>First Name</label><input type="text" name="firstname"><br>';
//$dFirst =
echo '<label>Last Name</label><input type="text" name="lastname"><br>';
//$dFirst =
echo '<label>Specialty</label><input type="text" name="specialty" ><br>';
echo '<label>Phone Number</label><input type="numbernumber" name = "dPNum" pattern="\d*" minLength="10" maxlength="10" ><br>';
echo '<label>Email</label><input type="email" name="demail" ><br>';
echo '<label>Address</label><input type="text" name="daddress" ><br>';

echo '<select name="hospitalname">';
  $q = "SELECT * FROM HOSPITAL";
  $r = @mysqli_query($dbc, $q);
  $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

  foreach($r as $results){
    echo '<option value='. $results['hospital_id'] . '>' . $results['name'] . '</option>';
  }
echo '</select>';
echo '<input type="submit" name="submit" id="submit">';
echo '</form>';

}
 ?>
