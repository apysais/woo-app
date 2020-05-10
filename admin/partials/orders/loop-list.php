<div class="wa-dashboard-list-orders">
  <div class="row">
    <?php if ( wa_store_office_access() ) : ?>
      <?php if ( $new_orders ) : ?>
        <div class="<?php echo $class;?>">
          <h5>New Orders</h5>
          <?php
            WA_View::get_instance()->admin_partials( 'orders/part-loop-list.php', ['orders'=>$new_orders, 'status' => 'new'] );
          ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <?php if ( $released_orders ) : ?>
      <div class="<?php echo $class;?>">
        <h5>Released Orders</h5>
        <?php
          WA_View::get_instance()->admin_partials( 'orders/part-loop-list.php', ['orders'=>$released_orders, 'status' => 'released'] );
        ?>
      </div>
    <?php endif; ?>

    <?php if ( $working_orders ) : ?>
      <div class="<?php echo $class;?>">
        <h5>Working Orders</h5>
        <?php
          WA_View::get_instance()->admin_partials( 'orders/part-loop-list.php', ['orders'=>$working_orders, 'status' => 'working'] );
        ?>
      </div>
    <?php endif; ?>

  </div>
</div>
