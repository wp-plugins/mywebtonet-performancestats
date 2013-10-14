=== Plugin Name ===
Contributors: mywebtonet
Plugin URI: http://www.mywebtonet.com/files/wordpressplugins
Tags: php, mysql, performance, testing, speed, dyno test
Requires at least: 3.2.0
Tested up to: 3.6.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin is a simple plugin that "dyno tests" the CPU performance of your PHP web and MySQL database backend.

== Description ==

This plugin is like "dyno testing" your PHP front and MYSQL backend performance.

You can easily determine the CPU performance allocated for your PHP web and MySQL
server with this plugin. This script does some simple calculations, string
manipulations and some simple CPU tests on your MySQL backend and displays them for you 
to evaluate.

There are many factors for a fast server, this plugin does not test e.g. for
how many hits a second your provider allows to your web, filesystem
performance is not tested either. Use it as a simple CPU test and compare with
your friends statistics from their provider. 

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `mywebtonet-performancestats` folder after extracting the zip file, upload  to the `/wp-content/plugins/` directory or simply upload the zip file from the admin panel.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Click Performance test in the menu!

== Changelog ==

= 1.0 =
* This is the first stable release of this plugin

= 1.0.1 =
* Minor correction in the submit results section.

== Upgrade Notice ==

= 1.0.1 =

Minor correction in the code in the submit results section. Now the load average is submitted as well.

