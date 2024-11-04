<?php
session_start();
session_unset();
session_destroy();

// Send a success message instead of redirecting
echo "success";
exit();
