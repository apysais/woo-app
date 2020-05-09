<div class="wa-dashboard-list-orders">
  <div class="row">
    <?php if ( $new_orders ) : ?>
      <div class="<?php echo $class;?>">
        <h5>New Orders</h5>
        <?php
          WA_View::get_instance()->admin_partials( 'orders/part-loop-list.php', ['orders'=>$new_orders, 'status' => 'new'] );
        ?>

      </div>
    <?php endif; ?>

    <?php if ( $released_orders ) : ?>
      <div class="<?php echo $class;?>">
        <h5>Released Orders</h5>
        <?php
          WA_View::get_instance()->admin_partials( 'orders/part-loop-list.php', ['orders'=>$released_orders, 'status' => 'released'] );
        ?>
      </div>
    <?php endif; ?>
  </div>
</div>
