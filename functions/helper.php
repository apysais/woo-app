<?php
function wa_store_office_access() {
	if (
		WA_User_Role::get_instance()->is_store_owner()
		|| WA_User_Role::get_instance()->is_shop_manager()
		|| WA_User_Role::get_instance()->is_admin()
	) {
		return true;
	}
	return false;
}
function wa_remove_cap_shop_manager() {
	$shop_manager = get_role( 'shop_manager' );
	// A list of capabilities to remove from editors.
  $caps = array(
    'update_themes',
    'install_themes',
    'update_core',
    'edit_theme_options',
    'delete_themes',
    'moderate_comments',
    'import',
    'export',
  );

  foreach ( $caps as $cap ) {
    // Remove the capability.
    $shop_manager->remove_cap( $cap );
  }
}
function wa_redirect_to($url) {
	?>
	<script type="text/javascript">
		window.location = '<?php echo $url; ?>';
	</script>
	<?php
	die();
}
function wa_important_icon($order_id) {
	$important = WA_Orders_Meta::get_instance()->important([
		'post_id' => $order_id,
		'action' => 'r',
		'single' => true
	]);

	if ( $important && $important == 1 ) {
		echo '<i class="fas fa-star fa-2x" title="Important"></i>';
	}
}

function wa_get_shipping_methods($shipping_obj) {
	$shipping_arr = [];
	foreach( $shipping_obj->get_items( 'shipping' ) as $item_id => $shipping_item_obj ){
			$shipping_arr = [
				'order_item_name'             => $shipping_item_obj->get_name(),
		    'order_item_type'            	=> $shipping_item_obj->get_type(),
		    'shipping_method_title'       => $shipping_item_obj->get_method_title(),
		    'shipping_method_id'          => $shipping_item_obj->get_method_id(),
		    'shipping_method_instance_id' => $shipping_item_obj->get_instance_id(),
		    'shipping_method_total'       => $shipping_item_obj->get_total(),
		    'shipping_method_total_tax'   => $shipping_item_obj->get_total_tax(),
		    'shipping_method_taxes'       => $shipping_item_obj->get_taxes()
			];
	}
	return $shipping_arr;
}

function wa_shipping_icon($shipping_obj) {
	$ship_method_id = wa_get_shipping_methods($shipping_obj);

	if ( isset($ship_method_id['shipping_method_id']) && $ship_method_id ) {
		switch($ship_method_id['shipping_method_id']) {
			case 'local_pickup':
				echo '<i class="fas fa-warehouse fa-2x" title="Local pickup"></i>';
				break;
			case 'flat_rate':
			case 'free_shipping':
				echo '<i class="fas fa-truck fa-2x" title="Delivery"></i>';
				break;
		}
	}
}

function wa_shipping_text($shipping_obj) {
	$ship_method_id = wa_get_shipping_methods($shipping_obj);
	if ( isset($ship_method_id['shipping_method_id']) && $ship_method_id ) {
    return $ship_method_id['shipping_method_title'];
	}
}

function wa_is_store_closed() {
  if ( wa_is_store_closed_time() ) {
    return true;
  } elseif ( wa_is_store_closed_day() ) {
    return true;
  }
  return false;
}
function wa_is_store_closed_day() {
  $store_settings = new WA_Settings_Store;
  return $store_settings->is_closed_day();
}
function wa_is_store_closed_time() {
  $store_settings = new WA_Settings_Store;
  return $store_settings->is_close_time();
}
function _dd($arr = [], $exit = false) {
  echo '<pre>';
  print_r($arr);
  echo '</pre>';
  if ( $exit ) {
    exit();
  }
}
