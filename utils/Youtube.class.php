<?php
require_once "config.php";
/**
*This class will handle Youtube stuff
* Right now I'm thinking like request info about a video, check url is valid...
*/
class Youtube {
	
	private $strDefaultUrl = 'http://www.youtube.com';
	private $strUrl;
	private $strVideoId;

	public function __construct($strUrl){
		$this->strUrl = $strUrl;
		$this->strVideoId = $this->setVideoId($this->strUrl);	
	}
	/**
	*/
	public function setUrl($strUrl){
	 $this->strUrl = $strUrl; 
		return true;
	}
	/**
	*/
	public function getUrl(){ return $this->strUrl; } 
	
	/**
	*/
	public function setVideoId($strUrl){
		$strRegex = '/\?.*v=([A-Za-z0-9_-]{10,15})/';
		preg_match($strRegex, $strUrl, $aryMatch);
		return !empty($aryMatch[1]) ? $aryMatch[1] : false;	
	}
	/**
	*
	*/
	public function getVideoId(){
		return $this->strVideoId;
	}
	/**
	*
	*/
	public function retrieveVideoData(){
		//ex: https://gdata.youtube.com/feeds/api/videos/XEVlyP4_11M?v=2&alt=jsonc
		$strRequestUrl = 'https://gdata.youtube.com/feeds/api/videos/';
		$strQuery = '?v=2&alt=jsonc';
		$strVideo = $this->getVideoId();
		$data = file_get_contents($strRequestUrl . $strVideo . $strQuery);
		//just get the data we could possibly care about
		return $data;
	}
	


}

?>
