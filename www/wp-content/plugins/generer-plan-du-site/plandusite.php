<?php
/**
 * @package Générer plan du site
 * @version 1.0
 */
/*
Plugin Name: Générer le plan du site
Description: Permet de générer automatiquement le plan du site en utilisant le shortcode [plan_du_site] sur une page
Author: Tony Archambeau
Version: 1.0
Author URI: http://tonyarchambeau.com/
*/


// [plan_du_site]
function plan_du_site_func( $atts, $content=null ) {
	$return = '';
	
	// List the pages
	$return .= '<h2>'.__('Pages').'</h2>';
	$return .= '<ul>';
	$return .= wp_list_pages('title_li=&echo=0');
	$return .= '</ul>';
	
	
	// List the posts by category
	$return .= '<h2>'.__('Articles par catégories').'</h2>';
	
	// Get the categories
	$cats = get_categories();
	
	// Generate a multidimensional array from a simple linear array using a recursive function
	function generateMultiArray($arr, $parent = 0)
	{
		$pages = Array();
		foreach($arr as $k => $page) {
			if($page->parent == $parent) {
				$page->sub = isset($page->sub) ? $page->sub : generateMultiArray($arr, $page->cat_ID);
				$pages[] = $page;
			}
		}
		return $pages;
	}
	$cats = generateMultiArray($cats);
	
	
	// display the multidimensional array using a recursive function
	function displayPostByCat($cat_id)
	{
		$html = '';
		
		// List of posts for this category
		$the_posts = get_posts('numberposts=999&cat='.$cat_id);
		foreach ($the_posts as $the_post) {
			// Display the line of a post
			$get_category = get_the_category($the_post->ID);
			
			// Display the post only if it is on the deepest category
			if ($get_category[0]->cat_ID == $cat_id) {
				// Get the date of the post
				$date_fragments = explode('-', substr_replace($the_post->post_date, '', 10));
				$the_date = $date_fragments[2].'/'.$date_fragments[1].'/'.$date_fragments[0];
				
				$html .= "\t\t".'<li><a href="'.get_permalink($the_post->ID).'">'.$the_post->post_title.'</a> ('.$the_date.')</li>'."\n";
			}
		}
		
		return $html;
	}
	
	// display the multidimensional array using a recursive function
	function htmlFromMultiArray($nav, $useUL = true)
	{
		$html = '';
		if ($useUL) {
			$html .= '<ul>'."\n";
		}
		
		foreach($nav as $page) {
			$html .= "\t".'<li><strong>'.__('Catégorie').' : <a href="'.get_category_link($page->cat_ID).'">'.$page->name.'</a></strong>'."\n";
			
			$post_by_cat = displayPostByCat($page->cat_ID);
			
			// List of posts for this category
			$category_recursive = '';
			if (!empty($page->sub)) {
				// Use recursive function to get the childs categories
				$category_recursive = htmlFromMultiArray($page->sub, false);
			}
			
			// display if it exist
			if ($post_by_cat != '' || $category_recursive!= '') {
				$html .= '<ul>';
			}
			if ($post_by_cat != '') {
				$html .= $post_by_cat;
			}
			if ($category_recursive != '') {
				$html .= $category_recursive;
			}
			if ($post_by_cat != '' || $category_recursive!= '') {
				$html .= '</ul>';
			}
			
			
			$html .= '</li>'."\n";
		}
		
		if ($useUL) {
			$html .= '</ul>'."\n";
		}
		return $html;
	}
	$return .= htmlFromMultiArray($cats);
	
	return $return;
}
add_shortcode( 'plan_du_site', 'plan_du_site_func' );
