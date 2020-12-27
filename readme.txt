=== ACF Repeater For Elementor ===
Contributors: Sympl
Tags: elementor, acf, repeater
Requires at least: 4.7
Tested up to: 5.6
Stable tag: 4.3
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

This plugin helps you repeat elementor elements/widgets/sections easy and simple as possible.
To use this plugin you will need elementor/elementor pro and ACF pro.


== Usage ==

First set the class of the widget you would like to repeat, could be column/inner section/single widget like so: "repeater_{name_of_the_repeater}".
{name_of_the_repeater} is need to be replaced with the name of the repeater that you set using ACF Pro.
Now anywhere inside that widget/element you can set the parameters you would like to inject, like so: #name
"name" should be replaced by you to any field you set for the repeater.
#name will be replaced when render the widget with the value of the row you set in the post.

== Important==
Currently this plugin support only text/urls/accordion&toggle tabs.
Tested on elementor native elements only.