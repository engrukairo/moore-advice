<?php
session_start();

if(!isset($_COOKIE['moore_cookie'])){header("Location: https://moore.esperasoft.com/login"); exit;}
$cookieuser = addslashes($_COOKIE['moore_cookie']);

include("databasecon.php");

$m = "Admin Home";
include("header.php");
if(isset($_SESSION['update'])){$update = $_SESSION['update']; unset($_SESSION['update']);}else{$update = "";} echo $update;
?>

<div class="search-header pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4">Tasks Dashboard</h1>
<form action="search.php" method="GET">
      <div class="input-group input-group">
        <input class="form-control" type="search" placeholder="Search tasks with name, description, etc" aria-label="Search" name="for" required="required" id="search_text">
        <div class="input-group-append">
          <button class="btn btn-moore" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
		<div id="result"></div>
</div>

<div class="container">
  <div class="card-deck mb-3 text-center row">
    <div class="card mb-4 shadow-sm col-md-4">
      <div class="card-body">
        <h4 class="card-title pricing-card-title mb-5">New Task</h4>
        <a class="btn btn-lg btn-block btn-moore-outline" href="new-task"><i class="fa fa-plus"></i> Create</a>
      </div>
    </div>
    <div class="card mb-4 shadow-sm col-md-4">
      <div class="card-body">
        <h4 class="card-title pricing-card-title mb-5">View My Tasks</h4>
        <a class="btn btn-lg btn-block btn-moore-outline" href="all-my-tasks">View</a>
      </div>
    </div>
	<div class="card mb-4 shadow-sm col-md-4">
      <div class="card-body">
        <h4 class="card-title pricing-card-title mb-5">All Users Tasks</h4>
        <a class="btn btn-lg btn-block btn-moore-outline" href="all-tasks">View All</a>
      </div>
    </div>
  </div>

<?php include("footer.php"); ?>