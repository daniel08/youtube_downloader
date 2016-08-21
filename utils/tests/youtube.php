<?php
require_once('../config.php');
/**
* Some unit testing for Youtube class
*/

$objY = new Youtube('https://www.youtube.com/watch?v=3rnFlQAvk8U');
if( $objY->getVideoId() != '3rnFlQAvk8U' ){
	trigger_error("Video Id: ". $objY->getVideoId() .", but it should be: 3rnFlQAvk8U;");
}

$objYdl = new YoutubeDl($objY);
$objYdl->addOption('-v');
//print_r($objYdl->getOptions());
$objYdl->setCommand();
echo $objYdl->getCommand();

$objY->retrieveVideoData();

echo $objYdl->execute();

?>
