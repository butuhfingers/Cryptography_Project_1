<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2/10/17
 * Time: 12:43 PM
 */

namespace Cryptography;

require_once ("BaseCipher.php");

use Cryptography\BaseCipher;
use Encryption\Encryption;


class SubstitutionCipher extends BaseCipher {
	//Variables
	private $decodeArray = Array();
	
	//Properties
	protected function GetDecodeArray(){
		return $this->decodeArray;
	}
	
	//Constructor
	public function __construct(Encryption $encryption) {
		parent::__construct($encryption);   //Set the encryption
		
		//The decode array will consist of all capital letters
		$this->decodeArray = BaseCipher::UpperCaseLetterArray();
		$this->GetEncryption()->SetMessage(strtoupper($this->GetEncryption()->GetMessage()));
	}
	
	//Arrange the cipher text once the key is known
	public function DecodeWithKey($key = ""){
		//Check if the key is set
		$key == "" ? $key = $this->GetEncryption()->GetKey() : $this->Relax() ;
		
		$this->SetupDecryptionArray();
		
		$this->Decode();
	}
	
	//Decode with the decryption array
	private function Decode(){
		//The characters we are using
		$orderredArray = BaseCipher::UpperCaseLetterArray();
		$tempMessage = $this->GetEncryption()->GetMessage();
		//We need to go through the message and convert characters
		$messagePosition = 0;
		while($messagePosition < $this->GetEncryption()->GetMessageLength()){
			$tempMessage[$messagePosition] =
				$orderredArray[array_search(
					$this->GetEncryption()->GetMessage()[$messagePosition], $this->GetDecodeArray())];
			
			$messagePosition++;
		}
		
		$this->GetEncryption()->SetMessage($tempMessage);
	}
	
	//Setup the 1 to 1 pairs
	public function SetupDecryptionArray(){
		//Get the key and add it to the regular array
		for($i = strlen($this->GetEncryption()->GetKey()) - 1;$i > -1;$i--){
			//Get the key of the array of the element we are searching for
			$key = array_search($this->GetEncryption()->GetKey()[$i], $this->GetDecodeArray());
			$value = $this->GetDecodeArray()[$key]; //Get the value we want to move to the beginning
			
			unset($this->decodeArray[$key]);   //Remove the element we add the to beginning of the array
			array_unshift($this->decodeArray, $value);   //Add the element to the start of the array
		}
	}
	
	private function Relax(){
		;
	}
}