<?php
class Line{

	public $x0;
	public $x1;
	public $y0;
	public $y1;
		
	public $type;
	
	protected $valid = false;
	
	public function __construct($x0, $y0, $x1, $y1){
		
		list(
			$this->x0, $this->y0,
			$this->x1, $this->y1) = array($x0, $y0, $x1, $y1);
		
			$this->valid = true;
	
	}

	public function isValid(){
		return $this->valid;
	}
	
	
}
?>