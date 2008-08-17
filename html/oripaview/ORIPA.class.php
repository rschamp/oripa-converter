<?php
require_once('xmltoarray.php');
require_once('Line.class.php');

class ORIPA{

	public $lines  = array();
	
	public $errors = array();
	
	public $raw_data;
	private $line_data;
	
	public $size;
	public $title;
	public $editor;
	public $author;
	public $reference;
	public $memo;
	
	public $width = 800;
	public $height = 800;
	
	public $linecolors = array(array(200,200,200), array(0,0,0), array(255,0,0), array(0,0,255));
	
	public $image;

	public function __construct($opxdata){
	
		$this->raw_data = $opxdata;
		$this->process_metadata();
		
		foreach($this->line_data as $id => $line_array){
			
			$this->add_XML_line($line_array);
		}
			
	}
	
	public function process_metadata(){
		foreach($this->raw_data['java']['content']['object']['content']['void'] as $node){
			switch($node['attributes']['property']){
				case "lines":
					$this->line_data = $node['content']['array']['content']['void'];
					break;
				case "editorName":
					$this->editor = $node['content']['string']['_v'];
					break;
				case "title":
					$this->title = $node['content']['string']['_v'];
					break;
				case "paperSize":
					$this->size = $node['content']['double']['_v'];
					break;
				case "originalAuthorName":
					$this->author = $node['content']['string']['_v'];
					break;
				case "reference":
					$this->reference = $node['content']['string']['_v'];
					break;
				case "memo":
					$this->memo = $node['content']['string']['_v'];
					break;
			}
		}
	}
		
	private function add_XML_line($line_array){
		
		$new_line = new Line($line_array);
		
		$this->addLine($new_line);
		
	}
	
	public function addLine($new_line){
	
		if($new_line->isValid()){
			$this->lines[] = $new_line;
			return true;
		}else{
			$this->errors[] = $new_line->get_problems();
		}
	
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