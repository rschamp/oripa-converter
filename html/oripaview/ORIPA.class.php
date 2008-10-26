<?php
require_once('ORIPALine.class.php');
require_once('CreasePattern.class.php');

class ORIPA extends CreasePattern{

	private $line_data;
	
	public $reference;
	public $memo;

	public function __construct($file, $filename=""){
	
		$this->file = $file;
		if($filename!=""){
			$file = $filename;
		}
		$this->filename = basename($file);
		$this->imagename = basename($file, ".opx").".png";
		$this->raw_data = simplexml_load_file($this->file);
		$this->process_metadata();
				
		foreach($this->line_data as $id => $line_array){
			
			$this->add_XML_line($line_array);
		}
			
	}
	
	public function process_metadata(){
		foreach($this->raw_data->object->void as $node){
			switch($node->attributes()->property){
				case "lines":
					$this->line_data = $node->array->void;
					break;
				case "editorName":
					$this->editor = $node->string;
					break;
				case "title":
					$this->title = $node->string;
					break;
				case "paperSize":
					$this->size = $node->double;
					break;
				case "originalAuthorName":
					$this->author = $node->string;
					break;
				case "reference":
					$this->reference = $node->string;
					break;
				case "memo":
					$this->memo = $node->string;
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