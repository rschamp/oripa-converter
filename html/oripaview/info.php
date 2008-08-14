<?php 
if($oripa->title){
	$title = $oripa->title;
}else{
	$title = basename($url);
}

$embedtext = <<<EOT
<a href="{$_SERVER['SCRIPT_URI']}?url=$url&view=info" title="View full size"><img src="{$_SERVER['SCRIPT_URI']}?url=$url&view=image&size=thumbnail" title="$title" /></a>
EOT;

$metadata = array(
	"Title" => $oripa->title, 
	"Original Author" => $oripa->author, 
	"Editor" => $oripa->editor, 
	"Reference" => $oripa->reference, 
	"Notes" => $oripa->memo);
	
foreach($metadata as $label => $metacontent){
	if($metacontent){
		$metacontent = str_replace("\n", "<br />", $metacontent);
		$metadata_copy .= "<h3>$label</h3>\n<p class='metacontent'>$metacontent</p>\n";
	}
}

if($metadata_copy){
	$metadata_copy = "<h2>Metadata</h2>\n$metadata_copy";
}

	

	header("Content-Type: text/html; charset=utf-8");

?>		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php echo $title ?></title>
		<link rel="stylesheet" type="text/css" href="../style.css" />
	</head>
	<body>
		<h1><?php echo $title; ?></h1>
		
		<h2>Image</h2>
		<p>(size has been reduced, download or right click and "View image" for full size):</p>
		<img src="<?php echo $_SERVER['SCRIPT_URI']; ?>?url=<?php echo $url; ?>&view=image" class="maxsizeimage"/>

		<h2>Original ORIPA File</h2>
		<p><a href="<?php echo $url; ?>"><?php echo $title ?></a></p>
		
		<?php echo $metadata_copy; ?>

		<h2>Thumbnail Embed Code</h2>
		<code>
			<?php echo htmlentities($embedtext); ?>
		</code>

		<?php include("generalinfo.php"); ?>
	</body>
</html>
