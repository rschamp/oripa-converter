<?php
require_once('xmltoarray.php');

class ORIPA{

	public $lines  = array();
	
	public $errors = array();
	
	public $rawdata;
	public $width = 800;
	public $height = 800;
	
	public $linecolors = array(array(200,200,200), array(0,0,0), array(255,0,0), array(0,0,255));
	
	public $image;

	public function __construct($opxdata){
	
		$this->rawdata = $opxdata;
		
		$all_line_xml_data = $this->get_all_line_xml_data();
		
		foreach($all_line_xml_data as $id => $line_array){
			
			$this->add_XML_line($line_array);
		}
		
//		$this->height = $this->width = $this->get_paper_size();
	
	}
	
	public function get_all_line_xml_data(){
		return $this->rawdata['java']['content']['object']['content']['void'][0]['content']['array']['content']['void'];
	}
	
	public function get_paper_size(){
		return (float) $this->rawdata['java']['content']['object']['content']['void'][2]['content']['double']['_v'];
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
	
	public function output_image(){
		header("Content-type: image/png");
		$this->image = @imagecreate($this->width+1, $this->height+1) 
					or die("Could not create new Image!");
		
		$background = imagecolorallocate($this->image, 255,255,255);
		
		foreach($this->lines as $line){
			$this->drawcrease($line);
		}
		
		imagepng($this->image);
		imagedestroy($this->image);
	}
	
	public function drawcrease($line){
		
		$linecolor  = imagecolorallocate($this->image, $this->linecolors[$line->type][0], $this->linecolors[$line->type][1], $this->linecolors[$line->type][2]);
		
//		$this->linecolors[0][2] = ($this->linecolors[0][2]+5)%255;
//		$this->linecolors[1][1] = ($this->linecolors[1][1]+5)%255;
//		$this->linecolors[2][0] = ($this->linecolors[2][0]+5)%255;
//		$this->linecolors[3][2] = ($this->linecolors[3][2]+5)%255;
		
		$x0 = $this->resize($line->x0);
		$x1 = $this->resize($line->x1);
		$y0 = $this->resize($line->y0);
		$y1 = $this->resize($line->y1);
		
//		imagefilledellipse($this->image, $x0,$y0, 5,5, $linecolor);
//		imagefilledellipse($this->image, $x1,$y1, 5,5, $linecolor);
		
		if(!imageline($this->image, $x1, $y1, $x0, $y0, $linecolor)) die("COULDN'T DRAW ($x0,$x1), ($y0,$y1)");
	}
	
	public function debug(){
		
		$debugvars = array(
			"get_paper_size()"=>$this->get_paper_size(),
			"width"=>$this->width
		);
		
		foreach($debugvars as $label => $value){
			$return .= "$label: $value\n";
		}
		
		return $return;
	}
	
	public function resize($value){
		$ps = $this->get_paper_size();
	
		$increment = $ps/2;
		
		$factor = $this->width/$ps;
	
		return intval(round((($value+$increment)*$factor)));
	
	}
	
}

class Line{

	public $x0;
	public $x1;
	public $y0;
	public $y1;
	
	public $rawdata;
	public $problems;
	
	public $type;
	
	private $valid = false;
	
	public function __construct($linedata){
		
		$this->rawdata = $linedata;
		
		$points = self::get_line_data($this->rawdata);
			
		if($points){
			$this->valid = true;
			list(      $this->type,     $this->x0,     $this->x1,     $this->y0,     $this->y1    )
			   = array($points['type'], $points['x0'], $points['x1'], $points['y0'], $points['y1']);
		}
		
		$this->rawdata = null;
	
	}

	public function get_line_data(){
		$linecontent = $this->rawdata['content']['object']['content']['void'];
		foreach($linecontent as $datapoint){
			switch($datapoint['attributes']['property'])
			{
				case "type":
					$returnLine['type'] = $datapoint['content']['int']['_v'];
					break;
				case "x0":
				case "y0":
				case "x1":
				case "y1":
					$returnLine[$datapoint['attributes']['property']] = 0+$datapoint['content']['double']['_v'];
					break;
			}
		}
		
		if($returnLine['type'] && $returnLine['x0'] && $returnLine['x1'] && $returnLine['y0'] && $returnLine['y1'])
		{
			return $returnLine;
		}else{
			foreach(array('type', 'x0', 'x1', 'y0', 'y1') as $param){
				if(!$returnLine[$param]){
					$returnLine[$param] = 0;
					$this->problems[] = "No $param";
				}
			}
			return $returnLine;
		}
	}
	
	public function isValid(){
		return $this->valid;
	}
	
	public function get_problems(){
		foreach($this->problems as $problem){
			$message .= "$problem \n";
		}
		
		return $message;
	}
	
	
}
?>