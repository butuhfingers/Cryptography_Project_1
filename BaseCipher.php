<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2/10/17
 * Time: 1:00 PM
 */
namespace Cryptography;

require_once ("Encryption.php");

use Encryption\Encryption;

class BaseCipher {
	//Variables
	private $encryption = null;
	
	//Properties
	public function GetEncryption() : Encryption{
		return $this->encryption;
	}
	
	//Constructor
	public function __construct(Encryption $encryption) {
		$this->encryption = $encryption;    //Set the cipher encryption
	}
	
	//Find the pattern of an occurring string in a message (find all of the different needles in a haystack and return them)
	public function GetFrequencies(int $length = 1) : array{
		$frequencies = Array();
		//Create a loop that will gather all duplicate frequencies
		$messagePosition = -1;
		while($messagePosition < ($this->GetEncryption()->GetMessageLength() - $length)){
			//add to the message position
			$messagePosition++;
			
			$needle = "";
			//Create a temporary needle to store the patterns we are looking for
			for($i = 0;$i < $length;$i++){
				$needle .= $this->GetEncryption()->GetMessage()[$messagePosition + $i]; //Add the character to the needle
			}
			
//			print($needle);
			
			//Check if it exists inside of our message
			//If it is false, do not do anything more and continue the loop
			if(($stringPos = strpos($this->GetEncryption()->GetMessage(), $needle)) === false) {
				continue;
			}
			
			//Check if the key exists in the array already
			//If it does, add 1 to it, else create it and equal it to zero
			$stringPos < $messagePosition ? $frequencies[$needle] += 1 : $frequencies[$needle] = 0;
		}
		
		asort($frequencies);    //Sort the frequencies from largest to smallest
		return $frequencies;    //Return the frequencies that we have found
	}
	
	//The frequency of letters
	public static function GetLetterFrequencies() : array{
		$frequencies = Array('e' => 12.702,
			't'=>9.056,
			'a'=>8.167,
			'o'=>7.507,
			'i'=>6.966,
			'n'=>6.749,
			's'=>6.327,
			'h'=>6.094,
			'r'=>5.987,
			'd'=>4.253,
			'l'=>4.025,
			'c'=>2.782,
			'u'=>2.758,
			'm'=>2.406,
			'w'=>2.360,
			'f'=>2.228,
			'g'=>2.015,
			'y'=>1.974,
			'p'=>1.929,
			'b'=>1.492,
			'v'=>0.978,
			'k'=>0.772,
			'j'=>0.153,
			'x'=>0.150,
			'q'=>0.095,
			'z'=>0.074);
		
		asort($frequencies, SORT_NUMERIC);
		
		return $frequencies;
	}
	
	//The most frequent digrams
	public static function GetCommonDigrams() : array{
		//The array hold all of the 2 letter patterns
//		th er on an re he in ed nd ha at en es of or nt ea ti to it st io le is ou ar as de rt ve
		return Array(
			"th",
			"er",
			"on",
			"re",
			"he",
			"in",
			"ed",
			"nd",
			"ha",
			"at"
		);
	}
	
	
	//The most frequent trigrams
	public static function GetCommonTrigrams() : array{
		//The array hold all of the 3 letter patterns
		return Array(
			"the",
			"and",
			"tha",
			"ent",
			"ion",
			"tio",
			"for",
			"nde",
			"has",
			"edt"
		);
	}
	
	//Get the upper case letter array
	public static function UpperCaseLetterArray() : array {
		//Define the letter array
		$letterArray = Array();
		
		//Go through ASCII and add them to to array
		for((int)$i = 65; $i < 91;$i ++){
			array_push($letterArray, chr($i));
		}
		
		return $letterArray;
	}
}