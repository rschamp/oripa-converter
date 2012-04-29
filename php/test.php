<?php
error_reporting(E_ALL);
require_once("ORIPA.class.php");

$oripa_web   = new ORIPA("http://svn.rayschamp.com/origami/to_be_filed/opx/1R2Y.opx");
$oripa_local = new ORIPA("../1R2Y.opx");

#echo "<pre>".print_r(array($oripa_web, $oripa_local), true)."</pre>";

$oripa_web->output_image();

?>