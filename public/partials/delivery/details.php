<h5>Delivery Details</h5>
<?php if ( wa_is_store_closed() ) : ?>
  <div class="alert alert-warning" role="alert">
    Store is close today.
  </div>
<?php else: ?>
  <div style="margin-bottom:50px;">
    <ul class="list-group">
      <li class="list-group-item">Deliver Time : <?php echo $deliver_time;?> min <input type="hidden" name="delivery_time" value="<?php echo $deliver_time;?>"></li>
      <li class="list-group-item">
        Deliver On
        <select name="deliver_on">
          <?php foreach($deliver_on as $k => $v) : ?>
            <option value="<?php echo $v;?>"><?php echo $v;?></option>
          <?php endforeach;?>
        </select>
      </li>
      <li class="list-group-item">
        Time
        <select name="time_deliver">
          <?php foreach($time_deliver as $k => $v) : ?>
            <option value="<?php echo $v;?>"><?php echo $v;?></option>
          <?php endforeach;?>
        </select>
      </li>
    </ul>
  </div>

<?php endif; ?>
