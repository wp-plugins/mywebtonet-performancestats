<?php
/**
 * @package mywebtonet performance statistics
 * @version 1.0.4
 */
/*
Plugin Name: PHP/MySQL CPU performance statistics
Plugin URI: http://www.mywebtonet.com/files/wordpressplugins
Description: A simple plugin that tests CPU performance on your web and MySQL server.
Author: WebHosting A/S - MyWebToNet Ltd.
Version: 1.0.4
Author URI: http://www.mywebtonet.com 
*/

// $showtest	= $_GET["showtest"];


$ourdatamysql53 = array("MySQL 1" => 3.52,"MySQL 2" => 1.10,"MySQL 3" => 0.48);	
$ourdatamysql54 = array("MySQL 1" => 3.53,"MySQL 2" => 1.13,"MySQL 3" => 0.50);	
$ourdatamysql55 = array("MySQL 1" => 3.52,"MySQL 2" => 1.10,"MySQL 3" => 0.49);	
$ourdataphp53 = array("PHP 1" => 1.45,"PHP 2" => 0.70,"PHP 3" => 0.40,"PHP 4" => 0.66);	
$ourdataphp54 = array("PHP 1" => 0.29,"PHP 2" => 0.64,"PHP 3" => 0.29,"PHP 4" => 0.37);	
$ourdataphp55 = array("PHP 1" => 0.28,"PHP 2" => 0.61,"PHP 3" => 0.24,"PHP 4" => 0.31);	


if ( !defined('ABSPATH') ) {
	echo "<center>You cant do this";
        exit();
}

$mysqltests =array("select BENCHMARK(500000000, EXTRACT(YEAR FROM NOW()))","select BENCHMARK(10000000,ENCODE('hello','goodbye'))","select BENCHMARK(25000000,1+1*2);");

add_action('plugins_loaded', 'myweb_init');
add_action('admin_menu', 'mywebtonetperftest_plugin_menu');

function myweb_init() {
	$pathinfo = pathinfo(dirname(plugin_basename(__FILE__)));  
        if (!defined('MYWEB_NAME')) define('MYWEB_NAME', $pathinfo['filename']);
	if (!defined('MYWEB_URL')) define('MYWEB_URL', plugins_url(MYWEB_NAME) . '/');

}                   
                     
