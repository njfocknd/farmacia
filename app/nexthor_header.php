<?php

error_reporting(0);
date_default_timezone_set("America/Guatemala");
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering v
date_default_timezone_set("America/Guatemala");

include "ewcfg11.php";
include "ewmysql1.php";
include "phpfn11.php";
include "accountinfo.php";
include "bankinfo.php";
include "userinfo.php";
include "userfn11.php";
include "header.php";
require_once('nexthor/php/app_db_config.php');
require_once('nexthor/php/dbops.php');
require_once('nexthor/php/function.php'); ?>
<script type='text/javascript'src="nexthor/js/nexthor_js.js" ></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
