<?php
session_start();

if(!isset($_COOKIE['moore_cookie'])){header("Location: https://moore.esperasoft.com/login"); exit;}
$cookieuser = addslashes($_COOKIE['moore_cookie']);
include("databasecon.php");
include("moorefunctions.php");

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
        <?php showMyTasks($cookieuser,$mooredb);?>
      </div>
    </div>
  </div>
</div>

<?php include("footer.php");?>