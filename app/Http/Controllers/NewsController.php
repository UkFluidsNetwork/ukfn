<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\News;

class NewsController extends Controller
{
    
  /**
   * Get list of news formatted and ordered by date
   * @return array
   * @access public
   * @author Javier Arias <javier@arias.re>
   */
  public function getNews() {

    $news = [];
    $newsData = News::getNews("created_at", "desc", 15);
    
    foreach($newsData as $key => $new) {
      $news[$key]['title'] = $new->title;
      $news[$key]['start'] = date("j F", strtotime($new->created_at));
      $news[$key]['description'] = $new->description; 
    }
    
    return $news;
  }
  
}
