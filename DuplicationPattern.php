<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2/10/17
 * Time: 6:03 PM
 */

namespace Cryptography;


class DuplicationPattern {
	//Variables
	private $pattern = Array();
	private $messageLength = 0;
	
	//Properties
	public function GetPattern() : array {
		return $this->pattern;
	}
	public function GetLength() : int{
		return $this->messageLength;
	}
	
	//Find the patterns of the duplicate letters in the $message
	public function __construct(string $message, int $incrementLength = 1) {
		$this->pattern = $this->Setup($message, $incrementLength);
		$this->messageLength = strlen($message);
	}
	
	//Setup the duplication array data
	private function Setup(string $message, int $incrementLength) : array {
		$patternArray = Array(); //Initialize the pattern array
		//Loop though the message and find the position of the duplicates
		for($messagePosition = 0;$messagePosition < strlen($message);$messagePosition++){ //While our message position is lesser than the length of the $message
			//Check if the letter is duplicated in the message
			if(strpos($this->ReplaceCharacterAtPosition($messagePosition, $message), $message[$messagePosition]) === false){
				continue;
			}
			
			//We found a duplicate character, add the position to the array
			array_push($patternArray, $messagePosition);
		}
		
		return $patternArray;
	}
	
	//Replace a character in position with another character
	public function ReplaceCharacterAtPosition(int $position, string $messageToReplace,
	                                           string $replacementCharacter = " ", int $replacementLength = 1) : string {
		$messageToReplace[$position] = $replacementCharacter;
		
		return $messageToReplace;//return the new message with the replacement character
	}
	
	//Check if the crib data matches
	public function Equals(DuplicationPattern $dataTwo) {
		if(count($this->GetPattern()) !== count($dataTwo->GetPattern()))  //Do their counts match up?
			return false;
		
		//Go through their elements and check if they match
		$i = 0;
		while($i < count($this->GetPattern())){
			//Check if the crib elements are equal
			if($this->GetPattern()[$i] !== $dataTwo->GetPattern()[$i])
				return false;
			
			$i++;
		}
		
		//We made it this far, they must be equal!
		return true;
	}
}