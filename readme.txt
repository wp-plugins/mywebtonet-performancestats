=== Plugin Name ===
Contributors: mywebtonet
Plugin URI: http://www.mywebtonet.com/files/wordpressplugins
Tags: benchmark, php, mysql, performance, testing, speed, dynotest, query tester
Requires at least: 3.2.0
Tested up to: 3.9.1
Stable tag: 1.1.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

With the performance test plugin you can test the CPU and MySQL speed on your webserver and your MySQL server. 

== Description ==

CPU performance testing:
This plugin does various calculations and string manipulations on your PHP webserver 
and your MySQL database server. To further test the MySQL server, a sequence of MySQL 
inserts, selects, updates and deletes are performed in a separate custom database table 
(we do not use your WordPress tables for this). 

Network testing:
The network is tested by fetching directly from Google's CDN / apis network. Fetching from the Google 
apis network gives you the nearest server, and will give more accurate results. We also fetch a small 1Mb 
file from our servers as well in case the Google apis is down. The network tests are not yet shown in the 
graphs, we are working on this :-)
 
Results:
After the sequence of tests has finished, the results will be displayed for you to evaluate. MySQL results can
vary depending on the type of connection your webserver has to the MySQL server. If a "local socket" connection
is used a typical result for the MySQL query test is 0.05-0.25 seconds. Web hosting providers with dedicated MySQL 
servers will show a slower time/queries per second, as a TCP/IP connection to the MySQL server is made instead of 
a local socket connection. 

There are many factors that will determine how fast your website will run. This plugin does not test 
for how many hits a second your provider allows to your website, file system performance is not tested 
either. Use it as a performance test to assess how fast a CPU your provider has allocated to your webserver 
and your MySQL database backend. 

Share with your friends, let's start a competition and see who is the fastests :-)

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `mywebtonet-performancestats` folder after extracting the zip file, upload  to the `/wp-content/plugins/` directory or simply upload the zip file from the admin panel.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Click Performance test in the menu!

== Changelog ==

= 1.0 =
* This is the first stable release of this plugin.

= 1.0.1 =
* Minor correction in the submit results section.

= 1.0.3 =
* Now with graphs :-) Thanks to http://www.ebrueggeman.com

= 1.0.4 =
Now with even more graphs :-) Now your fastest and slowest times are logged in the database.

= 1.0.5 =
Minor code changes.

= 1.0.6 =
Query test added.

= 1.0.7 =
Minor changes. Tested on WordPress 3.8.

= 1.0.8 =
Now with network testing tool

= 1.0.9 =
More PHP information + webserver type/version

= 1.1.0 =
Minor update

= 1.1.1 =
Only calling apache_get_version() if function exists

= 1.1.2 =
Some servers reports one or more of the MySQL tests at 0.00 seconds, which
is impossible. This now triggers an error.

= 1.1.3 =
Added path and gateway interface

= 1.1.4 =
Added missing ?> in main script, for some reason it doesnt work with all php versions without it.

= 1.1.5 =
Minor code changes + split the network test into two seperate tests

= 1.1.6 =
We have done some minor code changes as some webservers require <?php instead of just <?


== Upgrade Notice ==

= 1.0.1 =
Minor correction in the code in the submit results section. Now the load average is submitted as well.

= 1.0.2 =
Minor layout changes, max post size information now included.

= 1.0.3 =
Now with graphs :-) Thanks to http://www.ebrueggeman.com

= 1.0.4 =
Now with even more graphs :-) Now your fastest and slowest times are logged in the database.

= 1.0.5 =
Minor code changes.

= 1.0.6 =
Query test added.

= 1.0.7 =
Minor changes. Tested on WordPress 3.8.

= 1.0.8 =
Now with network testing tool

= 1.0.9 =
More PHP information + webserver type/version

= 1.1.0 =
Minor update

= 1.1.1 =
Only calling apache_get_version() if function exists

= 1.1.2 =
Some servers reports one or more of the MySQL tests at 0.00 seconds, which
is impossible. This now triggers an error.

= 1.1.3 =
Added path and gateway interface

= 1.1.4 =
Added missing ?> in main script, for some reason it doesnt work with all php versions without it.

= 1.1.5 =
Minor code changes + split the network test into two seperate tests

= 1.1.6 =
We have done some minor code changes as some webservers require <?php instead of just <?
