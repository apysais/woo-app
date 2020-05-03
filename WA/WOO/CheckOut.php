<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
use Carbon\Carbon;
/**
 * WA_WOO_CheckOut
 * */
class WA_WOO_CheckOut {
  /**
	 * instance of this class
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.0.1
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function __construct() {
    add_filter('woocommerce_order_button_html', [$this, 'remove_order_button_html'] );
    add_action('woocommerce_checkout_update_order_meta', [$this, 'add_delivery_details'], 20, 2 );
  }

  public function add_delivery_details( $order_id, $data ) {
    $meta_order = new WA_Delivery_Meta;
    if ( isset($_POST['delivery_time']) ) {
      $meta_order->delivery_time([
        'post_id' => $order_id,
        'action' => 'u',
        'value' => $_POST['delivery_time'],
      ]);
    }
    if ( isset($_POST['deliver_on']) ) {
      $meta_order->deliver_on([
        'post_id' => $order_id,
        'action' => 'u',
        'value' => $_POST['deliver_on'],
      ]);
    }
    if ( isset($_POST['time_deliver']) ) {
      $meta_order->time_deliver([
        'post_id' => $order_id,
        'action' => 'u',
        'value' => $_POST['time_deliver'],
      ]);
    }
  }

  public function remove_order_button_html( $button ) {
    if ( wa_is_store_closed() ) {
      $button = '';
    }
    return $button;
  }

}//
