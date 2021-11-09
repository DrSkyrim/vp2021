<?php
	class Test {
		//muutujad ehk omadused(properties)
		private $secret_number = 7;
		public $public_number = 6;
		private $recieved_number;
		//funktsioonid ehk meetodid
		//constructor
		function __construct($received_number){
			echo "Klass alustas ";
			$this->$received_number=$received_number;
			$this->multiply();
		}
		
		function __destruct(){
			echo "Klass lõpetab";
		}
		
		private function multiply(){
			echo "Salajaste arvude korrutis on " .$this->secret_number*$this->recieved_number;
		}
		public function reveal(){
			echo "Salajane number on " .$this->secret_number;
		}
	}//classi lopp