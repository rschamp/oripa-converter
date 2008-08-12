<?php $title = basename($url); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php echo $title ?></title>
		<link rel="stylesheet" type="text/css" href="../style.css" />
	</head>
	<body>
		<h1><?php echo $title; ?></h1>
		<p>Download: <a href="<?php echo $url; ?>"><?php echo $title ?></a></p>
		<p>Image:</p>
		
		<?php $embedtext = <<<EOT
		<a href="{$_SERVER['SCRIPT_URI']}?url=$url&view=image" title="View full size">
			<img src="{$_SERVER['SCRIPT_URI']}?url=$url&view=image&size=thumbnail" title="$title" />
		</a>
EOT;
		
		echo $embedtext;
?>		
		<p>Thumbnail embed code: </p>
		<code>
			<?php echo htmlentities($embedtext); ?>
		</code>

		
		<img src="<?php echo $_SERVER['SCRIPT_URI']; ?>?url=<?php echo $url; ?>&view=image" class="maxsizeimage"/>

		
	</body>
</html>
