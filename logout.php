<?php
session_start();
setcookie("moore_cookie", "aaa", time()-1, "/");
session_destroy();
header("Location: ".$_SERVER['HTTP_REFERER']); exit;
?>
