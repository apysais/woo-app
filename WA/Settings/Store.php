<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
use Carbon\Carbon;
/**
 * Settings_Store
 * */
class WA_Settings_Store {
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

  public function open_daily() {
    return carbon_get_theme_option('crb_open_daily');
  }

  public function open_on() {
    return carbon_get_theme_option('crb_open_day');
  }

  public function opens_at() {
    return carbon_get_theme_option('crb_opens_at');
  }

  public function close_at() {
    return carbon_get_theme_option('crb_close_at');
  }

  public function delivery_time() {
    return carbon_get_theme_option('crb_delivery_time');
  }

  public function is_close_time() {
    $today = Carbon::now(new DateTimeZone(WA_TIME_ZONE));

    //get time
    $close_at = $this->close_at();
    $current_time = $today->format('H');

    if ( $current_time > Carbon::parse($close_at)->format('H') ) {
      return true;
    }
    return false;
  }

  public function is_closed_day() {
    $today = Carbon::now(new DateTimeZone(WA_TIME_ZONE));

    $open_on = $this->open_on();
    $current_date = strtolower( $today->format('l') );
    if ( $this->open_daily() ) {
      return false;
    } else {
      if ( !in_array($current_date, $open_on) ) {
        return true;
      }
    }
    return false;
  }

}//
