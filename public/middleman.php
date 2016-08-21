<?php
/**
* This file will act as the middle man between the backend and front end
* So ajax calls and form submissions will come through here
*/
require_once '../utils/config.php';

if( isset($_POST['functionCall']) ){
	$functionCall = $_POST['functionCall'];
	$aryPostData = $_POST; //maybe do some cleaning here



switch ($functionCall){

	case "updateOptions": 
		//Logic for updateOptions
		break;
	
	case "youtubeDl":
		//Preprocess array of options
		$objYoutube = new Youtube($aryPostData['youtube-url']);
		$objYdl = new YoutubeDl($objYoutube);
		if( isset($aryPostData['options']) ){
			$objYdl->determineOptions($aryPostData['options']);
		}
		$result = $objYdl->execute();
		if( is_file($result) AND file_exists($result) ){
			//Make file path relative to web root
			$link = str_replace(WEB_ROOT, '', $result);
			preg_match('|\.[a-z0-9]{3}|i', $link, $aryExt);
			$strExt = $aryExt ? $aryExt[0] : '';
			$strType = ($strExt == '.mp4' ? '(Video)' : ($strExt == '.m4a' ? '(Audio)' : ''));
			$fileName = $aryPostData['filename'] . $strExt; 
			$strText = $aryPostData['filename'] . ' ' . $strType;
			echo json_encode(array('download'=>$fileName, 'link'=>$link, 'title'=>$strText));
		}
		else{
			echo json_encode(array('error'=>$result, 'errorUrl'=>$objYoutube->getUrl()));
		}
		break;

	default:
		break;
		
}//END switch
}//END if


?>
