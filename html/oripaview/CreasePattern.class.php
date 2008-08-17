<?php
require_once('Line.class.php');

class CreasePattern{

	public $lines  = array();
	
	public $errors = array();
	
	public $size;
	public $title;
	public $editor;
	public $author;
	
	public $width = 800;
	public $height = 800;
	
	public $linecolors = array(array(200,200,200), array(0,0,0), array(255,0,0), array(0,0,255));
	
	public $image;

	public function __construct(){
			
	}
	
	
	public function output_image($size = null){
	
		if($size != null){
			$this->width = intval($size);
			$this->height = intval($size);
		}
	
		header("Content-type: image/png");
		$this->image = @imagecreatetruecolor($this->width+1, $this->height+1) 
					or die("Could not create new Image!");
		
		imageantialias($this->image, true);		
		$background = imagecolorallocate($this->image, 255,255,255);
		
		imagefill($this->image, 0,0, $background);
		
		$max = 1000;
		$start = 40;

		$increment = 0;

		foreach($this->lines as $line){
			if($increment >= $start and $increment < $max or true)
				$this->drawcrease($line);
			$increment++;
		}
		
		imagepng($this->image);
		imagedestroy($this->image);
	}
	
	public function drawcrease($line){
		
		$linecolor  = imagecolorallocate($this->image, $this->linecolors[$line->type][0], $this->linecolors[$line->type][1], $this->linecolors[$line->type][2]);
		
		
		$x0 = $this->resize($line->x0);
		$x1 = $this->resize($line->x1);
		$y0 = $this->resize($line->y0);
		$y1 = $this->resize($line->y1);
		
				
		if(!imageline($this->image, $x1, $y1, $x0, $y0, $linecolor)) die("COULDN'T DRAW ($x0,$x1), ($y0,$y1)");
	}
	
	
	public function resize($value){
		$increment = $this->size/2;
		
		$factor = $this->width/$this->size;
	
		return round((($value+$increment)*$factor));
	
	}
	
}


?>