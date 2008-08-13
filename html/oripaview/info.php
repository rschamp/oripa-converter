<?php 
$title = basename($url); 
$embedtext = <<<EOT
<a href="{$_SERVER['SCRIPT_URI']}?url=$url&view=info" title="View full size"><img src="{$_SERVER['SCRIPT_URI']}?url=$url&view=image&size=thumbnail" title="$title" /></a>
EOT;
?>		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php echo $title ?></title>
		<link rel="stylesheet" type="text/css" href="../style.css" />
	</head>
	<body>
		<h1><?php echo $title; ?></h1>
		
		<h2>Original ORIPA File</h2>
		<p><a href="<?php echo $url; ?>"><?php echo $title ?></a></p>
		
		<h2>Thumbnail Embed Code</h2>
		<code>
			<?php echo htmlentities($embedtext); ?>
		</code>

		
		<h2>Image</h2>
		<p>(size has been reduced, download or right click and "View image" for full size):</p>
		<img src="<?php echo $_SERVER['SCRIPT_URI']; ?>?url=<?php echo $url; ?>&view=image" class="maxsizeimage"/>

		<?php include("generalinfo.php"); ?>
	</body>
</html>
