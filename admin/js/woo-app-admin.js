(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 var wa_get_orders_dashboards = function() {
		function _ajax() {
			var _get_orders = $.ajax({
					type: "POST",
					url: ajaxurl,
					data: {
						action: 'wa_refresh_orders',
					},
					async: false
			});
			return _get_orders;
		}
		function _test() {
			$('.test-ajax').on('click', function(e){
				var _init_ajax = _ajax();
				_init_ajax.done(function( msg ) {
			    //console.log(msg);
					$('.orders-list').html(msg);
			  });
			});
		}
		function _get_orders() {
			var _init_ajax = _ajax();
			_init_ajax.done(function( msg ) {
		    //console.log(msg);
				$('.orders-list').html(msg);
		  });
		}
		return {
			init : function() {
				_test();
			},
			getOrders : function() {
				_get_orders();
				alert('aasd');
			}
		};
	}();

	$( window ).load(function() {
		wa_get_orders_dashboards.init();
		//wa_get_orders_dashboards.getOrders();
	});

})( jQuery );
