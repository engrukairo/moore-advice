<?php
session_start();

if(!isset($_COOKIE['moore_cookie'])){header("Location: https://moore.esperasoft.com/login"); exit;}
if(!isset($_GET['task'])){header("Location: https://moore.esperasoft.com/"); exit;}
$cookieuser = addslashes($_COOKIE['moore_cookie']);
$taskid = addslashes($_GET['task']);
include("databasecon.php");


if(isset($_POST['taskname'])){
$taskname = addslashes($_POST['taskname']);
$taskowner = addslashes($_POST['taskowner']);
$taskstime = addslashes($_POST['taskstime']);
$tasketime = addslashes($_POST['tasketime']);
$taskdesc = addslashes($_POST['taskdesc']);
$taskid = addslashes($_POST['taskid']);
$ts = date("D, d M , Y");
			$updt = "UPDATE `mooretasks` SET `taskname`='$taskname',`taskowner`='$taskowner',`taskstime`='$taskstime',`tasketime`='$tasketime',`taskdesc`='$taskdesc' WHERE mid = '$taskid'";
			$uppd = $mooredb ->query($updt);
			$error = $mooredb->errorInfo();
			if (isset($error[2])) die($error[2]);

exit;
}

$extracss = '<link rel="stylesheet" href="https://moore.esperasoft.com/css/datepicker3.css">';
$m = "Editing Task";
include("header.php");
if(isset($_SESSION['update'])){$update = $_SESSION['update']; unset($_SESSION['update']);}else{$update = "";} echo $update;
?>

<div class="search-header pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4">Editing Task</h1>
</div>

<div class="container">
  <div class="row">
  	<div class="col-md-8 mx-auto">
<div class="my-3 p-3 bg-white rounded shadow">
<?php

	$sql = "SELECT COUNT(*) FROM mooretasks WHERE mid = '$taskid'";
	$result = $mooredb->query($sql);
	$wwws = $result->fetchColumn();
	if ($wwws > 0) {

					$sqw = "SELECT * FROM mooretasks WHERE mid = '$taskid' ORDER BY mid DESC";
							foreach ($mooredb ->query($sqw) as $row){
							$taskid = $row['mid'];
							$taskname = $row['taskname'];
							$taskowner = $row['taskowner'];
							$taskposted = $row['taskposted'];
							$taskdesc = $row['taskdesc'];
							$taskstime = $row['taskstime'];
							$tasketime = $row['tasketime'];

?>

  	<form id="editTask" method="POST">
		<div class="form-row">
			<div class="form-group col-md-6">
				<label>Task Name</label>
				<input type="text" name="taskname" class="form-control taskname" required="required" value="<?php echo $taskname; ?>" />
			</div>
			<div class="form-group col-md-6">
				<label>Task Owner</label>
				<input type="text" name="taskowner" class="form-control taskowner" required="required" value="<?php echo $taskowner; ?>" />
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label>Task Start Time</label>
				<input type="text" name="taskstime" class="form-control taskstime" id="datepicker1" required="required" value="<?php echo $taskstime; ?>" />
			</div>
			<div class="form-group col-md-6">
				<label>Task End Time</label>
				<input type="text" name="tasketime" class="form-control tasketime" id="datepicker2" required="required" value="<?php echo $tasketime; ?>" />
			</div>
		</div>
			<div class="form-group">
				<label>Task Description</label>
				<textarea name="taskdesc" class="form-control ckedditor taskdesc"><?php echo $taskdesc; ?></textarea>
			</div>
			<div class="form-group">
				<input type="submit" name="updTask" class="form-control btn btn-moore" id="updTask" value="Update task" />
			</div><input type="hidden" name="taskid" value="<?php echo $taskid; ?>" class="taskid" />
			<div id="tasknot"></div>
			
	</form>
<?php }
}else{echo "<div class='text-center'>The task you tried to view does not exist.</div>";} ?>
  </div>
 </div>
</div>

<?php
include("footer.php");
?>