<?php
if($_GET['url']!==null):

	if($_GET['url']==""){
		$url = "http://svn.rayschamp.com/origami/generalized_degrees/1parallel2yoshimura.opx";
	}else{
		$url = $_GET['url'];
	}

	require_once('ORIPA.class.php');
	
	ob_start();
	passthru("wget -O- --quiet ". escapeshellarg($url));
	$opx = ob_get_contents();
	ob_clean();
	
	$raw = xml2ary($opx);
	
	$oripa = new ORIPA($raw);
	
	if($_GET['action'] != "Debug"){
		$oripa->output_image();
	}else{
	
		echo "<pre>";
//		print_r ($oripa->errors);
		print_r ($oripa->lines);
		
//		print_r ($raw);
		echo "</pre>";
	}
	
else:
	include("query.html");
endif;
?>