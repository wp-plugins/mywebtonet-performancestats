<?php
error_reporting(0);
include("phpgraphlib.php");
$datavalues = $_GET['datavalues'];
$showsmall = $_GET['showsmall'];
$header = unserialize(urldecode(stripslashes($_GET['header'])));
$data   = unserialize(urldecode(stripslashes($_GET['mydata'])));
$data2   = unserialize(urldecode(stripslashes($_GET['mywebdata'])));
if ($showsmall) {
  $graph=new PHPGraphLib(300,300);
}  else {
  $graph=new PHPGraphLib(500,300);

}
$graph->addData($data);
$graph->addData($data2);
//$graph->setDataValues(true);
//$graph->setLegend(true);
//$graph->setLegendTitle('Your data','MyWebToNet');
$graph->setXValuesHorizontal(TRUE);
$graph->setTitle($header);
//$graph->setTitleLocation('left');
$graph->setTextColor('blue');
$graph->setBarColor('blue', 'green');
//$graph->setLegend(TRUE);
$graph->createGraph();

?>
