<?php
if($_GET['url']!==null):

	if($_GET['url']==""){
		$url = "http://svn.rayschamp.com/origami/generalized_degrees/1parallel2yoshimura.opx";
	}else{
		$url = $_GET['url'];
	}
	
endif;

if (($_REQUEST['view']=="image" || $_REQUEST['view'] == "info" || $_REQUEST['view'] == "debug") && ($url || $_FILES) ):

	require_once('ORIPA.class.php');
	
	if($url){
		
		$file = $url;
		$filename = "";
	
	}elseif($_FILES){
	
		$file = $_FILES['opxfile']['tmp_name'];
		$filename = $_FILES['opxfile']['name'];
		if($file==""){
			include("enhanced_query.php");
			exit(0);
		}
		
	}else{
	
		die("What did you do??");
	
	}
	
	
	$oripa = new ORIPA($file, $filename);
	
	if($_REQUEST['view'] == "image"):
	
		if($_GET['size'] == "thumbnail") $size = 100;
	
		$oripa->output_image($size);
//		echo "<pre>".print_r($oripa,true),"</pre>";
	
	elseif($_REQUEST['view']=="info"):
	
		include("info.php");
		
	elseif($_REQUEST['view'] == "debug"):
	
		include("debug.php");
	
	endif;
	
	
else:
	include("enhanced_query.php");
endif;
?>