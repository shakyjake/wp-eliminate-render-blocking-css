<?php

/*

Plugin Name: Eliminate Render Blocking CSS
Description: A simple plugin to eliminate render-blocking CSS in Wordpress.
Version: 1.0.0
Author: Jake Nicholson
Author URI: https://github.com/shakyjake/
Plugin URI: https://github.com/shakyjake/wp-eliminate-render-blocking-css/
Requires at least: 4.5.0
License: MIT
Text Domain: erbc

*/

function simple_defer_stylesheets($html, $handle, $href, $media){
	
	if(empty($media)){
		$media = '';
	}
	
	if($media === ''){
		$media = 'all';
	}
	
	if($media !== 'print'){
		$media = preg_quote($media, "/");
		$match = "/ media='" . $media . "'/";
		$replace = ' media=\'print\' onload=\'this.media="' . $media . '"\'';
		$html = preg_replace($match, $replace, $html);
	}

	return $html;

}

add_filter("style_loader_tag", "simple_defer_stylesheets", 9999, 4);

?>
