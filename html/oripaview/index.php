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
	
#		$opx = file_get_contents("lightning.opx");
		ob_start();
		passthru("wget -O- --quiet ". escapeshellarg($url));
		$opx = ob_get_contents();
		ob_clean();
	
	}elseif($_FILES){
	
		$opx = file_get_contents($_FILES['opxfile']['tmp_name']);
		if($opx==""){
			include("enhanced_query.php");
			exit(0);
		}
		
	}else{
	
		die("What did you do??");
	
	}
	
	$raw = simplexml_load_string($opx);
	
	$oripa = new ORIPA($raw);
	
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