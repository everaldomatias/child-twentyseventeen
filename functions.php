<?php
/*
* Functions by child theme from twentyseventeen
*/

/*
 * Includes
 */

/*
 * Custom Post Types and Custom Taxonomies
 */
require_once( get_stylesheet_directory() . '/inc/cpt.php' );


/*
* Add GoogleAnalytics if exist file inc/ga.php
*/
add_action( 'wp_head', 'child_add_googleanalytics' );
function child_add_googleanalytics() {
	$file = get_stylesheet_directory() . '/inc/ga.php';
	if ( file_exists( $file ) ) {
		require_once( $file );
	}
}


/*
* Enqueue scripts
*/
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_styles' );
function child_theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/assets/css/child-style.css', 'parent-style', false );
}


/*
* Remove WordPress version
*/
function child_remove_version() {
	return '';
}
add_filter( 'the_generator', 'child_remove_version' );
remove_action('wp_head', 'wp_generator' );


/*
* Remove erros by login
*/
function child_remove_errors_login(){
	return 'Algo errado... tente novamente!';
}
add_filter( 'login_errors', 'child_remove_errors_login' );


/*
* Change default image link to None
*/
function child_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	
	if ( $image_set !== 'none' ) {
		update_option( 'image_default_link_type', 'none' );
	}
}
add_action( 'admin_init', 'child_imagelink_setup', 10 );


/*
* Add author box in posts
*/
function wpb_author_info_box( $content ) {

	global $post;

	// Detect if it is a single post with a post author
	if ( is_single() && isset( $post->post_author ) ) {

		// Get author's display name 
		$display_name = get_the_author_meta( 'display_name', $post->post_author );

		// If display name is not available then use nickname as display name
		if ( empty( $display_name ) )
		$display_name = get_the_author_meta( 'nickname', $post->post_author );

		// Get author's biographical information or description
		$user_description = get_the_author_meta( 'user_description', $post->post_author );

		// Get author's website URL 
		$user_website = get_the_author_meta('url', $post->post_author);

		// Get link to the author archive page
		$user_posts = get_author_posts_url( get_the_author_meta( 'ID' , $post->post_author));
		 
		if ( ! empty( $display_name ) )

		$author_details = '<p class="author_name">Sobre ' . $display_name . '</p>';

		if ( ! empty( $user_description ) )
		// Author avatar and bio
		$author_details .= '<p class="author_details">' . get_avatar( get_the_author_meta('user_email') , 90 ) . nl2br( $user_description ). '</p>';
		$author_details .= '<p class="author_links"><a href="'. $user_posts .'">Veja todos os posts de ' . $display_name . '</a>';  

		// Check if author has a website in their profile
		if ( ! empty( $user_website ) ) {

			// Display author website link
			$author_details .= ' | <a href="' . $user_website .'" target="_blank" rel="nofollow">Site</a></p>';

		} else { 
			// if there is no author website then just close the paragraph
			$author_details .= '</p>';
		}

		// Pass all this info to post content  
		$content = $content . '<footer class="author_bio_section" >' . $author_details . '</footer>';
	}
	return $content;
}

// Add our function to the post content filter 
add_action( 'the_content', 'wpb_author_info_box' );

// Allow HTML in author bio section 
remove_filter( 'pre_user_description', 'wp_filter_kses' );