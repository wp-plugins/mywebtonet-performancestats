<?
error_reporting(0);
include("phpgraphlib.php");
$graph=new PHPGraphLib(450,300);
$datavalues = $_GET['datavalues'];
$showsmall = $_GET['showsmall'];
$header = unserialize(urldecode(stripslashes($_GET['header'])));
$data   = unserialize(urldecode(stripslashes($_GET['mydata'])));
if ($showsmall) {
  $graph=new PHPGraphLib(300,200);
}  else {
  $graph=new PHPGraphLib(450,300);

}

$graph->addData($data);
$graph->setDataValues(true);
// $graph->setTitleLocation('left');
$graph->setXValuesHorizontal(TRUE);
$graph->setTitle($header);
$graph->setTextColor('blue');
$graph->setBarColor('#0066CC', '#669999', '#66CCCC');
//$graph->setLegend(TRUE);
$graph->createGraph();

?>
