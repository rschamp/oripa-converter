<?php
require_once('Line.class.php');

class ORIPALine extends Line{

	public $rawdata;
	public $problems;
	
	public function __construct($linedata){
		
		$this->rawdata = $linedata;
		
		$points = $this->get_line_data();
			
		if($points){
			$this->valid = true;
			list(      $this->type,     $this->x0,     $this->x1,     $this->y0,     $this->y1    )
			   = array($points['type'], $points['x0'], $points['x1'], $points['y0'], $points['y1']);
		}
		
#		$this->rawdata = null;
	
	}
	
	public function __toString(){
		$data = $this->get_line_data();
		
		return "[({$data[x0]},{$data[y0]}), ({$data[x1]},{$data[y1]})]: Type {$data[type]}";
	}

	public function get_line_data(){
		$linecontent = $this->rawdata->object->void;
#		echo "<pre>".print_r($this->rawdata,true)."</pre>";
		foreach($linecontent as $datapoint){
			switch($datapoint->attributes()->property)
			{
				case "type":
					$returnLine['type'] = (int) $datapoint->int[0];
					break;
				case "x0":
				case "y0":
				case "x1":
				case "y1":
					$returnLine["{$datapoint->attributes()->property}"] = (float) $datapoint->double[0];
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