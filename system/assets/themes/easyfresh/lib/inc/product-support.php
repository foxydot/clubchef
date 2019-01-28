<?php
class MSDLABProductSupport
{
    function __construct(){
        add_action('genesis_entry_footer', array(&$this,'msdlab_product_footer'));
        add_action('msdlab_product_footer',array(&$this,'msdlab_product_footer_sidebar'), 15);
        add_action('after_setup_theme',array(&$this,'msdlab_add_product_footer_sidebar'), 4);
    }

    function msdlab_product_footer(){
        global $post;
        $page_template = get_page_template_slug($post->ID);
        if($page_template == 'template-product.php') {
            print '<div class="product-footer">';
            do_action('msdlab_product_footer');
            print '
        </div>';
        }
    }

    function msdlab_product_footer_sidebar(){
        print '<div class="widget-area row">';
        dynamic_sidebar( 'product-footer' );
        print '</div>';
    }

    function msdlab_add_product_footer_sidebar(){
        genesis_register_sidebar(array(
            'name' => 'Product Footer',
            'description' => 'Content below each product list',
            'id' => 'product-footer'
        ));
    }

}