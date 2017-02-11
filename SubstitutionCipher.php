<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2/10/17
 * Time: 12:43 PM
 */

namespace Cryptography;

require_once ("BaseCipher.php");
require_once ("DuplicationPattern.php");

use Cryptography\BaseCipher;
use Encryption\Encryption;
use Cryptography\DuplicationPattern;


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
		
		//This only works for keys
		$this->SetupDecryptionArray();
		
		$this->Decode();
	}
	
	//Decode with a crib to a substitution cipher
	public function DecodeWithCrib($crib = ""){
		$crib == "" ? $crib = $this->GetEncryption()->GetCrib() : $this->Relax() ;
		
		$patterns = new DuplicationPattern($crib);
		
		print_r($this->FindPatterns($patterns));
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
	
	//Find the pattern in the message
	private function FindPatterns(DuplicationPattern $pattern){
		//Go through the message and check for collisions
		$messageData = Array(Array(), Array());
		$message = $this->GetEncryption()->GetMessage();
		//Go through the string and find all occurences
		$i = 0;
		//While we are not greater than the last part of the array
		while($i < (strlen($message) - $pattern->GetLength())){
			//Get a portion of the string that we want
			$stringPortion = substr($message, $i, $pattern->GetLength());
			
			//Create a new pattern
			$tempPattern = new DuplicationPattern($stringPortion);
			
			
			if($pattern->Equals($tempPattern)) {    //Do the crib data sets equal each other?
//				print("$stringPortion : at pos $i <br>");   //Print that our data equals!
				array_push($messageData[0], $i);   //Push the position onto the array
				array_push($messageData[1], $stringPortion);
			}
			
			$i++;   //Go up in incrmentation
		}
		
		return $messageData;
	}
	
	private function Relax(){
		;
	}
}