function mywebtonetperftest_showfromdb($showtype) {
	global $wpdb;
	global $ourdatamysql55;
	global $ourdataphp55;

	$tableprefix = $wpdb->prefix."mywebtonetperfstatsresults";
	mywebtonetperftest_createtable();
	?>
	<center>
	
	<?
	if ($showtype == "fast") {
		$headertext = "Best time";
		$getdata = $wpdb->get_results("select sum(mysql1+mysql2+mysql3) as mysqlresult,sum(php1+php2+php3+php4) as phpresult,uniqid, servername, serveraddr, memorylimit,phpversion,postmaxsize,mysqlversion,phpos,serverloadnow,serverload5,serverload15,mysql1,mysql2,mysql3,php1,php2,php3,php4,deleteable,DATE_FORMAT(dt, '%W %D %M %Y %T') as tt,phpuname from $tableprefix where deleteable=1 group by uniqid order by mysqlresult asc limit 1;");
	}	
	if ($showtype == "slow") {
		$headertext = "Slowest time";
		$getdata = $wpdb->get_results("select sum(mysql1+mysql2+mysql3) as mysqlresult,sum(php1+php2+php3+php4) as phpresult,uniqid, servername, serveraddr, memorylimit,phpversion,postmaxsize,mysqlversion,phpos,serverloadnow,serverload5,serverload15,mysql1,mysql2,mysql3,php1,php2,php3,php4,deleteable,DATE_FORMAT(dt, '%W %D %M %Y %T') as tt,phpuname from $tableprefix where deleteable=1 group by uniqid order by mysqlresult desc limit 1;");
	}	

	foreach ( $getdata as $getdata ) {
	}
	if ($getdata->uniqid == "") {
		echo "<center><H4>You need to run a test first</h4>";
		exit;
	}

	?>
	<br><br><h3><? echo $headertext?></h3>
	<table width='90%' cellpadding=2 cellspacing=2 style='background: #FFFFFF;border-radius:10px;-moz-border-radius:10px;-webkit-border-radius:10px;border: 2px solid #cccccc;'>
	<tr><td width=50%>
	<table border=0>
	<tr><td valign='top' align='left'>Time of test</td><td valign='top' align='left'><font color='blue'><a href='http://<? echo $getdata->servername ?>' target=_blank</a><? echo $getdata->tt;?></font></td></tr>
	<tr><td valign='top' align='left'>Server name</td><td valign='top' align='left'><font color='blue'><a href='http://<? echo $getdata->servername ?>' target=_blank</a><? echo $getdata->servername;?></font></td></tr>
	<tr><td valign='top' align='left'>Server Addr</td><td valign='top' align='left'><font color='blue'><? echo $getdata->serveraddr;?></font></td></tr>
	<tr><td valign='top' align='left'>Host OS</td><td valign='top' align='left'><? echo $getdata->phpos;?></td></tr>
	<tr><td><br></td></tr>
	<tr><td valign='top' align='left'><b>Server load statistics</b></td></tr>
	<tr><td valign='top' align='left'>Load now</td><td valign='top' align='left'><font color='blue'><? echo $getdata->serverloadnow;?></td></tr>
	<tr><td valign='top' align='left'>Load 5 min</td><td valign='top' align='left'><? echo $getdata->serverload5;?></td></tr>
	<tr><td valign='top' align='left'>Load 15 min</td><td valign='top' align='left'><? echo $getdata->serverload15;?></td></tr>
	<tr><td><br></td></tr>
	<tr><td valign='top' align='left'><b>PHP statistics</b></td></tr>
	<tr><td valign='top' align='left'>PHP uname</td><td valign='top' align='left'><? echo $getdata->phpuname;?></td></tr>
	<tr><td valign='top' align='left'>PHP version</td><td valign='top' align='left'><? echo $getdata->phpversion;?></td></tr>
	<tr><td valign='top' align='left'>PHP memory limit</td><td valign='top' align='left'><font color='blue'><? echo $getdata->memorylimit;?></td></tr>
	<tr><td valign='top' align='left'>PHP postmaxsize</td><td valign='top' align='left'><font color='blue'><? echo $getdata->postmaxsize;?></td></tr>
	<tr><td valign='top' align='left'>PHP test 1</td><td valign='top' align='left'><? echo $getdata->php1;?></td></tr>
	<tr><td valign='top' align='left'>PHP test 2</td><td valign='top' align='left'><? echo $getdata->php2;?></td></tr>
	<tr><td valign='top' align='left'>PHP test 3</td><td valign='top' align='left'><? echo $getdata->php3;?></td></tr>
	<tr><td valign='top' align='left'>PHP test 4</td><td valign='top' align='left'><? echo $getdata->php4;?></td></tr>
	<tr><td valign='top' align='left'>PHP total time</td><td valign='top' align='left'><? echo sprintf("<font color='blue'><b>%10.2f</b>",$getdata->phpresult);?></td></tr>
	<tr><td><br></td></tr>
	<tr><td valign='top' align='left'><b>MySQL statistics</b></td></tr>
	<tr><td valign='top' align='left'>MySQL version</td><td valign='top' align='left'><? echo $getdata->mysqlversion;?></td>
	<tr><td valign='top' align='left'>MySQL 1</td><td valign='top' align='left'><? echo $getdata->mysql1;?></td></tr>
	<tr><td valign='top' align='left'>MySQL 2</td><td valign='top' align='left'><? echo $getdata->mysql2;?></td></tr>
	<tr><td valign='top' align='left'>MySQL 3</td><td valign='top' align='left'><? echo $getdata->mysql3;?></td></tr>
	<tr><td valign='top' align='left'>MySQL total time</td><td valign='top' align='left'><font color='blue'><b><? echo $getdata->mysqlresult;?></b></td></tr>
	<tr><td><br></td></tr>
	<tr><td valign='top' align='left'><b>Summary</b></td></tr>
	<tr><td valign='top' align='left'>Total</td><td valign='top' align='left'><font color='blue'><b><? echo sprintf("%10.2f",$getdata->phpresult+$getdata->mysqlresult);?></b></font></td>
	</table>
	<?
		$datamysql = array("MySQL 1" => $getdata->mysql1,"MySQL 2" => $getdata->mysql2,"MySQL 3" => $getdata->mysql3);	
		$dataphp = array("PHP 1" => $getdata->php1,"PHP 2" => $getdata->php2,"PHP 3" => $getdata->php3,"PHP 4" => $getdata->php4);	

	?>		
		<td valign='top' align='left'>
			<table>
			<tr>
			<td><img src="<?php echo MYWEB_URL; ?>showgraphpie.php?showsmall=1&header=<?php echo urlencode(serialize("MySQL results")); ?>&mydata=<?php echo urlencode(serialize($datamysql)); ?>" /></td>
			<td><img src="<?php echo MYWEB_URL; ?>showgraphpie.php?showsmall=1&header=<?php echo urlencode(serialize("MySQL results")); ?>&mydata=<?php echo urlencode(serialize($dataphp)); ?>" /></td>
			<br>
			</tr>
			<tr>	
			<td><img src="<?php echo MYWEB_URL; ?>showgraph.php?showsmall=1&header=<?php echo urlencode(serialize("Lower is better, Your server=Blue, Ours=Green")); ?>&mywebdata=<?php echo urlencode(serialize($ourdatamysql55));?>&mydata=<?php echo urlencode(serialize($datamysql)); ?>" /></td>
			<td><img src="<?php echo MYWEB_URL; ?>showgraph.php?showsmall=1&header=<?php echo urlencode(serialize("Lower is better, Your server=Blue, Ours=Green")); ?>&mywebdata=<?php echo urlencode(serialize($ourdataphp55)); ?>&mydata=<?php echo urlencode(serialize($dataphp)); ?>" /></td>
			</tr>	
			</table>		
		</td>
	</td></tr>
	</table>
	<?	
}


