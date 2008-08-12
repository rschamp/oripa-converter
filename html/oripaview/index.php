<?php
if($_GET['url']!==null):

	if($_GET['url']==""){
		$url = "http://svn.rayschamp.com/origami/generalized_degrees/1parallel2yoshimura.opx";
	}else{
		$url = $_GET['url'];
	}
	
endif;

if (($_GET['view']=="image" || $_POST['view']=="image") && ($url || $_FILES) ):

	require_once('ORIPA.class.php');
	
	if($url){
	
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
	
	$raw = xml2ary($opx);
	
	$oripa = new ORIPA($raw);
	
	if($_GET['action'] != "Debug" && $_POST['action'] !== "Debug"):
	
		if($_GET['size'] == "thumbnail") $size = 100;
	
		$oripa->output_image($size);
	
	elseif($_GET['action'] == "Debug"):
	
		include("debug.php");
	
	endif;
	
elseif($_GET['view']=="info" && $url):

	include("info.php");
	
else:
	include("enhanced_query.php");
endif;
?>