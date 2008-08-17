<?php
require_once('xmltoarray.php');
require_once('ORIPALine.class.php');
require_once('CreasePattern.class.php');

class ORIPA extends CreasePattern{

	public $raw_data;
	private $line_data;
	
	public $reference;
	public $memo;
	

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
		
		$new_line = new ORIPALine($line_array);
		
		$this->addORIPALine($new_line);
		
	}
	
	public function addORIPALine($new_line){
	
		if($new_line->isValid()){
			$this->lines[] = $new_line;
			return true;
		}else{
			$this->errors[] = $new_line->get_problems();
		}
	
	}
	
}


?>