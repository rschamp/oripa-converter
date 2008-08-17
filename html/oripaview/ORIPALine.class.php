<?php
require_once('Line.class.php');

class ORIPALine extends Line{

	public $rawdata;
	public $problems;
	
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
					$returnLine[$datapoint['attributes']['property']] = $datapoint['content']['double']['_v'];
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
	
	public function get_problems(){
		if($this->problems && is_array($this->problems)){
			foreach($this->problems as $problem){
				$message .= "$problem \n";
			}
		}
		
		return $message;
	}
	
	
}
?>