function mywebtonetperftest_showlist() {
	global $wpdb;
	global $ourdatamysql53;
	global $ourdatamysql54;
	global $ourdatamysql55;
	global $ourdataphp53;
	global $ourdataphp54;
	global $ourdataphp55;
	mywebtonetperftest_createtable();
	$mysqltotal53 = sprintf("%10.2f",$ourdatamysql53["MySQL 1"] + $ourdatamysql53["MySQL 2"] + $ourdatamysql53["MySQL 3"]);
	$mysqltotal54 = sprintf("%10.2f",$ourdatamysql54["MySQL 1"] + $ourdatamysql54["MySQL 2"] + $ourdatamysql54["MySQL 3"]);
	$mysqltotal55 = sprintf("%10.2f",$ourdatamysql55["MySQL 1"] + $ourdatamysql55["MySQL 2"] + $ourdatamysql55["MySQL 3"]);
	$phptotal53 = sprintf("%10.2f",$ourdataphp53["PHP 1"] + $ourdataphp53["PHP 2"] + $ourdataphp53["PHP 3"]  + $ourdataphp53["PHP 4"]);
	$phptotal54 = sprintf("%10.2f",$ourdataphp54["PHP 1"] + $ourdataphp54["PHP 2"] + $ourdataphp54["PHP 3"]  + $ourdataphp54["PHP 4"]);
	$phptotal55 = sprintf("%10.2f",$ourdataphp55["PHP 1"] + $ourdataphp55["PHP 2"] + $ourdataphp55["PHP 3"]  + $ourdataphp55["PHP 4"]);
	$tableprefix = $wpdb->prefix."mywebtonetperfstatsresults";
	$totaltime53 = sprintf("%10.2f",$mysqltotal53+$phptotal53);
	$totaltime54 = sprintf("%10.2f",$mysqltotal54+$phptotal54);
	$totaltime55 = sprintf("%10.2f",$mysqltotal55+$phptotal55);
	?>
	<br><br>
	<table width='90%' border=1 cellpadding=2 cellspacing=2 style='background: #FFFFFF;border-radius:10px;-moz-border-radius:10px;-webkit-border-radius:10px;border: 2px solid #cccccc;'>
	<tr><td>Time of test</td><td>Server name</td><td>Server addr</td><td>PHP version</td><td>MySQL version</td><td>MySQL test time</td><td>PHP Test time</td><td>Total time</td></tr>	
	<?
	echo "<tr><td>Sunday 3rd November 2013 23:45:11</td>
		<td>MyWebToNet PHP 5.3 server</td>
		<td>81.19.232.65</td><td>5.3.27</td>
		<td>5.6.14</td>
		<td>$mysqltotal53</td>
		<td>$phptotal53</td>
		<td><font color='blue'><b>$totaltime53</b></font></td>
		</tr>";
	echo "<tr><td>Sunday 3rd November 2013 23:44:21</td>
		<td>MyWebToNet PHP 5.4 server</td>
		<td>81.19.232.55</td><td>5.4.21</td>
		<td>5.6.14</td>
		<td>$mysqltotal54</td>
		<td>$phptotal54</td>
		<td><font color='blue'><b>$totaltime54</b></font></td>
		</tr>";
	echo "<tr><td>Sunday 3rd November 2013 23:48:33</td>
		<td>MyWebToNet PHP 5.5 server</td>
		<td>81.7.161.141</td><td>5.5.5</td>
		<td>5.6.14</td>
		<td>$mysqltotal55</td>
		<td>$phptotal55</td>
		<td><font color='blue'><b>$totaltime55</b></font></td>
		</tr>";
	
	
	$getdata = $wpdb->get_results("select sum(mysql1+mysql2+mysql3) as mysqlresult,sum(php1+php2+php3+php4) as phpresult,uniqid, servername, serveraddr, memorylimit,phpversion,postmaxsize,mysqlversion,phpos,serverloadnow,serverload5,serverload15,mysql1,mysql2,mysql3,php1,php2,php3,php4,deleteable,DATE_FORMAT(dt, '%W %D %M %Y %T') as tt,phpuname from $tableprefix group by uniqid order by dt asc;");
	foreach ( $getdata as $getdata ) {
		echo "<tr><td valign='top'>".$getdata->tt."</td><td valign='top'><a href='http://".$getdata->servername."' target=_blank>".$getdata->servername."</a></td><td valign='top'>".$getdata->serveraddr."</td><td valign='top'>".$getdata->phpversion."</td><td valign='top'>".$getdata->mysqlversion."</td><td valign='top'>".$getdata->mysqlresult."</td><td valign='top'>".$getdata->phpresult."</td><td valign='top'><font color='blue'><b>";
		echo sprintf("%10.2f",$getdata->phpresult+$getdata->mysqlresult); 
		?>
		</b></font></td>
		</tr>
	<?	
	}
	?>
	</table>	
	<?
}


