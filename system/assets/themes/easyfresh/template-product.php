<?php
/*
Template Name: Product Page
*/

add_filter('genesis_attr_entry-title','msdlab_add_image');

function msdlab_add_image($attributes){
    global $post;
    $slug = $post->post_name;
    $attributes['class'] .= ' product-title-image';
    $attributes['style'] = 'background-image:url("'.get_stylesheet_directory_uri().'/lib/images/product-banner-'.$slug.'.jpg")';
    return $attributes;
}

add_action('genesis_entry_content','msdlab_add_chart',6);

function msdlab_add_chart(){
    global $wpdb,$post;
    $sql = 'SELECT * FROM cc_product_list WHERE page = "'.$post->post_title.'";';
    if($results = $wpdb->get_results($sql)){
        $header_row = '<tr class="header-row"><th>Item Number</th><th>Products</th><th>Blend</th><th>Shelf Life</th><th>Pack Size</th></tr>';
        $data_row = array();
        foreach($results AS $result){
            $data_row[] = '<tr ><td>'.$result->item_number.'</td><td>'.$result->products.'</td><td>'.$result->blend.'</td><td>'.$result->shelf_life.'</td><td>'.$result->pack_size.'</td></tr>';
        }
        $table = '<table class="product-list">
'.$header_row.'
'.implode("\n",$data_row).'
</table>';
        print $table;
    }
}

genesis();
