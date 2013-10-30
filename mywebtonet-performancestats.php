<?php
/**
 * @package mywebtonet performance statistics
 * @version 1.0.3
 */
/*
Plugin Name: PHP/MySQL CPU performance statistics
Plugin URI: http://www.mywebtonet.com/files/wordpressplugins
Description: A simple plugin that tests CPU performance on your web and MySQL server.
Author: WebHosting A/S - MyWebToNet Ltd.
Version: 1.0.3
Author URI: http://www.mywebtonet.com 
*/

if ( !defined('ABSPATH') ) {
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
                     
function mywebtonetperftest_plugin_menu() {
	add_menu_page('mywebtonetperftest', 'Performance Test', 'manage_options', 'mywebtonetperftest', 'mywebtonetperftest_plugin_all');
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
	// General information about server etc etc, we always show these		
	//
	echo "<br>\n";
	echo "<center>Compare with results below, <a href='#footer'><b>click to view</b></a></center>\n";
        echo "<table>\n";
        echo "<tr><td>Server : $servername@<font color='blue'><b>".$serveraddr."</b></font></td></tr>\n";
        echo "<tr><td>PHP host information : <font color='blue'><b>".$phpuname."</b></font></td></tr>\n";   
        echo "<tr><td>PHP version : <font color='blue'><b>".$phpversion."</B></font></td></tr>\n";
	echo "<tr><td>PHP memory limit / Post max size: <font color='blue'><b>".$memorylimit." / ".$postmaxsize."</b></font></td></tr>\n";
        echo "<tr><td>Platform : <font color='blue'><b>".$phpos."</b></font></td></tr>\n";
        echo "<tr><td>MySQL version : <font color='blue'><b>".$mysqlversion."</font></b></td></tr>";
        echo "</table>\n";
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		echo "<tr><td>Server load now:</td><td align='right'><b>Unable to fetch load as windows is used for webserver (incompatible)</b></td></tr>\n";
	} else {
		$load= sys_getloadavg();
	        echo "<table width=250>\n";
		echo "<tr><td>Server load now:</td><td align='left'><font color='blue'><b>".sprintf("%6.2f",$load[0])."</b></td></tr>\n";
		echo "<tr><td>Server load avg. 5 minutes:</td><td align='left'><font color='blue'><b>".sprintf("%6.2f",$load[1])."</b></td></tr>\n";
		echo "<tr><td>Server load avg. 15 minutes:</td><td align='left'><font color='blue'><b>".sprintf("%6.2f",$load[2])."</b></td></tr>\n";	
	        echo "</table>\n";
	}	

        doHeader();
        doMySQL();
        doPHPTests();
        //
	// Finish
	// 
	echo "<table width=70%>\n";
	echo "<tr><td><b>All tests:</b></td></tr>\n";
	echo "<tr><td width=20%>Total time</td><td width=60%><b>(all MySQL + PHP tests)</td><td width=20%> :<font color='blue'><b>".sprintf("%6.2f",$PHPtotaltime+$MySQLtotaltime)."</b></font> seconds</td></tr></table>\n";	
	$md5time = md5(time().$servername);
	?>
	<center>
	<br>
	<table width='90%' border=0 bgcolor='fcfcfc' cellpadding=0 cellspacing=6 style='border-width: 1px; border-color:#cccccc; border-style: solid;'>
	<tr><td align='left'>
	By submitting results we can evaluate figures and compare one test to the other. No tests will ever get disclosed. If you <b>do not want</b> this information to be submitted, please do <b>not</B> press the submit button.
	</td></tr></table>
	<br><br>
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
	<font face="Verdana,Arial" size="2">	
	<table>
		<tr>
			<td>
			<?
			$data = array("Mysql 1" => $mysqlresults[0],"Mysql 2" => $mysqlresults[1],"Mysql 3" => $mysqlresults[2]);	
			?>
			<img src="<?php echo MYWEB_URL; ?>showgraph.php?header=<?php echo urlencode(serialize("MySQL results")); ?>&mydata=<?php echo urlencode(serialize($data)); ?>" />
			</td>
			<td>
			<?
			$data = array("Mathresult" => $testmathresult,"StringManipulation " => $teststringresult,"Loop" => $testloopresult,"IfElse" => $testifelseresult);	
			?>
			<img src="<?php echo MYWEB_URL; ?>showgraph.php?header=<?php echo urlencode(serialize("PHP results")); ?>&mydata=<?php echo urlencode(serialize($data)); ?>" />
			</td>
		</tr>
	</table>		
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
	echo "<tr><td><B>PHP test:</b></td></tr>\n";
	$PHPtotaltime =0;
	$testmathresult = test_Math();
	$PHPtotaltime = $PHPtotaltime + $testmathresult;
	echo "<tr><td width=20%>Time to perform: </td><td width=60%><font color='blue'><b> Math test</b></font></td><td width=20%> :".sprintf("%6.2f",$testmathresult)." seconds</td></tr>\n";	
	//
	$teststringresult = test_StringManipulation();
	$PHPtotaltime = $PHPtotaltime + $teststringresult;
	
	echo "<tr><td>Time to perform: </td><td><font color='blue'><b> StringManipulation test</b></font></td><td> :".sprintf("%6.2f",$teststringresult)." seconds</td></tr>\n";	
	//
	$testloopresult = test_Loops();
	$PHPtotaltime = $PHPtotaltime + $testloopresult;
	echo "<tr><td>Time to perform: </td><td><font color='blue'><b> test Loop test</b></font></td><td> :".sprintf("%6.2f",$testloopresult)." seconds</td></tr>\n";	
	//
	$testifelseresult =  test_IfElse();
	$PHPtotaltime = $PHPtotaltime + $testifelseresult;
	echo "<tr><td>Time to perform: </td><td><font color='blue'><b>  test IfElse</b></font></td><td> :".sprintf("%6.2f",$testifelseresult)." seconds</td></tr>\n";	
	echo "<tr><td>Total time</td><td><b>(all PHP tests)</td><td> :<font color='blue'><b>".sprintf("%6.2f",$PHPtotaltime)."</b></font> seconds</td></tr></table>\n";	

}

