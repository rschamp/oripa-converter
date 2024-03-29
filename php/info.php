<?php 
if($oripa->title){
	$title = $oripa->title;
}else{
	$title = $oripa->filename;
}

$filename = $oripa->filename;

$embedtext = <<<EOT
<a href="{$_SERVER['SCRIPT_URI']}?$oripa&view=info" title="View full size"><img src="{$_SERVER['SCRIPT_URI']}?$oripa&view=image&size=thumbnail" title="$title" /></a>
EOT;

$metadata = array(
	"Author" => $oripa->author, 
	"Editor" => $oripa->editor, 
	"Reference" => $oripa->reference, 
	"Notes" => $oripa->memo);
	
foreach($metadata as $label => $metacontent){
	if($metacontent){
		$metadata_copy .= sprintf("<h3>%s</h3>\n<p class='metacontent'>%s</p>\n",
							$label,
							str_replace("\n", "<br />", $metacontent)
						  );
	}
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
		<h1><a href="<?php echo $_SERVER['SCRIPT_URI'];?>">ORIPA Viewer</a></h1>
		
		<h2><?php echo $title; ?></h2>
		<p>(size has been reduced, download or right click and "View image" for full size):</p>
		<img src="<?php echo "{$_SERVER['SCRIPT_URI']}?$oripa&view=image";?>" class="maxsizeimage"/>

		<?php echo $metadata_copy; ?>

		<h2>Original ORIPA File</h2>
		<p><a href="<?php echo $url; ?>"><?php echo $filename; ?></a></p>
		

		<h2>Thumbnail Embed Code</h2>
		<code>
			<?php echo htmlentities($embedtext); ?>
		</code>

		<?php include("generalinfo.php"); ?>
	</body>
</html>
