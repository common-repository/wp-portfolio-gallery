<?php
namespace JLTWPFOLIO\Inc\Classes;


if ( ! class_exists( 'WP_Fortfolio_Gallery' ) ) {

    /**
	 * WP Portfolio Gallery Class
	 *
	 * Jewel Theme <support@jeweltheme.com>
	 */
	class WP_Fortfolio_Gallery {

        public $jltwpfolio_width;
        public $jltwpfolio_height;
		/**
		 * Construct method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
            //Set Thumbnail Image size
            $this->jltwpfolio_width = get_option('jeweltheme_thumb_width');
            $this->jltwpfolio_height = get_option('jeweltheme_thumb_height');
            set_post_thumbnail_size( 'jw-portfolio-thumb', $this->jltwpfolio_width, $this->jltwpfolio_height );

            add_action( 'init', [ $this, 'jltwpfolio_portfolio' ] );
            add_filter( 'post_updated_messages', [ $this, 'jltwpfolio_messages' ] );
            add_action( 'admin_init',  [ $this, 'jltwpfolio_portfolio_meta' ] );
            add_filter( 'template_include', [ $this, 'jltwpfolio_include_template_function' ], 1 );
            add_action( 'template_redirect', [ $this, 'jltwpfolio_portfolio_template_redirect' ] );

            //Portfolio Settings Fields.
            add_action('admin_menu', [ $this, 'jltwpfolio_add_options' ] );
            add_action('admin_init', [ $this, 'jltwpfolio_service_settings_store' ]);
            add_action('admin_init', [ $this, 'jeweltheme_wp_gallery_ignore' ]);
        }

        function jeweltheme_wp_gallery_ignore() {
            global $current_user;
                $user_id = $current_user->ID;
                if ( isset($_GET['jeweltheme_wp_gallery_ignore']) && '0' == $_GET['jeweltheme_wp_gallery_ignore'] ) {
                    add_user_meta($user_id, 'jeweltheme_wp_gallery_ignore_notice', 'true', true);
            }
        }

        //Redirect to the WP Portfolio Template
        function jltwpfolio_portfolio_template_redirect() {
            global $wp_query;
            global $wp;

            if ( 'portfolio' === $wp_query->query_vars['post_type'] ) {
                if ( have_posts() ) {
                    $template_path = plugin_dir_path( __FILE__ ) . '/theme/page-portfolio.php';
                    die();
                } else {
                    $wp_query->is_404 = true;
                }

            }
        }

        //Add options page
        function jltwpfolio_add_options() {
            add_submenu_page(
                'edit.php?post_type=portfolio', 
                'Portfolio Admin',
                'Portfolio Settings', 
                'edit_posts', 
                basename(__FILE__), 
                [$this,'jltwpfolio_portfolio_setting_functions' ]
            );
            register_setting( 'portfolio_settings', 'plugin_options' );
        }

        //Register Settings Page
        function jltwpfolio_service_settings_store() {
            register_setting('jeweltheme_portfolio_settings', 'jeweltheme_items');
            register_setting('jeweltheme_portfolio_settings', 'jeweltheme_layouts');
            register_setting('jeweltheme_portfolio_settings', 'jeweltheme_thumb_width');
            register_setting('jeweltheme_portfolio_settings', 'jeweltheme_thumb_height');
        }

        function jltwpfolio_include_template_function( $template_path ) {
            if ( get_the_title() == 'Portfolio' ) {
                $template_path = plugin_dir_path( __FILE__ ) . '/theme/page-portfolio.php';
            }

            return $template_path;
        }



        function jltwpfolio_portfolio_setting_functions(){ ?>
                <div class="wrap">
            <div class="icon32" id="icon-options-general"><br></div>
                <h2>WP Portfolio Gallery Settings</h2>
            <p>Settings sections for WP Portfolio Gallery Text, Animation, CSS etc</p>
            <form method="post" action="options.php">
                <?php settings_fields('jeweltheme_portfolio_settings'); ?>
                <table class="form-table">
                    <tr>
                        <th>
                            <label>Portfolio Items Per Column</label>
                        </th>
                        <td>
                            <input type="number" name="jeweltheme_items" value="<?php echo get_option('jeweltheme_items'); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label>Thumbnail Width:</label>
                        </th>
                        <td>
                            <input type="number" name="jeweltheme_thumb_width" value="<?php echo get_option('jeweltheme_thumb_width'); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label>Thumbnail Height:</label>
                        </th>
                        <td>
                            <input type="number" name="jeweltheme_thumb_height" value="<?php echo get_option('jeweltheme_thumb_height'); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label>Layout</label>
                        </th>
                        <td>
                            <?php
                                    $options = get_option('jeweltheme_layouts');
                                    $items = array("Layout 1", "Layout 2", "Layout 3", "Layout 4", "Layout 5");
                                    echo "<select id='layout' name='jeweltheme_layouts[layout]'>";
                                    foreach($items as $item) {
                                        $selected = ($options['layout']==$item) ? 'selected="selected"' : '';
                                        echo "<option value='$item' $selected>$item</option>";
                                    }
                                    echo "</select>";
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="submit" class="button-primary" value="Save Changes" />
                        </td>
                    </tr>
                </table>
            </form>
        <?php
        }

        /*--- Demo URL meta box ---*/
        public function jltwpfolio_portfolio_meta() {
            // add a meta box for WordPress 'project' type
            add_meta_box('jeweltheme_portfolio', 'Portfolio URL', [ $this, 'jltwpfolio_portfolio_meta_setup' ], 'portfolio', 'side', 'low');

            // add a callback function to save any data a user enters in
            add_action('save_post', [$this, 'jltwpfolio_portfolio_meta_save' ] );
        }


        public function jltwpfolio_portfolio_meta_setup() {
            global $post;

            ?>
                <div class="portfolio_meta_control">

                    <p>
                        <input type="text" name="_url" placeholder="http://"value="http://<?php echo get_post_meta($post->ID,'_url',TRUE); ?>" style="width: 100%;" />
                    </p>
                    <em style="color:red;">Without http:// and starts with Example: www.sitename.com</em>
                </div>
            <?php

            // create for validation
            echo '<input type="hidden" name="jeweltheme_meta_nonce" value="' . wp_create_nonce(__FILE__) . '" />';
        }

        function jltwpfolio_portfolio_meta_save($post_id) {
            // check nonce
            if (!isset($_POST['jeweltheme_meta_nonce']) || !wp_verify_nonce($_POST['jeweltheme_meta_nonce'], __FILE__)) {
                return $post_id;
            }

            // check capabilities
            if ('post' == $_POST['portfolio']) {
                if (!current_user_can('edit_post', $post_id)) {
                    return $post_id;
                }
            } elseif (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }

            // exit on autosave
            if (defined('DOING_AUTOSAVE') == DOING_AUTOSAVE) {
                return $post_id;
            }

            if(isset($_POST['_url'])) {
                update_post_meta($post_id, '_url', $_POST['_url']);
            } else {
                delete_post_meta($post_id, '_url');
            }
        }


        //Post Type Update
        function jltwpfolio_messages( $messages ) {
            global $post, $post_ID;
            $messages['portfolio'] = array(
                0 => '', //If Unused, Messages start at index 1
                1 => sprintf( __('Portfolio Updated. <a href="%s">View Portfolio</a>'), esc_url( get_permalink($post_ID) ) ),
                2 => __('Portfolio Item Updated.'),
                3 => __('Portfolio Item Deleted.'),
                4 => __('Portfolio updated.'),
                5 => isset($_GET['revision']) ? sprintf( __('Portfolio restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
                6 => sprintf( __('Portfolio Published. <a href="%s">View product</a>'), esc_url( get_permalink($post_ID) ) ),
                7 => __('Portfolio saved.'),
                8 => sprintf( __('Portfolio submitted. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
                9 => sprintf( __('Portfolio scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
                10 => sprintf( __('Portfolio draft updated. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
            );
            return $messages;
        }


        //Custom Post Type Portfolio.
        public function jltwpfolio_portfolio() {
            $labels = array(
                'name'               => _x( 'Portfolio', 'post type general name' ),
                'singular_name'      => _x( 'Portfolio', 'post type singular name' ),
                'add_new'            => _x( 'Add New', 'book' ),
                'add_new_item'       => __( 'Add New Portfolio' ),
                'edit_item'          => __( 'Edit Portfolio' ),
                'new_item'           => __( 'New Portfolio Items' ),
                'all_items'          => __( 'All Portfolio' ),
                'view_item'          => __( 'View Portfolio' ),
                'search_items'       => __( 'Search Portfolio' ),
                'not_found'          => __( 'No Portfolio Items found' ),
                'not_found_in_trash' => __( 'No Portfolio Items found in the Trash' ),
                'parent_item_colon'  => '',
                'menu_name'          => 'WP Portfolio'
            );


            $args = array(
                'labels'        => $labels,
                'description'   => 'Holds Portfolio specific data',
                'public'        => true,
                'show_ui'       => true,
                'show_in_menu'  => true,
                'query_var'     => true,
                'rewrite' => array(
                'slug' => 'portfolio/%year%',
                'with_front' => true
                ),
                'capability_type'=> 'post',
                'has_archive'   => true,
                'hierarchical'  => false,
                'menu_position' => 5,
                'supports'      => array( 'title', 'editor', 'thumbnail'),
                'menu_icon' => JLTWPFOLIO_ASSETS . 'images/portfolio.png' // Icon Path
            );
            register_post_type( 'portfolio', $args );

            // Custom taxonomy for Portfolio Tags
            $labels = array(
                'name' => _x( 'Categories', 'taxonomy general name' ),
                'singular_name' => _x( 'WP Portfolio Category', 'taxonomy singular name' ),
                'search_items' =>  __( 'Search Types' ),
                'all_items' => __( 'All Categories' ),
                'parent_item' => __( 'Parent Category' ),
                'parent_item_colon' => __( 'Parent Category:' ),
                'edit_item' => __( 'Edit Category' ),
                'update_item' => __( 'Update Category' ),
                'add_new_item' => __( 'Add New Category' ),
                'new_item_name' => __( 'New Category Name' ),
            );

            // Custom taxonomy for Project Tags.
            register_taxonomy('jwtag', array('portfolio'), array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' =>true,
            ));
        }
    }

}