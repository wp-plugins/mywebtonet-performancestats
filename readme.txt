=== Plugin Name ===
Contributors: mywebtonet
Plugin URI: http://www.mywebtonet.com/files/wordpressplugins
Tags: benchmark, php, mysql, performance, testing, speed, dynotest, query tester
Requires at least: 3.2.0
Tested up to: 3.7.1
Stable tag: 1.0.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

With this plugin you can "dyno tests" the CPU performance of your PHP webserver and MySQL database backend server.

== Description ==

You can easily determine the CPU performance allocated for your PHP web and MySQL
backend servers with this plugin. The plugin does various calculations and string
manipulations on your PHP webserver + some simple CPU tests on your MySQL backend 
server. Furthermore a sequence of MySQL inserts,selects,updates and deletes are 
performed in a seperate table (we do not use your WordPress tables for this). After 
the test has run, the result will be displayed for you to evaluate. Typical
results for this test is 0.05-0.25 seconds if a MySQL socket connection is used. We
use dedicated servers in our own setup and that requires a network connection, which is
a bit slower, therefore the data provided for our servers are a bit slower. 

Generally speaking, the  faster this plugin runs, the faster your 
website will run.

There are many factors that will determine how fast your website will run. This 
plugin does not test e.g. for how many hits a second your provider allows to your 
web, filesystem performance is not tested either. Use it as a performance 
test on how fast a CPU your provider has allocated to your webserver and your MySQL
database backend. 

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


