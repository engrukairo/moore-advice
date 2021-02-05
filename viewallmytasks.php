<?php
session_start();

if(!isset($_COOKIE['moore_cookie'])){header("Location: https://moore.esperasoft.com/login"); exit;}
$cookieuser = addslashes($_COOKIE['moore_cookie']);
include("databasecon.php");

$m = "View All My Tasks";
include("header.php");
if(isset($_SESSION['update'])){$update = $_SESSION['update']; unset($_SESSION['update']);}else{$update = "";} echo $update;
?>

<div class="search-header pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4">All Tasks Posted by Me</h1>
</div>

<div class="container">
  <div class="row">
  	<div class="col-md-8 mx-auto">
<div class="my-3 p-3 bg-white rounded shadow">
    <h6 class="border-bottom border-gray pb-2 mb-0">Task List</h6>
<?php
	$sql = "SELECT COUNT(*) FROM mooretasks WHERE taskpostedby = '$cookieuser'";
	$result = $mooredb->query($sql);
	$wwws = $result->fetchColumn();
	if ($wwws > 0) {

					$sqw = "SELECT * FROM mooretasks WHERE taskpostedby = '$cookieuser' ORDER BY mid DESC";
							foreach ($mooredb ->query($sqw) as $row){
							$taskid = $row['mid'];
							$taskname = $row['taskname'];
							$taskowner = $row['taskowner'];
							$taskposted = $row['taskposted'];
?>

    <div class="media text-muted pt-3">
      <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <div class="d-flex justify-content-between align-items-center w-100">
          <span class="text-gray-dark"><a href="https://moore.esperasoft.com/task/<?php echo $taskid;?>"><?php echo $taskname;?></a></span>
          <a href="https://moore.esperasoft.com/mytask/<?php echo $taskid;?>">View Task</a>
        </div>
        <span class="d-block">Assigned to <?php echo $taskowner;?></span>
      </div>
    </div>
<?php }
}else{echo "<div class='text-center'>There is no task posted by you. <a href='https://moore.esperasoft.com/new-task'>Create a new task</a>.</div>";} ?>
  </div>
 </div>
</div>

<?php
include("footer.php");
?>