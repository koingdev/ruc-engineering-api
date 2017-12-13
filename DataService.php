<?php
  /* -----------------------
   * @author Sea Saingkoing
   * @fb facebook.com/sskdev
   * -----------------------
   * if client request with param page
   * if exist, get the value of param page and pass to $page
   */
  if(isset($_GET['page'])) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }
  /*
   * include the needed class or library
   */
  include('../Model/RiseUp.php');
  include('../Libraries/simple_html_dom.php');
  define('MAIN_URL', 'http://ruc.r-up.jp');

  class DataService {
    /*
     * each constant equals url path to each category
     */
    const ANDROID  = MAIN_URL . '/category/mobile/page/';
    const API      = MAIN_URL . '/category/api/page/';
    const CMS      = MAIN_URL . '/category/web/cms/page/';
    const CONCEPT  = MAIN_URL . '/category/concept/page/';
    const DB       = MAIN_URL . '/category/web/webdevelopment/page/';
    const IOS      = MAIN_URL . '/category/ios/page/';
    const NEWS     = MAIN_URL . '/category/news/page/';
    const TOOL     = MAIN_URL . '/category/tool/page/';
    const UIUX     = MAIN_URL . '/category/web/webdesign/page/';
    const WEB      = MAIN_URL . '/category/web/page/';
    /*
     * method that does the scraping logic (extract data)
     * it has two param: $urlParam and $arrParam
     * $urlParam: link to each category
     * $arrParam: array for storing each category content
     */
    public static function retrieveData($urlParam, $arrParam) {
      global $page;
      $urlParam = $urlParam . $page;
      $html = file_get_html($urlParam);
      if(!empty($html)) {
        $doc = $html->find('div.post');
        foreach($doc as $d){
          $myData = new RiseUp();
          //if data exists in website, then extract title and pass into $myData->title
          $title = $d->find('h2.title');
          if($title) {
            $myData->title = trim($title[0]->plaintext);
          }
          //if data exists in website, then extract url and pass into $myData->url
          $url = $d->find('a');
          if($url) {
            $myData->url = trim($url[0]->getAttribute('href'));
          }
          //if data exists in website, then extract image link and pass into $myData->image
          $image = $d->find('img');
          if($image) {
            $myData->image = trim($image[0]->getAttribute('src'));
          }
          //if data exists in website, then extract author and pass into $myData->author
          $author = $d->find('span.theauthor > a');
          if($author) {
            $myData->author = trim($author[0]->plaintext);
          }
          //if data exists in website, then extract date and pass into $myData->date
          $date = $d->find('span.thetime');
          if($date) {
            $myData->date = trim($date[0]->plaintext);  
          }
          //create array to store value of each object
          $arrParam[] = $myData;
        }
      }
      /*
       * convert array of RiseUp object to JSON object 
       * and output to user in JSON format (generate JSON for client)
       */
      $myJSON = json_encode($arrParam, JSON_UNESCAPED_SLASHES);
      echo $myJSON;
    }
  }
?>



