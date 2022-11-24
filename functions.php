<?php

// config

if (! defined('WP_DEBUG')) {
	die( 'Direct access forbidden.' );
}
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
});
add_action( 'wp_enqueue_scripts', function () {
	// wp_enqueue_style( 'child-theme', get_stylesheet_directory_uri() . '/style.css' );
  wp_enqueue_script( 'child-theme', get_stylesheet_directory_uri() . '/custom.js' );
});



function wpdocs_theme_name_scripts() {
  // wp_enqueue_script( 'script-slick-c', 'http://code.jquery.com/jquery-1.11.2.min.js', array(), '1.0.0');
 wp_enqueue_style( 'style-slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
  //   wp_enqueue_style( 'style-slick-a', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css');
    

  

  //wp_enqueue_script( 'script-slick-e', 'https://kit.fontawesome.com/6a8e5d8c6e.js', array(), '1.0.0', true );
    
  //   wp_enqueue_script( 'script-slick-f', get_stylesheet_directory_uri() . '/custom.js', array(), '1.0.0', true );

}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );

// Our custom post type function
function create_posttypes() {
  
  register_post_type( 'accessories',
  // CPT Options
      array(
          'labels' => array(
              'name' => __( 'Accessories' ),
              'singular_name' => __( 'Accessories' )
          ),
          'public' => true,
          'has_archive' => true,
          'rewrite' => array('slug' => 'accessories'),
          'show_in_rest' => true,

      )
  );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttypes' );

function accessories() {
  $args = array(  
          'post_type' => 'Accessories',
          'public' => true,
          'has_archive' => true,
          'post_status' => 'publish',
          'posts_per_page' => -1, 
      );
      $loop = new WP_Query( $args ); 
  
      $html  = ob_start();
  ?>
  <div class="accessorismainSEction content">
  <div class="accessoris slider">
    <?php while ( $loop->have_posts() ) : $loop->the_post();  $people = get_the_ID();?>
        <?php 
        $image = get_field('image', $people);
        $title = get_field('title', $people);
        $description = get_field('description', $people);
        $learnmorebutton = get_field('learn_more_button', $people);
        $learnmoreurl = get_field('learn_more_url', $people);
        $close = get_field('close', $people);
        ?>
     
        <div class="acc">
            <div class="accessorisMain image">
                  <div class="accessorisIteam">
                    <img src="<?php echo $image; ?>" />
                    <div class="accessorisIteamTitle"><?php echo $title ?></div>
                    <a href="javascript:void(0);" class="learnmore"><?php echo $learnmorebutton ?></a>
                  </div>
                  <div class="accessorisIteamHover">
                    <div class="accessorisIteamTitle"><?php echo $title ?></div>
                    <div class="accessorisIteamDescription"><?php echo $description ?></div>
                    <a href="javascript:void(0);" class="close"><?php echo $close ?></a>
                  </div>
            </div>
        </div>

      
    <?php endwhile;  wp_reset_postdata();  ?>
  </div> 
  <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
            <span class="slider__label sr-only">
            </div>
            </span> 
  </div>

<?php
  $html = ob_get_clean();
  return $html;
}
add_shortcode('accessories', 'accessories' );

// Below codes for custom tabs 

add_action('acf/init', 'my_acf_init');
function my_acf_init() {
    
    // check function exists
    if( function_exists('acf_register_block') ) {
        
        // register a tabs block
        acf_register_block(array(
            'name'              => 'Tabs',
            'title'             => 'Tabs',
            'description'       => 'A custom tabs block.',
            'render_callback'   => 'my_acf_block_render_callback',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'tabs', 'quote' ),
        ));
    }
}

function my_acf_block_render_callback( $block ) {
    
  // convert name ("acf/tabs") into path friendly slug ("tabs")
  // $slug = str_replace('acf/', '', $block['tabs']);
  
  // include a template part from within the "template-parts/block" folder
  if( file_exists( get_theme_file_path("/blocks/tabs/content-tabs.php") ) ) {
      include( get_theme_file_path("/blocks/tabs/content-tabs.php") );
  }




  

  // $test = "https://oona.aavamobile.com/wp-content/themes/oona-child/blocks/tabs/content-tabs.php";
  // echo $test;
  
  // include('https://oona.aavamobile.com/wp-content/themes/oona-child/blocks/tabs/test.html');
}