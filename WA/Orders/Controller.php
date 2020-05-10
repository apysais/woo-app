<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Orders Controller
 * */
class WA_Orders_Controller extends WA_Base {
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

	public function complete_orders() {
		echo 'asd';
	}

	public function complete() {
		$order_id = false;
		if ( isset($_POST['order_id']) ) {
			$order_id = $_POST['order_id'];
			$order = wc_get_order( $order_id );
	    $order->update_status( 'completed' );
		}
		wa_redirect_to( admin_url('admin.php?page=orders') );
	}

	public function orders() {
		$data = [];
    WA_View::get_instance()->admin_partials( 'orders/index.php', $data );
	}

	public function done() {
		if ( isset($_POST['order_id']) ) {
			$order_id = $_POST['order_id'];
			WA_Orders_WareHouseStatus::get_instance()->setToDone($order_id);
			WA_Pusher_Push::get_instance()->doneOrders();
		}
		wa_redirect_to( admin_url('admin.php?page=app-dashboard') );
	}

	public function working() {
		if ( isset($_POST['order_id']) ) {
			$order_id = $_POST['order_id'];
			WA_Orders_WareHouseStatus::get_instance()->setToWorking($order_id);
			WA_Pusher_Push::get_instance()->notifyWareHouse();
		}
		wa_redirect_to( admin_url('admin.php?page=app-dashboard') );
	}

	public function set_release()	{

		if ( isset($_POST['order_id']) ) {
			$order_id = $_POST['order_id'];
			WA_Orders_WareHouseStatus::get_instance()->setToReleased($order_id);
			if ( isset($_POST['commentWarehouse']) ) {
				$note = $_POST['commentWarehouse'];
				$order = wc_get_order(  $order_id );
        // Add the note
        $order->add_order_note( $note );
			}
			if ( isset($_POST['importantOrder']) ) {
				WA_Orders_Meta::get_instance()->important([
					'post_id' => $order_id,
					'action' => 'u',
					'value' => 1
				]);
			}
			WA_Pusher_Push::get_instance()->notifyWareHouse();
		}
		wa_redirect_to( admin_url('admin.php?page=app-dashboard') );
	}

	/**
	 * Controller
	 *
	 * @param	$action		string | empty
	 * @parem	$arg		array
	 * 						optional, pass data for controller
	 * @return mix
	 * */
	public function controller($action = '', $arg = array()){
		$this->call_method($this, $action);
	}

	public function __construct(){}

}
