<?php
/*
* Custom Post Types and Taxonomies
*/

/* Glossary */
function child_cpt_glossary() {
  	register_post_type( 'glossary',
	    array(
	    	'labels' => array(
	        	'name' 			=> __( 'Glossary', 'child' ),
	        	'singular_name'	=> __( 'Glossary', 'child' )
	      	),
	      	'menu_icon' 	=> 'dashicons-welcome-learn-more',
	      	'supports'		=> array( 'author', 'title', 'editor', 'thumbnail' ),
	    	'public' 		=> true,
	    	'has_archive'	=> true,
	    )
	);
}
add_action( 'init', 'child_cpt_glossary' );