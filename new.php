<?php
session_start();

if(!isset($_COOKIE['moore_cookie'])){header("Location: https://moore.esperasoft.com/login"); exit;}
$cookieuser = addslashes($_COOKIE['moore_cookie']);
include("databasecon.php");
include("moorefunctions.php");

$extracss = '<link rel="stylesheet" href="css/datepicker3.css">';
$m = "New Task";
include("header.php");
if(isset($_SESSION['update'])){$update = $_SESSION['update']; unset($_SESSION['update']);}else{$update = "";} echo $update;
?>

<div class="search-header pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4">New Task</h1>
</div>

<div class="container">
  <div class="row">
  	<div class="col-md-8 mx-auto">
  	<form id="newTask" method="POST">
		<div class="form-row">
			<div class="form-group col-md-6">
				<label>Task Name</label>
				<input type="text" name="taskname" class="form-control taskname" required="required" />
			</div>
			<div class="form-group col-md-6">
				<label>Task Owner</label>
				<input type="text" name="taskowner" class="form-control taskowner" required="required" />
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label>Task Start Time</label>
				<input type="text" name="taskstime" class="form-control taskstime" id="datepicker1" required="required" />
			</div>
			<div class="form-group col-md-6">
				<label>Task End Time</label>
				<input type="text" name="tasketime" class="form-control tasketime" id="datepicker2" required="required" />
			</div>
		</div>
			<div class="form-group">
				<label>Task Description</label>
				<textarea name="taskdesc" class="form-control ckedditor taskdesc"></textarea>
			</div>
			<div class="form-group">
				<input type="submit" name="subTask" class="form-control btn btn-moore" id="subTask" value="Submit task" />
			</div>
			<div id="tasknot"></div>
			
	</form>
	</div>
  </div>

<?php
include("footer.php");
?>