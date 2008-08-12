<?php
	
	$foldoclock = dir("..");

	while(false !== ($file = $foldoclock->read())){
		if (substr($file, -3 , 3) == "opx"){
			$files[] = $file;
		}
	}

	$foldoclock->close();
	
	$select = "<select name='url' id='urlselect'>\n\t<option value=''>Choose one</option>\n";
	foreach($files as $file){
		$select .= "\t<option value='http://fold.oclock.am/$file'>$file</option>\n";
	}
	
	$select .= "</select>\n";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>ORIPA Viewer</title>
		<link rel="stylesheet" type="text/css" href="../style.css" />
	</head>
	<body id="oripaview">
		<h1>ORIPA Viewer</h1>
		<p>If you would like to look at an ORIPA file but don't feel like opening it in ORIPA, you can use this to generate a PNG.</p>
		<form action="./" method="get">
			<fieldset>
				<legend>Enter your URL</legend>
				<label for="url_field">URL:</label>
				<input type="text" name="url" id="url_field" />
				<input type="submit" name="action" id="submit_button" value="Generate PNG" />
				<input type="hidden" name="view" value="info" />
			</fieldset>
		</form>
		<form action="./" method="post" enctype="multipart/formdata">
			<fieldset>
				<legend>Choose a file on your computer</legend>
				<label for="url_field">Upload:</label>
				<input type="file" name="opxfile" id="filefield" />
				<input type="submit" name="action" id="submit_button" value="Generate PNG" />
				<input type="hidden" name="view" value="image" />
			</fieldset>
		</form>
		<form action="./" method="get">
			<fieldset>
				<legend>Choose a file on my server</legend>
				<label for="url_field">URL:</label>
				<?php echo $select; ?>
				<input type="submit" name="action" id="submit_button" value="Generate PNG" />
				<input type="hidden" name="view" value="info" />
			</fieldset>
		</form>
		
		<p><a href="http://mitani.cs.tsukuba.ac.jp/pukiwiki-oripa/index.php?ORIPA%3B%20Origami%20Pattern%20Editor">ORIPA</a> is a CAD program written by Jun Mitani specifically for creating origami crease patterns.</p>
		<p>The <a href="http://mitani.cs.tsukuba.ac.jp/pukiwiki-oripa/index.php?Download">Japanese page</a> (though most of the text is in English) is where to find the latest version.</p>
		
		<p>Please send any comments to ray dot schamp at gmail dot com.</p>
	</body>
</html>
