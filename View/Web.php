<?php 
  /* -----------------------
   * @author Sea Saingkoing
   * @fb facebook.com/sskdev
   * -----------------------
   */
  include('../DataService.php');
  $arr = array();
  DataService::retrieveData(DataService::WEB, $arr);
?>