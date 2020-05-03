<?php
function wa_is_store_closed() {
  if ( wa_is_store_closed_time() ) {
    return true;
  } elseif ( wa_is_store_closed_day() ) {
    return true;
  }
  return false;
}
function wa_is_store_closed_day() {
  $store_settings = new WA_Settings_Store;
  return $store_settings->is_closed_day();
}
function wa_is_store_closed_time() {
  $store_settings = new WA_Settings_Store;
  return $store_settings->is_close_time();
}
function _dd($arr = [], $exit = false) {
  echo '<pre>';
  print_r($arr);
  echo '</pre>';
  if ( $exit ) {
    exit();
  }
}
