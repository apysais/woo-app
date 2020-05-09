<?php if ( $orders ) : ?>
  <ul class="list-group accordion" id="<?php echo $status.'-orders';?>">
    <?php $meta_order = new WA_Delivery_Meta; ?>
    <?php foreach ( $orders as $order ) : ?>
      <?php
        $order_id = $order->get_id();

        $get_delivery_time = $meta_order->delivery_time([
          'post_id' => $order_id,
          'action' => 'r',
          'single' => true,
        ]);
        $get_deliver_on = $meta_order->deliver_on([
          'post_id' => $order_id,
          'action' => 'r',
          'single' => true,
        ]);
        $get_time_deliver = $meta_order->time_deliver([
          'post_id' => $order_id,
          'action' => 'r',
          'single' => true,
        ]);
        $get_delivery_time = $get_delivery_time ? $get_delivery_time : WA_STORE_DELIVERY_TIME;
      ?>
      <li class="list-group-item bg-light text-dark">
        <div class="row bg-secondary text-white" data-toggle="collapse" data-target="#collapse<?php echo $order_id;?>" aria-expanded="true" aria-controls="collapse<?php echo $order_id;?>">
          <div class="col-md-2 col-sm-12">Order # <?php echo $order_id;?></div>
          <div class="col-md-5 col-sm-12">Customer : <span class="text-uppercase font-weight-bold customer"><?php echo $order->get_billing_first_name() .' '. $order->get_billing_last_name();?></span></div>
          <div class="col-md-2 col-sm-12">Deliver : <span class="text-uppercase font-weight-bold"><?php echo wa_shipping_text($order); ?></span></div>
          <div class="col-md-3 col-sm-12">Ordered On : <span class="text-uppercase font-weight-bold"><?php echo \Carbon\Carbon::parse($order->get_date_created())->diffForHumans();?></span></div>
        </div>
        <div id="collapse<?php echo $order_id;?>" class="collapse" data-parent="#new-orders">
          <div class="bg-light  text-dark">
            <div class="card-body order-list-details">
              <div class="row">
                <div class="col-md-4 col-sm-12">
                  <h6>Status : <span class="text-uppercase font-weight-bold"><?php echo $order->get_status(); ?></span></h6>
                  <h6>Deliver On : <span class="text-uppercase font-weight-bold"><?php echo $get_deliver_on;?> At  <?php echo $get_time_deliver;?></span></h6>
                  <h6>Items : <?php echo $order->get_item_count(); ?></h6>
                  <h6>Total : <span class="text-uppercase font-weight-bold"><?php echo $order->get_formatted_order_total(); ?></span></h6>
                  <h6>Notes from customer:
                    <span class=" font-weight-bold"><?php echo $order->get_customer_note(); ?></span>
                  </h6>
                </div>
                <div class="col-md-4 col-sm-12">
                  <h6>Order Items</h6>
                  <ul class="list-group list-group-flush" style="padding:10px;">
                    <?php $num = 1; ?>
                    <?php foreach ( $order->get_items() as $item ): ?>
                      <?php $formatted_meta_data = $item->get_formatted_meta_data(); ?>
                      <?php //_dd($formatted_meta_data); ?>
                      <li class="list-group-item"><?php echo $num.' - '.$item->get_name();?></li>
                      <?php if ( $formatted_meta_data ) : ?>
                        <li class="list-group-item">
                          <ul class="list-unstyled">
                            <small class="text-muted">Attributes</small>
                            <?php foreach( $formatted_meta_data as $data) : ?>
                                  <div class="attribute-products-item">
                                    <p><?php echo $data->display_key . ' : ' . wp_strip_all_tags($data->display_value);?></p>
                                  </div>
                            <?php endforeach;?>
                          </ul>
                        </li>
                      <?php endif; ?>
                      <?php $num++; ?>
                    <?php endforeach; ?>
                  </ul>
                </div>
                <div class="col-sm-12 col-md-4">

                  <h6>Customer info ( The payer ) : </h6>
                  <address>
                    <p><?php echo $order->get_formatted_billing_address(); ?></p>
                    <p><span class="font-weight-bold">E-Mail : </span><?php echo $order->get_billing_email(); ?></p>
                    <p><span class="font-weight-bold">Contact : </span><?php echo $order->get_billing_phone(); ?></p>
                  </address>
                  <?php
                    $shipping = wa_get_shipping_methods($order);
                    $local = false;
                    if ( $shipping && isset($shipping['shipping_method_id']) ) {
                      $local = $shipping['shipping_method_id'];
                    }
                  ?>
                  <?php if ( $local != 'local_pickup' ) : ?>
                    <h6>Delivery Address</h6>
                    <address>
                      <p><?php echo $order->get_formatted_shipping_address(); ?></p>
                    </address>
                  <?php endif;?>
                </div>
              </div>
              <div class="row row-list-actions">
                <div class="col-sm-12">
                    <?php
                      switch ( $status ) {
                        case 'new' :
                          ?>
                          <div class="col-sm-12">
                            <form>
                              <div class="form-group">
                                  <label for="commentWarehouse">Comment to warehouse</label>
                                  <textarea class="form-control" id="commentWarehouse" rows="3"></textarea>
                              </div>
                              <button type="button" class="btn btn-primary mb-2">Release Order</button>
                            </form>
                          </div>
                          <?php
                          break;
                        case 'released' :
                          ?><a class="button-primary" href="#" role="button">Start Order</a><?php
                          break;
                        case 'working' :
                          ?>  <a class="button-primary" href="#" role="button">Finish Order</a><?php
                          break;
                      }
                    ?>
                </div>

              </div>
            </div>
          </div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
