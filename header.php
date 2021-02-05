<?php
if(isset($m)){$headertitle = $m." | Moore Advice";}else{$headertitle = "Moore Advice";}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title><?php echo $headertitle; ?></title>
	<link rel="shortcut icon" href="../favicon.ico">
	<link href="https://moore.esperasoft.com/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://moore.esperasoft.com/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="https://moore.esperasoft.com/css/mystyles.css" rel="stylesheet">
	<?php if(isset($extracss)){echo $extracss;}?>
	<script src="https://moore.esperasoft.com/js/jquery-3.2.1.min.js"></script>
	<script src="https://moore.esperasoft.com/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal"><a href="https://moore.esperasoft.com/"><img src="https://moore.esperasoft.com/images/mooreadvice.png" height="45"></a></h5>
  <nav class="my-2 my-md-0 mr-md-3">
    <a class="p-2 text-dark" href="https://moore.esperasoft.com/">Dashboard</a>
    <a class="p-2 text-dark" href="https://moore.esperasoft.com/new-task">New Task</a>
    <a class="p-2 text-dark" href="https://moore.esperasoft.com/all-my-tasks">My Tasks</a>
    <a class="p-2 text-dark" href="https://moore.esperasoft.com/all-tasks">All Tasks</a>
  </nav>
  <a class="btn btn-moore-outline" href="https://moore.esperasoft.com/logout">Sign out</a>
</div>