function DoMySQL() {
	global $wpdb;
	global $mysqltests;
	global $MySQLtotaltime;
	global $mysqltemp;
	global $mysqlresults;
	$count = count($mysqltests);
	echo "<table width=70%>\n";
	echo "<tr><td><b>MySQL test: </b></td></tr>\n";
	for ($i = 0; $i < $count; $i++) {
		$time_start = microtime(true);
		$dotest = $wpdb->query( "$mysqltests[$i]" );	
		$result = number_format(microtime(true) - $time_start, 3);	
		$mysqlresults[]=$result;
		$MySQLtotaltime = $MySQLtotaltime + $result;
		echo "<tr><td wdith=20%>Time to perform: </td><td width=60%><font color='blue'><b>$mysqltests[$i]</b></font></td><td width=20%> :".sprintf("%6.2f",$result)." seconds</td></tr>\n";	
		flush();
	}
	$count = count($mysqlresults);
	for ($i = 0; $i < $count; $i++) {
		$mysqltemp = $mysqltemp.",".$mysqlresults[$i];
	}	
	echo "<tr><td>Total time</td><td><b>(all MySQL tests)</b></td><td> :<font color='blue'><b>".sprintf("%6.2f",$MySQLtotaltime)."</b></font> seconds</td></tr></table>\n";	

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
	return number_format(microtime(true) - $time_start, 3);
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
	return number_format(microtime(true) - $time_start, 3);
}


function test_Loops($count = 10000000) {
	$time_start = microtime(true);
	for($i = 0; $i < $count; ++$i);
	$i = 0; while($i < $count) ++$i;
	return number_format(microtime(true) - $time_start, 3);
}

	
function test_IfElse($count = 10000000) {
	$time_start = microtime(true);
	for ($i=0; $i < $count; $i++) {
		if ($i == -1) {
		} elseif ($i == -2) {
		} else if ($i == -3) {
		}
	}
	return number_format(microtime(true) - $time_start, 3);
}	
