<?php
session_start();
session_unset();
session_destroy();

header("Location: seller-login.php?status=logged_out");
exit();
?>
