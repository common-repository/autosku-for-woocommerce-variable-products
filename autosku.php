<?php
/*
 * Plugin Name: autoSKU for WooCommerce Variable Products
 * Plugin URI: http://ldav.it/wp/plugins/autoSKU/
 * Description: Automatically assign unique SKU to all your product variations, adding a letter (a, b, c, ...) to the main product SKU.  
 * Author: laboratorio d'Avanguardia
 * Author URI: http://ldav.it/
 * Version: 0.2.0
 * Requires at least: 3.8
 * Tested up to: 4.9.8

 * Text Domain: autosku
 * Domain Path: /languages/
 * WC requires at least: 2.6.0
 * WC tested up to: 3.4.5

*/

function autosku_load_plugin_textdomain() {
	load_plugin_textdomain( 'autosku', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'autosku_load_plugin_textdomain' );

function autosku_add_script ($post ) {
	if($post->post_type == "product") {
?>
<style>.assegnaSku{margin:4px 0 0 8px; cursor:pointer; font-size:1.5em; display:inline-block}</style>
<script type="text/javascript">
function assegnaSku(){
	if(!confirm("<?php echo __("Assign code to variations?", "autosku") ?>")) return(false);
	mainsku = jQuery("#general_product_data #_sku").val();
	caratteri=['', 'a','b','c','d','e','f','g','h','j','k','m','n','p','q','r','s','t','u','w','x','y','z'];
	if(mainsku) {
		n = 0;
		jQuery(".woocommerce_variation input[name^='variable_sku']").each(function(ndx, el) {
			c = parseInt(n/21);
			n = n % 21;
			s = caratteri[c] + caratteri[n+1];
			jQuery(this).val(mainsku + s);
			n++;
		});
	}
}

jQuery(function($){
	if(jQuery("#product-type").val() == "variable") jQuery('<i class="dashicons dashicons-admin-generic assegnaSku" title="<?php echo __("Assign code to variations", "autosku") ?>"></i>').insertAfter("#general_product_data #_sku").click(assegnaSku);
});
</script>
<?php
	}
}
add_action ('edit_form_advanced', 'autosku_add_script');
?>