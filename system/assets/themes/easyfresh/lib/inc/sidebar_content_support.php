<?php

if (!class_exists('MSDLab_Sidebar_Content_Support')) {
    class MSDLab_Sidebar_Content_Support {
        //Properties
        private $options;

        //Methods
        /**
         * PHP 4 Compatible Constructor
         */
        public function MSDLab_Sidebar_Content_Support(){$this->__construct();}

        /**
         * PHP 5+ Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            //Actions
            add_action( 'init', array(&$this,'register_metaboxes') );
            add_action('admin_print_styles', array(&$this,'add_admin_styles') );
            add_action('admin_footer',array(&$this,'footer_hook') );
            add_action('genesis_sidebar_alt',array(&$this,'msdlab_do_sidebar_content') );
            add_action('wp_head',array(&$this,'switch_template'));

            //Filters
        }

        function register_metaboxes(){
            global $sidebar_content_metabox;
            $sidebar_content_metabox = new WPAlchemy_MetaBox(array
            (
                'id' => '_sidebar_content',
                'title' => 'Sidebar Content Area',
                'types' => array('page'),
                'context' => 'normal', // same as above, defaults to "normal"
                'priority' => 'high', // same as above, defaults to "high"
                'template' => get_stylesheet_directory() .'/lib/template/metabox-sidebar-content.php',
                'autosave' => TRUE,
                'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
                'prefix' => '_msdlab_' // defaults to NULL
            ));
        }

        function add_admin_styles() {
            //wp_enqueue_style('custom_meta_css',plugin_dir_url(dirname(__FILE__)).'css/meta.css');
        }

        function footer_hook()
        {
            ?><script type="text/javascript">
            jQuery('#titlediv').after(jQuery('#_sidebar_content_metabox'));
        </script><?php
        }

        function switch_template(){
            if(is_page()) {
                global $post, $sidebar_content_metabox;
                $sidebar_content_metabox->the_meta();
                $sidebarbool = $sidebar_content_metabox->get_the_value('sidebarbool');
                if ($sidebarbool != 'true') {
                    return;
                }
                add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content_sidebar' );
            }
        }

        function msdlab_do_sidebar_content(){
            if(is_page()){
                global $post, $sidebar_content_metabox;
                $sidebar_content_metabox->the_meta();
                $sidebarbool = $sidebar_content_metabox->get_the_value('sidebarbool');
                if($sidebarbool != 'true'){
                    return;
                }
                $sidebarclass = $sidebar_content_metabox->get_the_value('sidebarclass');
                $sidebarcontent = apply_filters('the_content',$sidebar_content_metabox->get_the_value('sidebarcontent'));
                global $post;
                print '<div class="sidebarcontent '.$sidebarclass.'">'.$sidebarcontent.'</div>';
            }
        }

    } //End Class
} //End if class exists statement