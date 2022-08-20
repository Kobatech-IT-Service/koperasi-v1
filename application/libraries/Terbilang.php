<?php
/*
*
* Class : Terbilang
* Spell quantity numbers in Indonesian or Malay Language
*
*
* author: huda m elmatsani
* 21 September 2004
* freeware
*
* example:
* $bilangan = new Terbilang;
* echo $bilangan -> eja(137);
* result: seratus tiga puluh tujuh
*
*
*/
Class Terbilang {

	function __construct() {
		$this->dasar = array(1=>'satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan');
		$this->angka = array(1000000000000,1000000000,1000000,1000,100,10,1);
		$this->satuan = array('triliun','milyar','juta','ribu','ratus','puluh','');
	}


	function eja($n) {
		$n = number_format($n, 0, '', '');
		$str = '';
		$i=0;
		while($n!=0){
			if(isset($this->angka[$i])) {
				if($this->angka[$i] > 0) {
					$count = (int)($n/$this->angka[$i]);
				} else {
					$count = 0;
				}
			} else {
				$count = 0;
			}
			if($count>=10) $str .= $this->eja($count). " ".$this->satuan[$i]." ";
			else if($count > 0 && $count < 10)
			$str .= $this->dasar[$count] . " ".$this->satuan[$i]." ";
			$n -= @$this->angka[$i] * $count;
			$i++;
		}
		$str = preg_replace("/satu puluh (\w+)/i","\\1 belas",$str);
		$str = preg_replace("/satu (ribu|ratus|puluh|belas)/i","se\\1",$str);
		return strtoupper($str);
	}
}