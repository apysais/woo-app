<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
use Carbon_Fields\Container;
use Carbon_Fields\Field;
/**
 *
 * @since 0.0.1
 * */
class WA_CarbonFields_Options {
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

  private function _getWeekdays() {
    return [
      'monday' => 'Monday',
      'tuesday' => 'Tuesday',
      'wednesday' => 'Wednesday',
      'thursday' => 'Thursday',
      'friday' => 'Friday',
      'saturday' => 'Saturday',
      'sunday' => 'Sunday',
    ];
  }

  public function __construct() {
    $weekdays = $this->_getWeekdays();

    $basic_options_container = Container::make( 'theme_options', __( 'Store Options' ) )
    ->add_fields( array(
      Field::make( 'checkbox', 'crb_open_daily', __( 'Open Daily?' ) )
        ->set_option_value( 'yes' ),
      Field::make( 'multiselect', 'crb_open_day', __( 'Open On' ) )
        ->set_conditional_logic( array(
            array(
              'field' => 'crb_open_daily',
              'value' => false,
            )
        ) )
        ->add_options( $weekdays ),
      Field::make( 'time', 'crb_opens_at', __( 'Store open' ) ),
      Field::make( 'time', 'crb_close_at', __( 'Store close' ) ),
      Field::make( 'text', 'crb_delivery_time', __( 'Delivery Time ( Set Delivery time in minutes )' ) )
        ->set_attribute( 'placeholder', 'Set Delivery time in minutes' )
        ->set_default_value('25'),
    ) );
  }


}//
