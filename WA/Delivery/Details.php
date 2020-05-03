<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
use Carbon\Carbon;
/**
 * Delivery_Details
 * */
class WA_Delivery_Details {
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
    add_action('woocommerce_checkout_before_order_review', [$this, 'show']);
  }

  public function getTimeDeliver() {
    $time_deliver = [];
    $time_opens_at = '';

    $store_settings = new WA_Settings_Store;

    $opens_at = $store_settings->opens_at();
    $close_at = $store_settings->close_at();
    $current_hour_time = Carbon::now(new DateTimeZone(WA_TIME_ZONE));
    if ( $current_hour_time->format('H') > Carbon::parse($opens_at)->format('H') ) {
      $time_opens_at = $current_hour_time->format('H:i:s');
    } else {
      $time_opens_at = $opens_at;
    }

    if ( $opens_at && $close_at) {
      $range = range( strtotime($time_opens_at), strtotime($close_at), WA_STORE_TIME_INTERVAL * 60 );
      foreach($range as $time){
        $time_deliver[] = Carbon::parse($time)->format('h:i A');
      }
    }

    return $time_deliver;

  }

  public function getDaysDeliver() {
    $day_open = [];
    $store_settings = new WA_Settings_Store;
    $open_daily = $store_settings->open_daily();

    $day_open[] = Carbon::now()->format('l') . ', '.Carbon::now()->format('M').' '.Carbon::now()->format('d');

    if ( $open_daily ) {
      for ($i = 1; $i <= 7; $i++) {
        $day_open[] = Carbon::now()->addDays($i)->format('l') . ', '.Carbon::now()->addDays($i)->format('M').' '.Carbon::now()->addDays($i)->format('d');
      }
    } else {
      $open_on = $store_settings->open_on();
      for ($i = 1; $i <= 7; $i++) {
        $day_to_lower = strtolower(Carbon::now()->addDays($i)->format('l'));
        if ( in_array($day_to_lower, $open_on) ) {
          $date_on = Carbon::now()->addDays($i)->format('l') . ', '.Carbon::now()->addDays($i)->format('M').' '.Carbon::now()->addDays($i)->format('d');
          $day_open[] = $date_on;
        }
      }
    }
    return $day_open;
  }

  public function show() {
    $data = [];
    $store_settings = new WA_Settings_Store;
    $day_open = $this->getDaysDeliver();
    $time_deliver = $this->getTimeDeliver();
    $delivery_time = $store_settings->delivery_time();
    $data = [
      'deliver_time' => $delivery_time ? $delivery_time : WA_STORE_DELIVERY_TIME,
      'deliver_on' => $day_open,
      'time_deliver' => $time_deliver,
    ];
    WA_View::get_instance()->public_partials( 'delivery/details.php', $data );
  }

}//
