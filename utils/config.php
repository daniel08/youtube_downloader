<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

set_include_path(get_include_path() . PATH_SEPARATOR . '/utils');


define('UTIL_DIR', '/media/usb/zurbsite/utils/');
define('TMP_DIR', '/media/usb/zurbsite/public/tmp/');
define('WEB_ROOT', '/media/usb/zurbsite/public/');

require_once("FileDownloader.class.php");
require_once("Youtube.class.php");
require_once("YoutubeDl.class.php");
require_once("LocalFile.class.php");


?>
