<?php
/**
* This class will create an object that interfaces with youtube-dl
* It will build up the different options and perform the youtube-dl execution (by exec())
*
*/

class YoutubeDl {

	//Array of option keys '-flag'=>'arg'
  private $aryOptions = array();
  private $aryStaticOptions = array('--id'=>'');
  private $aryAllowedFlags = array('-x', '-q', '--version');
	private $strCommand;
	private $strRedirectStdErr = ' 2>&1 ';
	private $objYoutube;

	public function __construct($objYoutube){
		$this->objYoutube = $objYoutube;
	}
	/**
	*
	*/
	public function addOption($strFlag, $strArg=''){
		//TODO check for valid flag
		$this->aryOptions[$strFlag] = $strArg;
		return true;
	}
	/**
	*
	*/
	public function getOptions(){
		return $this->aryOptions;
	}
	/**
	*
	*/
	public function setCommand(){
		$this->strCommand = UTIL_DIR . 'youtube-dl';
		//Combine options
		$aryOptions = array_merge($this->aryOptions, $this->aryStaticOptions);
		foreach( $aryOptions as $strFlag=>$strArg ){
			$this->strCommand .= " $strFlag $strArg ";
		}
		$this->strCommand .= ' "'. $this->objYoutube->getUrl() . '" ';
		return true;
	}
	/**
	*
	*/
	public function getCommand(){
		$this->setCommand();
		return $this->strCommand;
	}
	/**
	*This function takes an array that is supposedly keyed on flag=>arg
	*	and attempts to decipher it for valis args
	*/
	public function determineOptions($aryOptions){
		//TODO check that flag is valid
		if( ! empty($aryOptions) ){
			foreach( $aryOptions as $strFlag=>$strArg ){
				//add '-' or '--' TODO
//				if( ! stristr('-', $strFlag) ){
//					$strFlag = (strlen($strFlag)==1) ? "-$strFlag" : "--$strFlag";
//				}
				$this->addOption($strFlag, $strArg);
			}
		}
		return true;
	}
	
	public function execute(){
		//run command
		try{
			exec($this->getCommand() . ' 2>&1' ,$aryOutput, $intReturn);
		}catch (Exception $error){
			//should handle errors well
			$errMessage = $error->getMessage();
		}
		if( $intReturn !== 0 ){
			return implode(PHP_EOL, $aryOutput);
		}
		//Check aryOutput and intReturn
		//move file to tmp
		if( $strSearch = LocalFile::findFile($this->objYoutube->getVideoId()) ){
			return LocalFile::moveToTmp($strSearch);
		}		
		else{
			return false;
		}
		
		
	}
	
	
	
	
	

}







?>
