<div class="wrap">
  <div class="bootstrap-iso">
    <div class="container-fluid">
      <h1>Dashboard</h1>

      <div class="dashboard-container">

        <div class="dashboard-top-container-full-width">
          <div class="row">
            <div class="col-sm-12 col-md-12">
              <div class="wa-top-dashboard-full-width'">
                <?php do_action('wa-top-dashboard-full-width'); ?>
              </div>
            </div>
          </div>
        </div><!-- .dashboard-top-container-full-width -->

        <div class="dashboard-mid-container-half">
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <div class="wa-mid-dashboard-left-container">
                <?php do_action('wa-mid-dashboard-left-container'); ?>
              </div>
            </div>
            <div class="col-sm-12 col-md-6">
              <div class="wa-mid-dashboard-right-container">
                <?php do_action('wa-mid-dashboard-right-container'); ?>
              </div>
            </div>
          </div>
        </div><!-- .dashboard-mid-container-half -->

        <div class="dashboard-bottom-container-full-width">
          <div class="row">
            <div class="col-sm-12 col-md-12">
              <div class="wa-bottom-dashboard-full-width'">
                <?php do_action('wa-bottom-dashboard-full-width'); ?>
              </div>
            </div>
          </div>
        </div><!-- .dashboard-bottom-container-full-width -->

      </div><!-- .dashboard-container -->
    </div><!-- .container-fluid -->
  </div><!-- .bootstrap-iso -->
</div><!-- .wrap -->
<script>

function _get_orders_ajax() {
  var _get_orders = jQuery.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        action: 'wa_refresh_orders',
      },
      async: false
  });
  _get_orders.done(function( msg ) {
    //console.log(msg);
    jQuery('.orders-list').html(msg);
  });
}
jQuery( window ).load(function() {
  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher('c360be1f31eaae53e193', {
    cluster: 'ap1'
  });
  //per client has its own channel
  var channel = pusher.subscribe('warehouse');
  channel.bind('order', function(data) {
    console.log(data.order);
    console.log(JSON.stringify(data));
    //alert(JSON.stringify(data));
    if ( data.order == 'notify' ) {
      _get_orders_ajax();
    }
  });
});
</script>
