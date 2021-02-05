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

if(isset($_POST['submitReg'])){
$username = addslashes($_POST['name']);
$useridname = strtolower(str_replace(" ","-",$username));
$userphone = addslashes($_POST['phone']);
$userpw = addslashes($_POST['password']);
$userpw = password_hash($userpw, PASSWORD_DEFAULT);
include("databasecon.php");

$sql = "SELECT COUNT(*) FROM mooreusers WHERE phone = '".$userphone."'";// echo $sql; exit;
$result = $mooredb->query($sql);
$error = $mooredb->errorInfo();
if (isset($error[2])) die($error[2]);
$wwws = $result->fetchColumn();
if ($wwws > 0) {$_SESSION['update'] = "<div class='alert alert-warning alert-dismissable' align='center'>
                                The phone number you entered has been used earlier to sign up. Please login or reset your password</a>.
                            </div>";
							header("Location: ".$_SERVER['HTTP_REFERER']); exit;
}

$sql = "SELECT COUNT(*) FROM mooreusers WHERE e_d = '".$useridname."'";
$result = $mooredb->query($sql);
$error = $mooredb->errorInfo();
if (isset($error[2])) die($error[2]);
$wwws = $result->fetchColumn();
if ($wwws > 0) {$useridname = $useridname.'-'.rand(000,999);}

$sql = "INSERT INTO `mooreusers`(`uid`, `username`, `e_d`, `phone`, `password`) VALUES ('0','$username','$useridname','$userphone','$userpw')";
			$result = $mooredb->query($sql);
			$error = $mooredb->errorInfo();
			if (isset($error[2])) die($error[2]);

		$sql = "SELECT uid FROM mooreusers WHERE phone = '$userphone' AND password = '$userpw'";// echo $sql; exit;
			foreach ($mooredb ->query($sql) as $row){
			$uid = $row['uid'];
			setcookie("moore_cookie", $uid, time()+60*60*24*365, "/");
			$_SESSION['update'] = "<div class='alert alert-success alert-dismissable'>
												<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
												Welcome to Moore Advice.
											</div>";
			header("Location: https://moore.esperasoft.com"); exit;
		}
}

if(isset($_POST['resetPass'])){
$resetcode = addslashes($_POST['resetcode']);
$userphone = addslashes($_POST['phone']);
$password = addslashes($_POST['password']);
$cpassword = addslashes($_POST['cpassword']);
include("databasecon.php");

	$sql = "SELECT * FROM mooreusers WHERE phone = '$userphone' AND resettoken = '$resetcode'";
	$stmt = $mooredb->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll();
	$usercount = count($result);
	
	if($usercount == 1){
		if($password == $cpassword){
			$userpw = addslashes($_POST['password']);
			$userpw = password_hash($userpw, PASSWORD_DEFAULT);
			$updt = "UPDATE `mooreusers` SET `resettoken`='$resettoken',`password` = '$userpw' WHERE phone = '$userphone'";
			$uppd = $mooredb ->query($updt);
			$error = $mooredb->errorInfo();
			if (isset($error[2])) die($error[2]);
			$sql = "SELECT uid FROM mooreusers WHERE phone = '$userphone' AND password = '$userpw'";
				foreach ($mooredb ->query($sql) as $row){
				$uid = $row['uid'];
				setcookie("moore_cookie", $uid, time()+60*60*24*365, "/");
				$_SESSION['update'] = "<div class='alert alert-success alert-dismissable'>
													<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
													Your password has been successfully reset.
												</div>";
				header("Location: https://moore.esperasoft.com"); exit;
			}
		}else{$_SESSION['update'] = "<div class='alert alert-danger' align='center'>The two passwords does not match.</div>";}
	}else{$_SESSION['update'] = "<div class='alert alert-danger' align='center'>The Phone Number and password reset code does not match.</div>";}
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
    <form class="form-passreset form-signin" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="POST">
  	<div class="signingform mx-auto shadow-sm">
	<div class="text-center">
	<?php if(isset($_SESSION['update'])){$update = $_SESSION['update']; unset($_SESSION['update']);}else{$update = "";} echo $update; ?>
  <img class="mb-4" src="images/mooreadvice.png" alt="" width="100">
  <h1 class="h3 mb-3 font-weight-normal">Password Reset</h1>
  </div>
  <div class="form-group">
	  <label class="sr-onsly">Your Password Reset Code</label>
	  <input type="text" class="form-control" placeholder="Password Reset Code" required name="resetcode">
  </div>
  <div class="form-group">
	  <label class="sr-onsly">Phone Number</label>
	  <input type="text" id="phone" class="form-control" placeholder="Phone Number" required name="phone">
  </div>
  <div class="form-group">
	  <label for="inputPassword" class="sr-onsly">Create New Password</label>
	  <input type="password" class="form-control npass" placeholder="Create New Password" required name="password">
  </div>
  <div class="form-group">
	  <label for="inputPassword" class="sr-onsly">Confirm New Password</label>
	  <input type="password" class="form-control npassc" placeholder="Confirm New Password" required name="cpassword">
  </div>
  <button class="btn btn-moore btn-block subMoore" type="submit" name="resetPass" value="Reset Password">Reset Password</button>
  <p class="mb-3 text-muted text-center">&copy; Moore-Advice 2021</p>
</div>
</form>

<script src="https://moore.esperasoft.com/js/jquery-3.2.1.min.js"></script>
<script src="https://moore.esperasoft.com/js/bootstrap.min.js"></script>
<script src="https://moore.esperasoft.com/js/moore.js"></script>
</body>
</html>