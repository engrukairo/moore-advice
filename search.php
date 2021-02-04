<?php
if(!isset($_POST['query'])){header("Location: https://moore.esperasoft.com"); exit;}


$connect = mysqli_connect("localhost", "mooreadvice", "m00r3advLcE", "mooreadvice");
$output = '';
if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($connect, $_POST["query"]);
 $query = "SELECT * FROM mooretasks WHERE taskname LIKE '%".$search."%' OR taskdesc LIKE '%".$search."%' ORDER BY mid DESC LIMIT 10";
}

$result = mysqli_query($connect, $query);
if(mysqli_num_rows($result) > 0)
{
 while($row = mysqli_fetch_array($result))
 {
  $output .= '<div class="p-2"><a href="https://moore.esperasoft.com/task/'.$row["mid"].'">'.$row["taskname"].'</a></div>';
 }
 echo $output; exit;
}
else
{
 echo 'Nothing Found for '.$search; exit;
}
?>