<?php

if (isset($_POST["submit-reset"])) {
	
	$selector =  bin2hex(random_bytes(8));
	$token = random_bytes(32);

	$url = "127.0.0.1/new-pass.php?selector=" . $selector . "&validator=" . bin2hex($token);
	
	$expires = date("U") + 1800;

}else{
	header("Location: login.php");
}

?>