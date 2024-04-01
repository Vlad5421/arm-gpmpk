<?php

session_start();
unset($_SESSION);
header("Location: ../arm.php");
