<?php


if(isset($_POST['taskname'])){
    $taskname = addslashes($_POST['taskname']);
    $taskowner = addslashes($_POST['taskowner']);
    $taskstime = addslashes($_POST['taskstime']);
    $tasketime = addslashes($_POST['tasketime']);
    $taskdesc = addslashes($_POST['taskdesc']);
    $ts = date("D, d M , Y");
    $moore = "INSERT INTO `mooretasks`(`mid`, `taskname`, `taskowner`, `taskstime`, `tasketime`, `taskdesc`,`taskposted`,`taskpostedby`) VALUES('0','$taskname','$taskowner','$taskstime','$tasketime','$taskdesc','$ts','$cookieuser')";
                $result = $mooredb->query($moore);
                $error = $mooredb->errorInfo();
                if (isset($error[2])) die($error[2]);
    exit;
}

if(isset($_POST['deleteTask'])){
    $taskid = addslashes($_POST['id']);
            $delsql = "DELETE FROM mooretasks WHERE mid = '$taskid'";
                $dels = $mooredb ->query($delsql);
                $error = $mooredb->errorInfo();
                if (isset($error[2])) die($error[2]);
    exit;
}

function showAllTasks($mooredb){
    $sql = "SELECT COUNT(*) FROM mooretasks";
	$result = $mooredb->query($sql);
	$wwws = $result->fetchColumn();
	if ($wwws > 0) {

					$sqw = "SELECT * FROM mooretasks ORDER BY mid DESC";
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
                            <a href="https://moore.esperasoft.com/task/<?php echo $taskid;?>">View Task</a>
                            </div>
                            <span class="d-block">Assigned to <?php echo $taskowner;?></span>
                        </div>
                    </div>
                        <?php }
    }else{echo "<div class='text-center'>There is no task available. <a href='https://moore.esperasoft.com/new-task'>Create a new task</a>.</div>";}
}

function showMyTasks($cookieuser,$mooredb){
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
}else{echo "<div class='text-center'>There is no task posted by you. <a href='https://moore.esperasoft.com/new-task'>Create a new task</a>.</div>";}

}
function showSingleTask($taskid, $mooredb){
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
                        <a class="btn btn-moore" href="https://moore.esperasoft.com/edit/<?php echo $taskid;?>">Edit Task</a>
                        <a class="btn btn-moore-outline" onclick="deleteTask(<?php echo $taskid;?>)">Delete Task</a>
                    </div>
                    </div>
    <?php }
    }else{echo "<div class='text-center'>The task you tried to view does not exist.</div>";}
}
?>