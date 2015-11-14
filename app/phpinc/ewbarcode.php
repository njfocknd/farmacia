<?php
define("EW_IS_WINDOWS", (strtolower(substr(PHP_OS, 0, 3)) === 'win'), TRUE); // Is Windows OS
define("EW_PATH_DELIMITER", ((EW_IS_WINDOWS) ? "\\" : "/"), TRUE); // Physical path delimiter
define("EW_TMP_IMAGE_FONT", "DejaVuSans", TRUE); // Font for temp files
include_once "barcode.inc.php";
$bar= new BARCODE();
if($bar==false)
	die($bar->error());
$barnumber = @$_GET["data"];
$encode = @$_GET["encode"];
$format = @$_GET["format"];
if ($format == "") $format = "png";
$height = @$_GET["height"];
if ($height == "") $height = 0;
$font = @$_GET["font"];
if ($font == "") $font = EW_TMP_IMAGE_FONT;
$scale = @$_GET["scale"];
$color = @$_GET["color"];
$bgcolor = @$_GET["bgcolor"];
$bar->setSymblogy($encode);
if ($height > 0)
	$bar->setHeight($height);

// Always use full path
if (strrpos($font, '.') === FALSE)
	$font .= '.ttf';
$font = realpath('../phpfont') . EW_PATH_DELIMITER . $font;
$bar->setFont($font);
if ($scale <> "")
	$bar->setScale($scale);
if ($color <> "" && $bgcolor <> "")
	$bar->setHexColor($color, $bgcolor);
$return = $bar->genBarCode($barnumber, $format);
if ($return == FALSE)
	$bar->error(TRUE);
?>
