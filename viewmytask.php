<?php
session_start();

if(!isset($_COOKIE['moore_cookie'])){header("Location: https://moore.esperasoft.com/login"); exit;}
if(!isset($_GET['task'])){header("Location: https://moore.esperasoft.com/"); exit;}
$cookieuser = addslashes($_COOKIE['moore_cookie']);
$taskid = addslashes($_GET['task']);
include("databasecon.php");

if(isset($_POST['deleteTask'])){
$taskid = addslashes($_POST['id']);
		$delsql = "DELETE FROM mooretasks WHERE mid = '$taskid' AND taskpostedby = '$cookieuser'";
			$dels = $mooredb ->query($delsql);
			$error = $mooredb->errorInfo();
			if (isset($error[2])) die($error[2]);
exit;
}

$m = "Task Details";
include("header.php");
if(isset($_SESSION['update'])){$update = $_SESSION['update']; unset($_SESSION['update']);}else{$update = "";} echo $update;
?>

<div class="search-header pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4">All Tasks</h1>
</div>

<div class="container">
  <div class="row">
  	<div class="col-md-8 mx-auto">
<div class="my-3 p-3 bg-white rounded shadow">
<?php

	$sql = "SELECT COUNT(*) FROM mooretasks WHERE mid = '$taskid' AND taskpostedby = '$cookieuser'";
	$result = $mooredb->query($sql);
	$wwws = $result->fetchColumn();
	if ($wwws > 0) {

					$sqw = "SELECT * FROM mooretasks WHERE mid = '$taskid' AND taskpostedby = '$cookieuser' ORDER BY mid DESC";
							foreach ($mooredb ->query($sqw) as $row){
							$taskid = $row['mid'];
							$taskname = $row['taskname'];
							$taskowner = $row['taskowner'];
							$taskposted = $row['taskposted'];
							$taskdesc = $row['taskdesc'];
							$taskposted = $row['taskposted'];
?>

    <div class="card mb-4 shadow-sm">
      <div class="card-header">
        <span class="my-0 font-weight-normal">Task Title: <?php echo $taskname;?></span>
      </div>
      <div class="card-body">
        <ul class="list-unstyled mt-3 mb-4">
          <li class="mb-5"><strong>Assigned to <?php echo $taskowner;?></strong></li>
          <li>Task Description:<br /><?php echo $taskdesc;?></li>
        </ul>
        <a class="btn btn-moore" href="https://moore.esperasoft.com/myedit/<?php echo $taskid;?>">Edit Task</a>
        <a class="btn btn-moore-outline" onclick="deleteTask(<?php echo $taskid;?>)">Delete Task</a>
      </div>
    </div>
<?php }
}else{echo "<div class='text-center'>You are not allowed to view this task.</div>";} ?>
  </div>
 </div>
</div>

<?php
include("footer.php");
?>