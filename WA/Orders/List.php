<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Template
 * */
class WA_Orders_List {
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

  }

  public function get_orders( $args = [] ) {
    $data = [];
		$orders = new WA_Orders_Get;
		$new_orders = $orders->newOrders();
		$released_orders = $orders->releasedOrders();
		$working_orders = $orders->workingOrders();
		$data = [
			'new_orders' => $new_orders['orders'],
			'released_orders' => $released_orders['orders'],
			'working_orders' => $working_orders['orders'],
			'class' => 'col-sm-12 col-md-12'
		];
    WA_View::get_instance()->admin_partials( 'orders/loop-list.php', $data );
  }


}//
