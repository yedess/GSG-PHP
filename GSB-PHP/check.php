<?php  
//check.php  
include('/connection.php');
if(isset($_POST["identifiant"]))
{
 $username = mysqli_real_escape_string($conn, $_POST["identifiant"]);
 $query = "SELECT * FROM users WHERE username = '".$username."'";
 $result = mysqli_query($conn, $query);
 echo mysqli_num_rows($result);
}
?>
