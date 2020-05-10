<div class="wa-delivery-list-orders">
  <?php WA_View::get_instance()->admin_partials( 'nav.php', [] ); ?>
  <div class="row">
    <?php if ( wa_store_office_access() ) : ?>
      <?php if ( $local_pickup ) : ?>
        <div class="<?php echo $class;?>">
          <h5>Pickup Orders</h5>
          <?php
            WA_View::get_instance()->admin_partials( 'orders/part-loop-pickup.php', ['local_pickup'=>$local_pickup, 'status' => 'pickup'] );
          ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <?php if ( $delivery ) : ?>
      <div class="<?php echo $class;?>">
        <h5>Delivery Orders</h5>
        <?php
          WA_View::get_instance()->admin_partials( 'orders/part-loop-delivery.php', ['delivery'=>$delivery, 'status' => 'delivery'] );
        ?>
      </div>
    <?php endif; ?>

  </div>
</div>
