<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   WP_Whitelabel
 * @author    RC Lations II <rc@hallme.com>
 * @license   GPL-2.0+
 * @link      https://github.com/hallme/wp-whitelabel
 * @copyright 2014 RC Lations II
 */
?>
    
<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<!-- @TODO: Provide markup for your options page here. -->
	
    <form action="options.php" method="POST">
        <?php settings_fields( 'wp_whitelabel_settings' ); ?>
        <?php do_settings_sections( 'wp_whitelabel' ); ?>
        <?php submit_button(); ?>
    </form>
    
</div>
