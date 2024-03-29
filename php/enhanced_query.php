<?php
	
	$foldoclock = dir("..");

	while(false !== ($file = $foldoclock->read())){
		if (substr($file, -4 , 4) == ".opx"){
			$files[] = $file;
		}
	}

	$foldoclock->close();
	
	$select = "<select name='url' id='urlselect'>\n\t<option value=''>Choose one</option>\n";
	foreach($files as $file){
		$select .= "\t<option value='http://{$_SERVER['SERVER_NAME']}/$file'>$file</option>\n";
	}
	
	$select .= "</select>\n";
	
	
	header("Content-Type: text/html; charset=utf-8");
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
				<input type="hidden" name="view" value="info" />
				<label for="url_field">URL:</label>
				<input type="text" name="url" id="url_field" />
				<label for="type_select">Type:</label>
				<select name="type" id="type_select">
					<option value="png">PNG</option>
					<option value="jpg">JPG</option>
					<option value="gif">GIF</option>
				</select>
				<input type="submit" name="action" id="submit_button" value="Generate" />
			</fieldset>
		</form>
		<form action="./" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend>Choose a file on your computer</legend>
				<input type="hidden" name="view" value="info" />
				<label for="filefield">Upload:</label>
				<input type="file" name="opxfile" id="filefield" />
				<label for="type_select">Type:</label>
				<select name="type" id="type_select">
					<option value="png">PNG</option>
					<option value="jpg">JPG</option>
					<option value="gif">GIF</option>
				</select>
				<input type="submit" name="action" id="submit_button" value="Generate" />
			</fieldset>
		</form>
		<form action="./" method="get">
			<fieldset>
				<legend>Choose a file on my server</legend>
				<input type="hidden" name="view" value="info" />
				<label for="url_field">URL:</label>
				<?php echo $select; ?>
				<label for="type_select">Type:</label>
				<select name="type" id="type_select">
					<option value="png">PNG</option>
					<option value="jpg">JPG</option>
					<option value="gif">GIF</option>
				</select>
				<input type="submit" name="action" id="submit_button" value="Generate" />
			</fieldset>
		</form>
		<?php include("generalinfo.php"); ?>
	</body>
</html>
