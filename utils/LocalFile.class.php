<?php
require_once "config.php";
/**
* This class will facilitate working with the local filesystem
* It will take care of things like creating, moving, searching for local files and directories
*/

class LocalFile {

	public static function moveToTmp($strFile, $strRename = null){
		$strRename = ( $strRename ) ? TMP_DIR.$strRename : TMP_DIR.$strFile;
		rename($strFile, $strRename);
		return $strRename;
	}
	
	public static function findFile($strSearch){
		$aryMatches = array();
		//look in current directory
		$aryFiles = scandir(dirname('__FILE__'));
		foreach( $aryFiles as $strFile ){
			if( preg_match("/.*$strSearch.*/", $strFile) ){
				$aryMatches[] = $strFile;
			}
		}
		if( empty($aryMatches) ){
			$aryFiles = scandir(dirname('__FILE__'));
			foreach( $aryFiles as $strFile ){
				if( preg_match("/.*$strSearch.*/", $strFile) ){
					$aryMatches[] = $strFile;
				}
			}
		}
		if( empty($aryMatches) ){return false;}
		if( count($aryMatches) > 1 ){
			return self::newerFile($aryMatches);
		}
		else{
			return $aryMatches[0];
		}
	}
	
	public static function newerFile($aryFiles){
		$intLatest = filemtime($aryFiles[0]);
		foreach( $aryFiles as $strFile ){
			if( filemtime($strFile) > $intLatest ){
				$intLatest = filemtime($strFile);
				$strLatestFile = $strFile;
			}
		}
		return $strLatestFile;
	}
	
	public static function isAudio(){
	
	}
	
	public static function isVideo(){
	
	}

}

?>
