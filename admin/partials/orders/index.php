<div class="wrap">
  <div class="bootstrap-iso">
    <div class="container-fluid">
      <h1>Orders</h1>

      <div class="orders-container">
        
        <div class="orders-top-container-full-width">
          <div class="row">
            <div class="col-sm-12 col-md-12">
              <div class="wa-top-orders-full-width'">
                <?php do_action('wa-top-orders-full-width'); ?>
              </div>
            </div>
          </div>
        </div><!-- .dashboard-top-container-full-width -->

        <div class="orders-mid-container-half">
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <div class="wa-mid-orders-left-container">
                <?php do_action('wa-mid-orders-left-container'); ?>
              </div>
            </div>
            <div class="col-sm-12 col-md-6">
              <div class="wa-mid-orders-right-container">
                <?php do_action('wa-mid-orders-right-container'); ?>
              </div>
            </div>
          </div>
        </div><!-- .dashboard-mid-container-half -->

        <div class="orders-bottom-container-full-width">
          <div class="row">
            <div class="col-sm-12 col-md-12">
              <div class="wa-bottom-orders-full-width'">
                <?php do_action('wa-bottom-orders-full-width'); ?>
              </div>
            </div>
          </div>
        </div><!-- .dashboard-bottom-container-full-width -->

      </div><!-- .dashboard-container -->
    </div><!-- .container-fluid -->
  </div><!-- .bootstrap-iso -->
</div><!-- .wrap -->
<script>
function _get_done_orders_ajax() {
  jQuery('.wa-delivery-list-orders').html('<h6> Getting Orders...</h6>');
  var _get_orders = jQuery.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        action: 'wa_refresh_done_orders',
      },
      async: false
  });
  _get_orders.done(function( msg ) {
    jQuery('.wa-delivery-list-orders').html(msg);
  });
}
jQuery( window ).load(function() {
  // Enable pusher logging - don't include this in production
  //Pusher.logToConsole = true;

  var pusher = new Pusher('c360be1f31eaae53e193', {
    cluster: 'ap1'
  });
  //per client has its own channel
  var channel = pusher.subscribe('orders-done');
  channel.bind('order', function(data) {
    if ( data.order == 'done' ) {
      _get_done_orders_ajax();
    }
  });
});
</script>
