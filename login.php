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

if(isset($_POST['passReset'])){
$userphone = addslashes($_POST['phone']);
include("databasecon.php");

	$sql = "SELECT * FROM mooreusers WHERE phone = '$userphone'";
	$stmt = $mooredb->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll();
	$usercount = count($result);
	
	if($usercount == 1){
		$resettoken = rand(111111,999999);
			$updt = "UPDATE `mooreusers` SET `resettoken`='$resettoken' WHERE phone = '$userphone'";
			$uppd = $mooredb ->query($updt);
			$error = $mooredb->errorInfo();
			if (isset($error[2])) die($error[2]);
			$_SESSION['update'] = "<div class='alert alert-success' align='center'>Your password reset code is $resettoken.<br><small>Please note that this would been sent as sms in production.</small><br><a href='https://moore.esperasoft.com/reset-pass'>Click here to proceed.</a></div>";
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
  <p class="text-muted text-center mb-0">Forgot your password? <a href="#" data-toggle="modal" data-target="#passreset" class="text-moore">Reset It</a></p>
  <p class="text-muted text-center">New to Moore-Advice? <a href="#" data-toggle="modal" data-target="#newReg" class="text-moore">Sign Up</a></p>
  <p class="mb-3 text-muted text-center">&copy; Moore-Advice 2021</p>
</div>
</form>

		<div class="modal fade" id="passreset" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title" style="font-size:16px;">Admin Password Reset</span>
                    </div>
					<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST"> 
					<div class="modal-body">
						<div class="form-group">
						 <label>Enter Your Registered Phone Number:</label>
						  <input name="phone" class="form-control" type="text" required="required" placeholder="Your Phone Number">
						</div>
						<div class="form-group">
							<input class="form-control btn-moore btn" type="submit" value="Proceed" name="passReset"/> 
						</div>
					</div>
					</form>
                </div>
            </div>
        </div>

		<div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title" style="font-size:16px;">Create a New Account</span>
                    </div>
					<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST"> 
					<div class="modal-body">
						<div class="form-group">
						 <label>Your Full Name:</label>
						  <input name="name" class="form-control" type="text" required="required" placeholder="Your Full Name">
						</div>
						<div class="form-group">
						 <label>Your Active Phone Number:</label>
						  <input name="phone" class="form-control" type="text" required="required" placeholder="Your Phone Number">
						</div>
						<div class="form-group">
						 <label>Create a Password:</label>
						  <input name="password" class="form-control" type="password" required="required" placeholder="Create a Password">
						</div>
						<div class="form-group">
							<input class="form-control btn-moore btn" type="submit" value="Proceed" name="submitReg"/> 
						</div>
					</div>
					</form>
                </div>
            </div>
        </div>

<script src="https://moore.esperasoft.com/js/jquery-3.2.1.min.js"></script>
<script src="https://moore.esperasoft.com/js/bootstrap.min.js"></script>
<script src="https://moore.esperasoft.com/js/moore.js"></script>
</body>
</html>