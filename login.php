<?php
session_start();

if(isset($_POST['signin'])){
$userphone = addslashes($_POST['phone']);
$userpw = addslashes($_POST['password']);
include("databasecon.php");

	$sql = "SELECT * FROM mooreusers WHERE phone = '$userphone'";
	$stmt = $mooredb->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll();
	$usercount = count($result);
	
	if($usercount == 1){
		$sqw = "SELECT password FROM mooreusers WHERE phone = '$userphone'";
			foreach ($mooredb ->query($sqw) as $row){
			$hpassword = $row['password'];
			
				if (password_verify($userpw, $hpassword)) {
					$sqw = "SELECT * FROM mooreusers WHERE phone = '$userphone'";
						foreach ($mooredb ->query($sqw) as $row){
						$uid = $row['uid'];
						$userphone = $row['phone'];
						$cookietoken = hash('sha256', $userphone."8522dcf1");
	
						setcookie("moore_cookie", $uid, time()+60*60*24*365, "/");
						header("Location: https://moore.esperasoft.com/"); exit;
					}
				}else{$_SESSION['update'] = "<div class='alert alert-danger' align='center'>The password you entered is wrong.</div>";}
			}
	}else{$_SESSION['update'] = "<div class='alert alert-danger' align='center'>The Phone Number you entered does not exist.</div>";}
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
	<link rel="shortcut icon" href="../favicon.ico">
    <title>Sign in to Moore Advice</title>

<link href="https://moore.esperasoft.com/css/bootstrap.min.css" rel="stylesheet">
<link href="https://moore.esperasoft.com/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="https://moore.esperasoft.com/css/mystyles.css" rel="stylesheet">
  </head>
  <body class="signinbody">
    <form class="form-signin" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="POST">
  	<div class="signingform mx-auto shadow-sm">
	<div class="text-center">
	<?php if(isset($_SESSION['update'])){$update = $_SESSION['update']; unset($_SESSION['update']);}else{$update = "";} echo $update; ?>
  <img class="mb-4" src="images/mooreadvice.png" alt="" width="100">
  <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
  </div>
  <div class="form-group">
	  <label class="sr-onsly">Phone Number</label>
	  <input type="text" id="phone" class="form-control" placeholder="Phone Number" required name="phone">
  </div>
  <div class="form-group">
	  <label for="inputPassword" class="sr-onsly">Password</label>
	  <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
  </div>
  <button class="btn btn-moore btn-block subMoore" type="submit" name="signin" value="Sign in">Sign in</button>
  <p class="mb-3 text-muted text-center">&copy; Moore-Advice 2021</p>
</div>
</form>
<script src="https://moore.esperasoft.com/js/jquery-3.2.1.min.js"></script>
<script src="https://moore.esperasoft.com/js/bootstrap.min.js"></script>
<script src="https://moore.esperasoft.com/js/moore.js"></script>
</body>
</html>