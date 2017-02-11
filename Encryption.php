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
}

