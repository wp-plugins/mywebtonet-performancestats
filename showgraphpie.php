<?php
error_reporting(0);
include("phpgraphlib.php");
include("phpgraphlib_pie.php");
$showsmall = $_GET['showsmall'];
$datavalues = $_GET['datavalues'];
$header = unserialize(urldecode(stripslashes($_GET['header'])));
$data   = unserialize(urldecode(stripslashes($_GET['mydata'])));
if ($showsmall) {
  $graph=new PHPGraphLibPie(300,200);
} else {
  $graph=new PHPGraphLibPie(500,300);

}

if ($datavalues) {
  $graph->setDataValues(true);
} else {
  $graph->setDataValues(false);

}
$graph->addData($data);
$graph->setTitle($header);
$graph->setLabelTextColor("blue");
$graph->createGraph();

?>
