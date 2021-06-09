<?php
session_start();

if(!isset($_COOKIE['moore_cookie'])){header("Location: https://moore.esperasoft.com/login"); exit;}
if(!isset($_GET['task'])){header("Location: https://moore.esperasoft.com/"); exit;}
$cookieuser = addslashes($_COOKIE['moore_cookie']);
$taskid = addslashes($_GET['task']);
include("databasecon.php");
include("moorefunctions.php");




$m = "Task Details";
include("header.php");
if(isset($_SESSION['update'])){$update = $_SESSION['update']; unset($_SESSION['update']);}else{$update = "";} echo $update;
?>

<div class="search-header pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4">Single Tasks</h1>
</div>

<div class="container">
  <div class="row">
  	<div class="col-md-8 mx-auto">
	  <div class="my-3 p-3 bg-white rounded shadow">
		<?php showSingleTask($taskid, $mooredb);?>
	  </div>
	</div>
  </div>
</div>

<?php
include("footer.php");
?>