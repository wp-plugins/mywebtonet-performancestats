<?
error_reporting(0);
include("phpgraphlib.php");
include("phpgraphlib_pie.php");
$graph=new PHPGraphLibPie(450,300);
$header = unserialize(urldecode(stripslashes($_GET['header'])));
$data   = unserialize(urldecode(stripslashes($_GET['mydata'])));
$graph->setTitleLocation('left');
$graph->addData($data);
$graph->setTitle($header);
$graph->setLabelTextColor("blue");
$graph->createGraph();

?>
