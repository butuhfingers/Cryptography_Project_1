<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2/10/17
 * Time: 11:17 AM
 */

namespace Encryption;


class Encryption {
	//Variables
	private $key = "";
	private $crib = "";
	private $message = "";
	
	//Properties
	public function GetKey() : string {
		return $this->key;
	}
	
	public function GetCrib() : string {
		return $this->crib;
	}
	
	public function GetMessage() : string {
		return $this->message;
	}
	public function SetMessage(string $message){
		$this->message = $message;
	}
	public function GetMessageLength() : int{
		return strlen($this->GetMessage());
	}
	
	//The constructor
	public function __construct(string $message, string $key = "", string $crib = ""){
		$this->message = $message;
		$this->key = $key;
		$this->crib = $crib;
	}
	
	
	//Find the patterns of the duplicate letters in the $message
	public function DuplicationPattern(string $message, int $length = 1) : array {
		$patternArray = Array(); //Initialize the pattern array
		//Loop though the message and find the position of the duplicates
		$messagePosition = 0;
		while($messagePosition < strlen($message)){ //While our message position is lesser than the length of the $message
			//Check if the letter is duplicated in the message
			if(strpos($this->ReplaceCharacterAtPosition($messagePosition, $message), $message[$messagePosition]) === false){
				continue;
			}
			
			//We found a duplicate character, add the position to the array
			array_push($patternArray, $messagePosition);
		}
		
		return $patternArray; //Return the pattern
	}
	
	//Replace a character in position with another character
	public function ReplaceCharacterAtPosition(int $position, string $messageToReplace,
	                                           string $replacementCharacter = " ", int $replacementLength = 1) : string {
		return $messageToReplace[$position] = $replacementCharacter;    //return the new message with the replacement character
	}
}

