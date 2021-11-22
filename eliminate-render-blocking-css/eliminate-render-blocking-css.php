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

*/

function simple_defer_stylesheets($html, $handle, $href, $media){
	
	if(empty($media)){
		$media = 'all';/* No "media" value == 'all' (undefined edition) */
	}
	
	if(!is_string($media)){/* If it's not a string, somebody somewhere is doing something ridiculous, which we don't want to dignify */
		return $html;
	}
	
	if($media === ''){
		$media = 'all';/* No "media" value == 'all' */
	}
	
	if($media !== 'print'){/* No need to optimise print styles (tempting to discard print styles to help the environment but let's not) */
		$match = " media='" . $media . "'";/* match the whole attribute declaration */
		$replace = ' media=\'print\' onload=\'this.media="' . $media . '"\'';/* build a new media attribute declaration */
		$html = str_replace($match, $replace, $html);/* swap old with new */
		$html .= '<noscript><link rel="stylesheet" href="' . $href . '" media="' . $media . '" /></noscript>';/* append a noscript version so we don't break for clients without JS */
	}

	return $html;

}

add_filter("style_loader_tag", "simple_defer_stylesheets", 9999, 4);

?>
