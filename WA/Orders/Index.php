<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Template
 * */
class WA_Orders_Index {
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
    add_action('wa-top-orders-full-width', [$this, 'init']);
  }

  public function init( $args = [] ) {
    $data = [];
    $orders = new WA_Orders_Get;
		$local_pickup = $orders->readyOrders();
		$delivery = $orders->readyOrders();

    $data = [
      'local_pickup' => $local_pickup,
      'delivery' => $delivery,
      'class' => 'col-md-6 col-sm-12'
    ];
    //_dd($data);
    WA_View::get_instance()->admin_partials( 'orders/deliver-loop-list.php', $data );
  }

}//
