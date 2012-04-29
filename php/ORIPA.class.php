<?php
require_once('ORIPALine.class.php');
require_once('CreasePattern.class.php');

class ORIPA extends CreasePattern{

	private $line_data;
	
	public $reference;
	public $memo;

	public function __construct($file, $filename="", $type="png"){
	
		if(in_array($type, $this->imagetypes)){
			$this->imagetype_extension = $type;
		}else{
			$this->imagetype_extension = $this->default_imagetype_extension;
		}
		
		$this->imagetype = $this->imagetypes[$this->imagetype_extension];
		$this->imagefunction = "image{$this->imagetype}";
		
		$this->file = $file;
		if($filename==""){
			$filename = $file;
		}
		$this->filename = basename($filename);
		$this->imagename = basename($filename, ".opx").".{$this->imagetype_extension}";
		$this->raw_data = simplexml_load_file($this->file);
		$this->process_metadata();
				
		foreach($this->line_data as $id => $line_array){
			
			$this->add_XML_line($line_array);
		}
			
	}
	
	public function map($key,$var){
		return implode("=",array($key,$this->$var));
	}
	
	public function __toString(){
		$callback = array($this,"map");
		return implode("&", array_map($callback,array_keys(self::$params),array_values(self::$params)));
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