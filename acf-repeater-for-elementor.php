<?php
/**
 * @package ACF Repeater for Elementor
 * @version 1.4
 */
/*
Plugin Name: ACF Repeater for Elementor
Plugin URI: http://wordpress.org/plugins/acf-repeater-for-elementor/
Description: Easy and simple way to use acf pro repeater in elementor.
Author: Sympl
Version: 1.4
Author URI: https://sympl.co.il/
*/


add_action( 'elementor/frontend/section/before_render', function( $section ) {
    // Catch output
    ob_start();
} );
// And then
add_action( 'elementor/frontend/section/after_render', function( $section ) {
    // Collect output
    $content = ob_get_clean();

    // Alter the output anyway you want, in your case wrapping 
    // it with a classed div should be something like this
    // make sure to echo it
    	if($repeater_name = arfe_check_if_repeater_class_in_widget($section, 'css_classes')) {
			echo arfe_prepare_content_by_repeater($content, $repeater_name);
	} else {
			echo $content;
		}
} );


//handle accordion and toggle for repeater
add_action( 'elementor/frontend/widget/before_render', function( $widget ) {

	if($widget->get_name()=="toggle" || $widget->get_name()=="accordion") {
		if($repeater_name = arfe_check_if_repeater_class_in_widget($widget) ){
			$repeater = get_field($repeater_name);
			if($repeater && count($repeater)>0) {
			$create_tabs = array();
			$template_tab = $widget->get_settings('tabs');
			if(count($template_tab) == 0) {
				return;
			}
			$template_tab = $template_tab[0];
			unset($template_tab['_id']);
			foreach($repeater as $row) {
				$json_tab = json_encode($template_tab);
				foreach($row as $key => $value ) {
					$json_tab = str_replace("#".$key, $value, $json_tab);
				}
				array_push($create_tabs, json_decode($json_tab, true));
			}
			$widget->set_settings('tabs', $create_tabs);
			} else {//no items in repeater.. delete all tabs
				$widget->set_settings('tabs', array());
			}
		}
	}
	
}, 10 , 1);

add_action( 'elementor/widget/render_content', function( $content, $widget ) {
	if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || $widget->get_name()=="toggle" || $widget->get_name()=="accordion") {
		    return $content;
	}
		$repeater_name = arfe_check_if_repeater_class_in_widget($widget);
	if ($repeater_name) {
		return arfe_prepare_content_by_repeater($content, $repeater_name);
	}
   
   return $content;
}, 10, 2 );


function arfe_prepare_content_by_repeater($content, $repeater_name) {
		$repeater = get_field($repeater_name);
		if(!$repeater || count($repeater) == 0) {
			return "";
		}
		
		$new_view = '';
		foreach($repeater as $row) {
			$single_content = $content;
			foreach($row as $key => $value ) {
				$single_content = str_replace("#".$key, $value, $single_content);
			}
			$new_view = $new_view.''.$single_content;
		}
		return $new_view;
}


function arfe_check_if_repeater_class_in_widget($widget,$classes_key = '_css_classes') {
	$classes = $widget->get_settings()[$classes_key];
	$classes = explode("repeater_", $classes);
	if (count($classes)>1) {
		$repeater_name = explode(" ", $classes[1])[0];
		return $repeater_name;
	}
	return false;
}
