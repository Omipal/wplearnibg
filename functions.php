<?php
/**
 * Theme Function File
 */

 function html2wp_theme_setup(){

    add_theme_support('custom-logo');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    
    add_image_size('home-featured', 640, 400, array('center', 'center'));
    add_image_size('single-post', 580, 272, array('center', 'center'));
    
    add_theme_support('automatic-feed-links');
    
    register_nav_menus( array(
        'primary'   => __( 'Primary Menu', 'html2wp' )
     
    ) );
    
     };
    add_action('after_setup_theme', 'html2wp_theme_setup');


function html2wp_scripts(){
wp_enqueue_style('style', get_stylesheet_uri());
wp_enqueue_style('bootstrap-css', get_template_directory_uri().'/assets/css/main.css');




wp_enqueue_script('jquery-js', get_template_directory_uri().'/assets/js/jquery.min.js', array(), 1.1, true );
wp_enqueue_script('breakpoints-js', get_template_directory_uri().'/assets/js/breakpoints.min.js', array(), 1.1, true );
wp_enqueue_script('util-js', get_template_directory_uri().'/assets/js/util.js', array(), 1.1, true );
wp_enqueue_script('main-js', get_template_directory_uri().'/assets/js/main.js', array(), 1.1, true );

 }
 add_action('wp_enqueue_scripts', 'html2wp_scripts');


 function html2wp_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'html2wp' ),
		'id'            => 'main-sidebar',
        'description'   => 'Main Sidebar on Right Side',
		'before_widget' => '<section id="%1$s" class="box %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<header><h3 class="widget-title">',
		'after_title'   => '</h3></header>',
	) );
    register_sidebar( array(
		'name'          => __( 'Home Banner', 'html2wp' ),
		'id'            => 'home-banner',
        'description'   => 'Banner Area on Home Page',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

    register_sidebar( array(
		'name'          => __( 'Home Services', 'html2wp' ),
		'id'            => 'home-services',
        'description'   => 'Services Area on Home Page',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

    register_sidebar( array(
		'name'          => __( 'Footer Widget 1', 'html2wp' ),
		'id'            => 'footer-1',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<header><h2 class="widget-title">',
		'after_title'   => '</h2></header>',
	) );
    register_sidebar( array(
		'name'          => __( 'Footer Widget 2', 'html2wp' ),
		'id'            => 'footer-2',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<header><h2 class="widget-title">',
		'after_title'   => '</h2></header>',
	) );
    register_sidebar( array(
		'name'          => __( 'Footer Widget 3', 'html2wp' ),
		'id'            => 'footer-3',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<header><h2 class="widget-title">',
		'after_title'   => '</h2></header>',
	) );

}
add_action( 'widgets_init', 'html2wp_widgets_init' );

// Add Custom Post Type

require get_template_directory() .'/inc/portfolio.php';

function filter_post(){
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => -1,
		'order_by' => 'menu_order',
		'order' => 'desc'

	);
	if(isset($_POST['category'])){
		$args['cat'] = $_POST['category'];
	}
	
	$ajaxPosts = new WP_Query($args);

	if($ajaxPosts->have_posts()):
		while($ajaxPosts->have_posts()): $ajaxPosts->the_post(); 
		?>
	<div class="col-4 col-6-medium col-12-small">
		<section class="box">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('single-post'); ?></a>
		<header>
			<h3><?php the_title(); ?></h3>
		</header>
		<span class="posts-cats">
			<?php the_terms(get_the_ID(), 'category', 'Categories: ', '/'); ?>
		</span>
		<?php the_content(); ?>				
		</section>
	</div>
		<?php
		endwhile;
		wp_reset_postdata();
	else:
		echo "No Post Found";
	endif;
	wp_die();
	
}

add_action('wp_ajax_myfilter', 'filter_post');
add_action('wp_ajax_nopriv_myfilter', 'filter_post');