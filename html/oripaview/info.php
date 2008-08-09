<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php echo basename($url); ?></title>
		<link rel="stylesheet" type="text/css" href="../style.css" />
	</head>
	<body>
		<h1><?php echo basename($url); ?></h1>
		<p>Download: <a href="<?php echo $url; ?>"><?php echo basename($url); ?></a></p>
		<p>Image:</p>
		<img src="http://fold.oclock.am/oripaview/?url=<?php echo $url; ?>&view=image" class="maxsizeimage"/>
	</body>
</html>
