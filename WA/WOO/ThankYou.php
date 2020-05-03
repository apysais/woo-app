<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
use Carbon\Carbon;
/**
 * WA_WOO_CheckOut
 * */
class WA_WOO_ThankYou {
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
    add_action('woocommerce_thankyou', [$this, 'wa_woocommerce_thankyou'], 20, 1 );
  }

  public function wa_woocommerce_thankyou( $order_id ) {
    $data = [];
    $meta_order = new WA_Delivery_Meta;
    $get_delivery_time = $meta_order->delivery_time([
      'post_id' => $order_id,
      'action' => 'r',
      'single' => true,
    ]);
    $get_deliver_on = $meta_order->deliver_on([
      'post_id' => $order_id,
      'action' => 'r',
      'single' => true,
    ]);
    $get_time_deliver = $meta_order->time_deliver([
      'post_id' => $order_id,
      'action' => 'r',
      'single' => true,
    ]);
    $data = [
      'deliver_time' => $get_delivery_time ? $get_delivery_time : WA_STORE_DELIVERY_TIME,
      'deliver_on' => $get_deliver_on,
      'time_deliver' => $get_time_deliver,
    ];
    WA_View::get_instance()->public_partials( 'delivery/recieved.php', $data );
  }


}//
