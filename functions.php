<?php
/**
 * rttheme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package rttheme
 */

if ( ! function_exists( 'rttheme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function rttheme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on rttheme, use a find and replace
		 * to change 'rttheme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'rttheme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary Menu', 'rttheme' ),
			'menu-2' => esc_html__( 'Footer Menu', 'rttheme' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'rttheme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'rttheme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rttheme_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'rttheme_content_width', 640 );
}
add_action( 'after_setup_theme', 'rttheme_content_width', 0 );


function rttheme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'rttheme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'rttheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'rttheme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function rttheme_scripts() {
	wp_enqueue_style( 'rttheme-style', get_stylesheet_uri() );


	wp_enqueue_style('rtheme-bootsrap',get_template_directory_uri() .'/css/bootstrap.min.css');

	wp_enqueue_script( 'rttheme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

    wp_enqueue_script( 'rttheme-bootstrap-js',get_template_directory_uri() ."/js/bootstrap.min.js",array('jquery'),'',true);

	if(is_home() or is_front_page()) {   
   
    	wp_enqueue_script( 'rttheme-script-js', get_template_directory_uri() . '/js/script.js', array('jquery'), '', true );

    }
    wp_enqueue_script( 'rttheme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	    

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rttheme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

add_theme_support('menus');

require get_template_directory() . '/template-parts/custom-posts/slider.php';

function gutenberg_boilerplate_block() {
    wp_register_script(
        'gutenberg-boilerplate-es5-step01',
        plugins_url( 'step-01/block.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element' )
    );

    register_block_type( 'gutenberg-boilerplate-es5/hello-world-step-01', array(
        'editor_script' => 'gutenberg-boilerplate-es5-step01',
    ) );
}
add_action( 'init', 'gutenberg_boilerplate_block' );


add_filter( 'style_loader_src',  'sdt_remove_ver_css_js', 9999, 2 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999, 2 );

function sdt_remove_ver_css_js( $src, $handle ) 
{
    $handles_with_version = [ 'style' ]; // <-- Adjust to your needs!

    if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )
        $src = remove_query_arg( 'ver', $src );

    return $src;
}

// custom widget 2

class Social_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
`	 */
	function __construct() {
		parent::__construct(
			'Social_Widget', // Base ID
			esc_html__( 'All Social Accounts', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Your Social Media Links', 'rttheme' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		if ( ! empty( $instance['fb_link'] ) ) {
			echo '<li class="item"><a href=' . apply_filters( 'widget_title', $instance['fb_link'] ).'>Facebook</a></li>' ;
		}
		if ( ! empty( $instance['insta_link'] ) ) {
			echo '<li class="item"><a href='.apply_filters( 'widget_title', $instance['insta_link'] ) .'>Instagram</a></li>';
		}
		if ( ! empty( $instance['twit_link'] ) ) {
			echo '<li class="item"><a href='.apply_filters( 'widget_title', $instance['twit_link'] ).'>Twitter</a></li>';
		}
		if ( ! empty( $instance['linked_link'] ) ) {
			echo '<li class="item"><a href='.apply_filters( 'widget_title', $instance['linked_link'] ) .'>Linkedin</a></li>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Title:', 'rttheme' );
		$fb_link = ! empty( $instance['fb_link'] ) ? $instance['fb_link'] : esc_html__( 'Facebook Link', 'rttheme' );
		$twt_link = ! empty( $instance['twit_link'] ) ? $instance['twit_link'] : esc_html__( 'Twitter Link', 'rttheme' );
		$ins_link = ! empty( $instance['insta_link'] ) ? $instance['insta_link'] : esc_html__( 'Instagram Link', 'rttheme' );
		$linked_link = ! empty( $instance['linked_link'] ) ? $instance['linked_link'] : esc_html__( 'Linkedin Link', 'rttheme' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title :', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'fb_link' ) ); ?>"><?php esc_attr_e( 'Facebook Link:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'fb_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'fb_link' ) ); ?>" type="text" value="<?php echo esc_attr( $fb_link ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'twit_link' ) ); ?>"><?php esc_attr_e( 'Twitter Link:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twit_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twit_link' ) ); ?>" type="text" value="<?php echo esc_attr( $twt_link ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'insta_link' ) ); ?>"><?php esc_attr_e( 'Instagram Link:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'insta_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'insta_link' ) ); ?>" type="text" value="<?php echo esc_attr( $ins_link ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'linked_link' ) ); ?>"><?php esc_attr_e( 'Linkedin Link:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'linked_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'linked_link' ) ); ?>" type="text" value="<?php echo esc_attr( $linked_link ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['fb_link'] = ( ! empty( $new_instance['fb_link'] ) ) ? sanitize_text_field( $new_instance['fb_link'] ) : '';
		$instance['twit_link'] = ( ! empty( $new_instance['twit_link'] ) ) ? sanitize_text_field( $new_instance['twit_link'] ) : '';
		$instance['insta_link'] = ( ! empty( $new_instance['insta_link'] ) ) ? sanitize_text_field( $new_instance['insta_link'] ) : '';
		$instance['linked_link'] = ( ! empty( $new_instance['linked_link'] ) ) ? sanitize_text_field( $new_instance['linked_link'] ) : '';

		return $instance;
	}

} // class Foo_Widget

function register_social_widget() {
    register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );

add_action( 'widgets_init', 'rt_widgets_init' );
function rt_widgets_init() {
    
    register_sidebar( array(
        'name' => __( 'Custom Sidebar 4', 'rttheme' ),
        'id' => 'sidebar-4',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name' => __( 'Custom Sidebar 2', 'rttheme' ),
        'id' => 'sidebar-2',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name' => __( 'Custom Sidebar 3', 'rttheme' ),
        'id' => 'sidebar-3',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget'  => '</li>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>',
    ) );

}



class Posts_by_cat_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
`	 */
	function __construct() {
		parent::__construct(
			'Posts_by_cat_Widget', // Base ID
			esc_html__( 'Posts By Category', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Posts With Specefic Category', 'rttheme' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['cat_nm'] ) && ! empty( $instance['number_of_post'] ) ) {
			echo $args['before_title'].$instance['title'].$args['after_title'];
			$posts=new WP_Query(array('category_name' =>$instance['cat_nm'],'posts_per_page' => $instance['number_of_post'] ));

			while ($posts->have_posts()) : $posts->the_post() ;
				the_title( '<p class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></p>' );
			endwhile;	

		}
		
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Title:', 'rttheme' );

		$cat_names=get_categories();
		$cat_n = ! empty( $instance['cat_nm'] ) ? $instance['cat_nm'] : esc_html__( 'Category Name:', 'rttheme' );
		$number_of_post = ! empty( $instance['number_of_post'] ) ? $instance['number_of_post'] : esc_html__( 'Number Of Post', 'rttheme' );
				?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title :', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'cat_nm' ) ); ?>"><?php esc_attr_e( 'Category Name :', 'text_domain' ); ?></label> 
		<select name="<?php echo esc_attr( $this->get_field_name( 'cat_nm' ) ); ?>">
			<?php foreach ($cat_names as $key => $cat_nm) {
				?> <option value="<?php echo $cat_nm->name; ?>"><?php echo $cat_nm->name; ?></option> <?php
			} ?>
		</select>
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_post' ) ); ?>"><?php esc_attr_e( 'Number of posts:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number_of_post' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_of_post' ) ); ?>" type="text" value="<?php echo esc_attr( $number_of_post ); ?>">
		</p>
		
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['cat_nm'] = ( ! empty( $new_instance['cat_nm'] ) ) ? sanitize_text_field( $new_instance['cat_nm'] ) : '';
		$instance['number_of_post'] = ( ! empty( $new_instance['number_of_post'] ) ) ? sanitize_text_field( $new_instance['number_of_post'] ) : '';
		
		return $instance;
	}

} // class Foo_Widget

function register_postby_cat_widget() {
    register_widget( 'Posts_by_cat_Widget' );
}
add_action( 'widgets_init', 'register_postby_cat_widget' );

function rttheme_footer_register( $wp_customize ) {
   //All our sections, settings, and controls will be added here

	$wp_customize->add_setting( 'footer_copyright' , array(
    	'default'   => '',
    	'transport' => 'refresh',
    	 
	) );

	$wp_customize->add_setting( 'footer_logo' , array(
    	'default'   => '',
    	'transport' => 'refresh',
    	 
	) );

	$wp_customize->add_section( 'rttheme_footer' , array(
    	'title'      => __( 'Footer Section', 'rttheme' ),
    	'priority'   => 30,
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_copyright', array(
	'label'      => __( 'Footer Copyright', 'rttheme' ),
	'section'    => 'rttheme_footer',
	'settings'   => 'footer_copyright',
	'type' => 'text'
) ) );


	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_logo', array(
	'label'      => __( 'Footer Logo', 'rttheme' ),
	'section'    => 'rttheme_footer',
	'settings'   => 'footer_logo'
) ) );	


}
add_action( 'customize_register', 'rttheme_footer_register' );