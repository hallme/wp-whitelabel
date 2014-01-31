<?php
/**
 * @package Whitelabel
 * @version 1.0
 */
/*
Plugin Name: Whitelabel
Plugin URI: 
Description: Whitelabel basic parts of WordPress Plugins
Author: RC Lations
Version: 1.0
Author URI: 
*/

function whitelabel_yoast() {
   echo '<style type="text/css">
           body.toplevel_page_wpseo_dashboard .postbox-container #sidebar { display: none; }
           body.seo_page_wpseo_titles .postbox-container #sidebar { display: none; }
           body.seo_page_wpseo_social .postbox-container #sidebar { display: none; }
           body.seo_page_wpseo_xml .postbox-container #sidebar { display: none; }
           body.seo_page_wpseo_permalinks .postbox-container #sidebar { display: none; }
           body.seo_page_wpseo_internal-links .postbox-container #sidebar { display: none; }
           body.seo_page_wpseo_rss .postbox-container #sidebar { display: none; }
           body.seo_page_wpseo_import .postbox-container #sidebar { display: none; }
           body.seo_page_wpseo_files .postbox-container #sidebar { display: none; }
         </style>';
}
add_action('admin_head', 'whitelabel_yoast');


function remove_page_analysis_from_publish_box() { return false; }
add_filter('wpseo_use_page_analysis', 'remove_page_analysis_from_publish_box');

?>