function mywebtonetperftest_createtable() {
	global $wpdb;
	$tableprefix = $wpdb->prefix."mywebtonetperfstatsresults";
	$createtable = $wpdb->query( "
	CREATE TABLE if not exists `$tableprefix` (
	  `uniqid` bigint(20) NOT NULL auto_increment,
	  `servername` varchar(100) NOT NULL DEFAULT '',
	  `serveraddr` varchar(15) NOT NULL DEFAULT '',
	  `phpversion` varchar(50) NOT NULL DEFAULT '',
	  `phpuname` varchar(50) NOT NULL DEFAULT '',
	  `memorylimit` varchar(10) NOT NULL DEFAULT '',
	  `postmaxsize` varchar(10) NOT NULL DEFAULT '',
	  `mysqlversion` varchar(50) NOT NULL DEFAULT '',
	  `phpos` varchar(50) NOT NULL DEFAULT '',
	  `serverloadnow` decimal(10,2) NOT NULL DEFAULT '0.00',
	  `serverload5` decimal(10,2) NOT NULL DEFAULT '0.00',
	  `serverload15` decimal(10,2) NOT NULL DEFAULT '0.00',
	  `mysql1` decimal(10,2) NOT NULL DEFAULT '0.00',
	  `mysql2` decimal(10,2) NOT NULL DEFAULT '0.00',
	  `mysql3` decimal(10,2) NOT NULL DEFAULT '0.00',
	  `php1` decimal(10,2) NOT NULL DEFAULT '0.00',
	  `php2` decimal(10,2) NOT NULL DEFAULT '0.00',
	  `php3` decimal(10,2) NOT NULL DEFAULT '0.00',
	  `php4` decimal(10,2) NOT NULL DEFAULT '0.00',
	  `deleteable` int(11) NOT NULL default '1',
	  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	   UNIQUE KEY `uniqid` (`uniqid`),
	   KEY `servername` (`servername`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
	 ");	
}
function mywebtonetperftest_cleandb() {
	global $wpdb;
	$tableprefix = $wpdb->prefix."mywebtonetperfstatsresults";
	$createtable = $wpdb->query( "delete from `$tableprefix` where deleteable=1");
	echo "<center><H4>Database is now cleaned</h4>";
	exit;

}


function mywebtonetperftest_slow() {
	mywebtonetperftest_showfromdb("slow");
}

function mywebtonetperftest_fast() {
	mywebtonetperftest_showfromdb("fast");
}

function mywebtonetperftest_plugin_menu() {
	add_menu_page('mywebtonetperftest_plugin_all', 'Performance test', 'manage_options', 'mywebtonetperftest_plugin_all','mywebtonetperftest_plugin_all');
//	add_submenu_page('mywebtonetperftest_plugin_all', __('Run test','myweb-menu'),'', 'manage_options', 'sub-page', 'mywebtonetperftest_plugin_all');
//  	add_submenu_page('mywebtonetperftest_plugin_all', __('Show fastest time','myweb-menu'),__('Show fastest time','myweb-menu'), 'manage_options', 'sub-page2', 'mywebtonetperftest_fast');
//  	add_submenu_page('mywebtonetperftest_plugin_all', __('Show slowest time','myweb-menu'),__('Show slowest time','myweb-menu'), 'manage_options', 'sub-page3', 'mywebtonetperftest_slow');

  	add_submenu_page('mywebtonetperftest_plugin_all', __('Show fastest time','myweb-menu'),__('Show fastest time','myweb-menu'), 'manage_options', 'sub-page2', 'mywebtonetperftest_fast');
  	add_submenu_page('mywebtonetperftest_plugin_all', __('Show slowest time','myweb-menu'),__('Show slowest time','myweb-menu'), 'manage_options', 'sub-page3', 'mywebtonetperftest_slow');
  	add_submenu_page('mywebtonetperftest_plugin_all', __('Show list of tests','myweb-menu'),__('Show list of tests','myweb-menu'), 'manage_options', 'sub-page4', 'mywebtonetperftest_showlist');
  	add_submenu_page('mywebtonetperftest_plugin_all', __('Delete all results','myweb-menu'),__('Delete all results','myweb-menu'), 'manage_options', 'sub-page5', 'mywebtonetperftest_cleandb');
}


function mywebtonetperftest_plugin_all() {
	global $wpdb;
	global $mysqltests;
	global $MySQLtotaltime;
	global $PHPtotaltime;
	global $testmathresult;
	global $teststringresult;
	global $testloopresult;
	global $testifelseresult;
	global $mysqltemp;
	global $mysqlresults;
	global $ourdatamysql55;
	global $ourdataphp55;
	//	
	$servername	= $_SERVER['SERVER_NAME'];
	$serveraddr	= $_SERVER['SERVER_ADDR'];
	$phpversion	= PHP_VERSION;
	$phpos		= PHP_OS;
	$phpuname	= php_uname();
	$memorylimit 	= ini_get("memory_limit");
	$postmaxsize 	= ini_get("post_max_size");
	$mysqlversion = $wpdb->get_var( "select version();" );
	//
	// we need to make a table..
	//
	//
	// General information about server etc etc, we always show these		
	//
	echo "<br>\n";
	echo "<center>Compare with results below, <a href='#footer'><b>click to view</b></a></center>\n";
        echo "<table>\n";
        echo "<tr><td valign='top'>Server : $servername@<font color='blue'><b>".$serveraddr."</b></font></td></tr>\n";
        echo "<tr><td valign='top'>PHP host information : <font color='blue'><b>".$phpuname."</b></font></td></tr>\n";   
        echo "<tr><td valign='top'>PHP version : <font color='blue'><b>".$phpversion."</B></font></td></tr>\n";
	echo "<tr><td valign='top'>PHP memory limit / Post max size: <font color='blue'><b>".$memorylimit." / ".$postmaxsize."</b></font></td></tr>\n";
        echo "<tr><td valign='top'>Platform : <font color='blue'><b>".$phpos."</b></font></td></tr>\n";
        echo "<tr><td valign='top'>MySQL version : <font color='blue'><b>".$mysqlversion."</font></b></td></tr>";
        echo "</table>\n";
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		echo "<tr><td valign='top'>Server load now:</td><td valign='top' align='right'><b>Unable to fetch load as windows is used for webserver (incompatible)</b></td></tr>\n";
	} else {
		$load= sys_getloadavg();
	        echo "<table width=250>\n";
		echo "<tr><td valign='top'>Server load now:</td><td valign='top' align='left'><font color='blue'><b>".sprintf("%6.2f",$load[0])."</b></td></tr>\n";
		echo "<tr><td valign='top'>Server load avg. 5 minutes:</td><td valign='top' align='left'><font color='blue'><b>".sprintf("%6.2f",$load[1])."</b></td></tr>\n";
		echo "<tr><td valign='top'>Server load avg. 15 minutes:</td><td valign='top' align='left'><font color='blue'><b>".sprintf("%6.2f",$load[2])."</b></td></tr>\n";	
	        echo "</table>\n";
	}	

        doHeader();
        doMySQL();
        doPHPTests();
        //
        // Store results in DB
	//
	mywebtonetperftest_createtable();
	$tableprefix = $wpdb->prefix."mywebtonetperfstatsresults";
	$phpuname = addslashes($phpuname);
	$storeresults = $wpdb->query( "	insert into $tableprefix (servername,serveraddr,phpversion,memorylimit,postmaxsize,mysqlversion,phpos,serverloadnow,serverload5,serverload15,mysql1,mysql2,mysql3,php1,php2,php3,php4,phpuname) values ('$servername','$serveraddr','$phpversion','$memorylimit','$postmaxsize','$mysqlversion','$phpos','$load[0]','$load[1]','$load[2]','$mysqlresults[0]','$mysqlresults[1]','$mysqlresults[2]','$testmathresult','$teststringresult','$testloopresult','$testifelseresult','$phpuname');");
        //
	// Finish
	// 
	echo "<table width=70%>\n";
	echo "<tr><td valign='top'><b>All tests:</b></td></tr>\n";
	echo "<tr><td valign='top' width=20%>Total time</td><td valign='top' width=60%><b>(all MySQL + PHP tests)</td><td valign='top' width=20%> :<font color='blue'><b>".sprintf("%6.2f",$PHPtotaltime+$MySQLtotaltime)."</b></font> seconds</td></tr></table>\n";	
	$md5time = md5(time().$servername);
	?>
	<center>
	<br>
	<table width='90%' border=0 bgcolor='fcfcfc' cellpadding=0 cellspacing=6 style='border-width: 1px; border-color:#cccccc; border-style: solid;'>
	<tr><td valign='top' align='left'>
	By submitting results we can evaluate figures and compare one test to the other. No tests will ever get disclosed. If you <b>do not want</b> this information to be submitted, please do <b>not</B> press the submit button.
	</td></tr></table>
	<br>
	<FORM name="myform" METHOD="POST" ACTION="http://gather.webhosting.dk/cgi-bin/mywebtonet-performancestatsresults.pl" accept-charset="ISO-8859-1" target=_blank>
	<input type='hidden' name='md5time' value='<? echo $md5time ?>'>
	<input type='hidden' name='servername' value='<? echo $servername ?>'>
	<input type='hidden' name='serveraddr' value='<? echo $serveraddr ?>'>
	<input type='hidden' name='phpversion' value='<? echo $phpversion ?>'>
	<input type='hidden' name='phpos' value='<? echo $phpos ?>'>
	<input type='hidden' name='mathresult' value='<? echo $testmathresult ?>'>
	<input type='hidden' name='stringresult' value='<? echo $teststringresult ?>'>
	<input type='hidden' name='testloopresult' value='<? echo $testloopresult ?>'>
	<input type='hidden' name='ifelseresult' value='<? echo $testifelseresult ?>'>
	<input type='hidden' name='mysqlresults' value='<? echo $mysqltemp ?>'>
	<input type='hidden' name='phpmemorylimit' value='<? echo $memorylimit ?>'>
	<input type='hidden' name='postmaxsize' value='<? echo $postmaxsize ?>'>
	<input type='hidden' name='phpuname' value='<? echo $phpuname ?>'>
	<input type='hidden' name='loadnow' value='<? echo $load[0] ?>'>
	<input type='hidden' name='load5' value='<? echo $load[1] ?>'>
	<input type='hidden' name='load15' value='<? echo $load[2] ?>'>
	<input type='hidden' name='mysqlversion' value='<? echo $mysqlversion ?>'>
	<font face="Verdana,Arial" size="1"><INPUT TYPE=submit VALUE="Submit results">
	</form>
	<br><br><table cellpadding=0 cellspacing=0 style='background: #FFFFFF;border-radius:10px;-moz-border-radius:10px;-webkit-border-radius:10px;border: 2px solid #cccccc;'>
	<?
		$datamysql = array("MySQL 1" => $mysqlresults[0],"MySQL 2" => $mysqlresults[1],"MySQL 3" => $mysqlresults[2]);	
		$dataphp = array("Mathresult" => $testmathresult,"StringManipulation " => $teststringresult,"Loop" => $testloopresult,"IfElse" => $testifelseresult);	

	?>
		<td valign='top' align='left'>
			<table>
			<tr>
			<td><img src="<?php echo MYWEB_URL; ?>showgraphpie.php?showsmall=0&header=<?php echo urlencode(serialize("MySQL results")); ?>&mydata=<?php echo urlencode(serialize($datamysql)); ?>" /></td>
			<td><img src="<?php echo MYWEB_URL; ?>showgraphpie.php?showsmall=0&header=<?php echo urlencode(serialize("MySQL results")); ?>&mydata=<?php echo urlencode(serialize($dataphp)); ?>" /></td>
			<br>
			</tr>
			<tr>	
			<td><img src="<?php echo MYWEB_URL; ?>showgraph.php?showsmall=0&header=<?php echo urlencode(serialize("Lower is better, Your server=Blue, Ours=Green")); ?>&mywebdata=<?php echo urlencode(serialize($ourdatamysql55));?>&mydata=<?php echo urlencode(serialize($datamysql)); ?>" /></td>
			<td><img src="<?php echo MYWEB_URL; ?>showgraph.php?showsmall=0&header=<?php echo urlencode(serialize("Lower is better, Your server=Blue, Ours=Green")); ?>&mywebdata=<?php echo urlencode(serialize($ourdataphp55)); ?>&mydata=<?php echo urlencode(serialize($dataphp)); ?>" /></td>
			</tr>	
			</table>		
		</td>
	</table><br>		
	<?
	ShowFooter();
}

function ShowFooter() {
	echo "<a name='footer'>Some PHP 5.3, 5.4 and 5.5 examples below (<b>click on images below to view</b>):";
	?>
	<br><br>	
	<a href="<?php echo MYWEB_URL; ?>perftestphp53.png" target=_blank><img src="<?php echo MYWEB_URL; ?>perftestphp53.png" width=326 height=228 alt="PHP 5.3 test result" border=0></a>
	<a href="<?php echo MYWEB_URL; ?>perftestphp54.png" target=_blank><img src="<?php echo MYWEB_URL; ?>perftestphp54.png" width=326 height=228 alt="PHP 5.4 test result" border=0></a>
	<a href="<?php echo MYWEB_URL; ?>perftestphp55.png" target=_blank><img src="<?php echo MYWEB_URL; ?>perftestphp55.png" width=326 height=228 alt="PHP 5.5 test result" border=0></a>
	<br><br>
	</center>
	Plugin URL <a href='http://www.mywebtonet.com/files/wordpressplugins' target=_blank><b>http://www.mywebtonet.com/files/wordpressplugins</b></a>
	<br><br>
	Script made by <a href='http://www.mywebtonet.com' target=_blank><b>http://www.mywebtonet.com</b></a>&nbsp;&nbsp;<a href='http://www.webhosting.dk' target=_blank><b>http://www.webhosting.dk</b></a>
<?			

}

function DoHeader() {
	?>
	<body onLoad="init()">
	<div id="loading" style="position:absolute; width:100%; text-align:center; top:100px;">
	<br><br><br><img src="<?php echo MYWEB_URL.'pleasewait.gif'; ?>" alt="">
	<center><br><br><font face='Verdana,Arial'>Please wait while we perform some tests!
	</div><script>
	var ld=(document.all);
	var ns4=document.layers;
	var ns6=document.getElementById&&!document.all;
	var ie4=document.all;
         if (ns4)
         	ld=document.loading;
                  else if (ns6)
                  	ld=document.getElementById("loading").style;
                         else if (ie4)
                   ld=document.all.loading.style;
             function init()
                      {
                       if(ns4){ld.visibility="hidden";}
			else if (ns6||ie4) ld.display="none";
		}
	</script>
	</center>
	<?
	flush();
}

function DoPHPTests() {
	global $PHPtotaltime;
	global $testmathresult;
	global $teststringresult;
	global $testloopresult;
	global $testifelseresult;

        echo "<table width=70%>\n";
	echo "<tr><td valign='top'><B>PHP test:</b></td></tr>\n";
	$PHPtotaltime =0;
	$testmathresult = test_Math();
	$PHPtotaltime = $PHPtotaltime + $testmathresult;
	echo "<tr><td valign='top' width=20%>Time to perform: </td><td valign='top' width=60%><font color='blue'><b> Math test</b></font></td><td valign='top' width=20%> :".sprintf("%6.2f",$testmathresult)." seconds</td></tr>\n";	
	//
	$teststringresult = test_StringManipulation();
	$PHPtotaltime = $PHPtotaltime + $teststringresult;
	
	echo "<tr><td valign='top'>Time to perform: </td><td valign='top'><font color='blue'><b> StringManipulation test</b></font></td><td valign='top'> :".sprintf("%6.2f",$teststringresult)." seconds</td></tr>\n";	
	//
	$testloopresult = test_Loops();
	$PHPtotaltime = $PHPtotaltime + $testloopresult;
	echo "<tr><td valign='top'>Time to perform: </td><td valign='top'><font color='blue'><b> test Loop test</b></font></td><td valign='top'> :".sprintf("%6.2f",$testloopresult)." seconds</td></tr>\n";	
	//
	$testifelseresult =  test_IfElse();
	$PHPtotaltime = $PHPtotaltime + $testifelseresult;
	echo "<tr><td valign='top'>Time to perform: </td><td valign='top'><font color='blue'><b>  test IfElse</b></font></td><td valign='top'> :".sprintf("%6.2f",$testifelseresult)." seconds</td></tr>\n";	
	echo "<tr><td valign='top'>Total time</td><td valign='top'><b>(all PHP tests)</td><td valign='top'> :<font color='blue'><b>".sprintf("%6.2f",$PHPtotaltime)."</b></font> seconds</td></tr></table>\n";	

}

function DoMySQL() {
	global $wpdb;
	global $mysqltests;
	global $MySQLtotaltime;
	global $mysqltemp;
	global $mysqlresults;
	$tableprefix = $wpdb->prefix."mywebtonetperfstatsresults";



	$count = count($mysqltests);

	echo "<table width=70%>\n";
	echo "<tr><td valign='top'><b>MySQL test: </b></td></tr>\n";
	for ($i = 0; $i < $count; $i++) {
		$time_start = microtime(true);
		$dotest = $wpdb->query( "$mysqltests[$i]" );	
		$result = sprintf("%10.2f",number_format(microtime(true) - $time_start, 3));	
		$mysqlresults[]=$result;
		$MySQLtotaltime = $MySQLtotaltime + $result;
		echo "<tr><td valign='top' wdith=20%>Time to perform: </td><td valign='top' width=60%><font color='blue'><b>$mysqltests[$i]</b></font></td><td valign='top' width=20%> :".sprintf("%6.2f",$result)." seconds</td></tr>\n";	
		flush();
	}
	$count = count($mysqlresults);
	for ($i = 0; $i < $count; $i++) {
		$mysqltemp = $mysqltemp.",".$mysqlresults[$i];
	}	
	echo "<tr><td valign='top'>Total time</td><td valign='top'><b>(all MySQL tests)</b></td><td valign='top'> :<font color='blue'><b>".sprintf("%6.2f",$MySQLtotaltime)."</b></font> seconds</td></tr></table>\n";	

}

function test_Math($count = 50000) {
	$time_start = microtime(true);
	$mathFunctions = array("abs", "acos", "asin", "atan", "bindec", "floor", "exp", "sin", "tan", "pi", "is_finite", "is_nan", "sqrt");
	foreach ($mathFunctions as $key => $function) {
		if (!function_exists($function)) unset($mathFunctions[$key]);
	}
	for ($i=0; $i < $count; $i++) {
		foreach ($mathFunctions as $function) {
			$r = call_user_func_array($function, array($i));
		}
	}
	return sprintf("%10.2f",number_format(microtime(true) - $time_start, 3));
}
	
	
function test_StringManipulation($count = 100000) {
	$time_start = microtime(true);
	$stringFunctions = array("addslashes", "chunk_split", "metaphone", "strip_tags", "md5", "sha1", "strtoupper", "strtolower", "strrev", "strlen", "soundex", "ord");
	foreach ($stringFunctions as $key => $function) {
		if (!function_exists($function)) unset($stringFunctions[$key]);
	}
	$string = "the quick brown fox jumps over the lazy dog";
	for ($i=0; $i < $count; $i++) {
		foreach ($stringFunctions as $function) {
			$r = call_user_func_array($function, array($string));
		}
	}
	return sprintf("%10.2f",number_format(microtime(true) - $time_start, 3));
}


function test_Loops($count = 10000000) {
	$time_start = microtime(true);
	for($i = 0; $i < $count; ++$i);
	$i = 0; while($i < $count) ++$i;
	return sprintf("%10.2f",number_format(microtime(true) - $time_start, 3));
}

	
function test_IfElse($count = 10000000) {
	$time_start = microtime(true);
	for ($i=0; $i < $count; $i++) {
		if ($i == -1) {
		} elseif ($i == -2) {
		} else if ($i == -3) {
		}
	}
	return sprintf("%10.2f",number_format(microtime(true) - $time_start, 3));
}	
