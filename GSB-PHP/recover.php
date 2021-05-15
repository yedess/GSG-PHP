<?php
session_start();
?>
<?php
if( isset($_SESSION['ERRMSG_ARR']) &&
is_array($_SESSION['ERRMSG_ARR']) &&
count($_SESSION['ERRMSG_ARR']) >0 ) {
echo '<ul style="padding:0; color:red;">';
foreach($_SESSION['ERRMSG_ARR'] as $msg) {
echo '<li>',$msg,'</li>';
}
echo '</ul>';
unset($_SESSION['ERRMSG_ARR']);
}
?>
<head>
  <link rel="stylesheet" href="log-in.css">
</head> 
<body>
		
		<form class="login-form" method="POST" action="recover-pass.php">
			<img src="logo.png">
			<h1>Password Reset</h1>
					<input type="text" name="email" placeholder="Email"/>
					<input name="login" type = "submit-reset" value = "Send Email Verification"></a>
		</form>
	</body>