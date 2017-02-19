<?php
/**
 * @package   Cricket-API
 * @author    CricketAPI Developers
 * @version   2.0.0
 */

/**
 * Plugin Name: Cricket API Scores Plugin
 * Plugin URI: https://github.com/roanuz/cricket-wordpress
 * Description:  This plugin provides Live Cricket scores, Recent matches, Season based matches, Cricket Schedules, etc from Cricket API. It also provides live cricket scores for ICC, IPL, CL and CPL.
 * Author: CricketAPI Developers
 * Version:  2.0.0
 * Author URI: https://www.cricketapi.com/
 */

require_once 'rcaConfig.php';
require_once 'rcaLibrary.php';
require_once 'cricket-api-admin.php';

if(!session_id()){
  session_start();
}

$RCA_FLAGS_MAPPING = array(
);

$RCA_IMAGE_URL = 'http://img.litzscore.com/flags/%s_s.png';

function insert_footer_script(){
  wp_enqueue_script('angular');
  wp_enqueue_script('angular-animate');
  wp_enqueue_script('moment');
  wp_enqueue_script('rca-js');
  wp_enqueue_script('fullcalendar-js');
}

function insert_header_script(){
  wp_enqueue_style('lato-font-css');
  wp_enqueue_style('rca-css');
  wp_enqueue_style('fullcalender-min-css');
  wp_enqueue_style('fullcalender-print-css');
}

function insert_script_src() {
  global $RCA_FLAGS_MAPPING;
  $plugin_url = plugin_dir_url( __FILE__ );
  // $nonce_value = wp_create_nonce( 'rcaapiactions' );

  wp_localize_script( 'rca-js', 'RCACONFIG', array(
    'ajaxUrl' => admin_url( 'admin-ajax.php' ),
    'templateUrl' => $plugin_url.'views/',
    // 'nonce' => $nonce_value,
    'flags' => $RCA_FLAGS_MAPPING,
  ));
}

function get_ballbyball_data($matchKey, $overKey){
  $ak = getAccessToken();
  if($ak){
    $ballbyball_data = getBallByBall($ak, $matchKey, $overKey);
    return $ballbyball_data;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_ballbyball_data($matchKey, $overKey);
    }else{
      die('Error while getting season information');
    }
  } 
}

function get_recent_season_data(){
  $ak = getAccessToken();
  if($ak){
    $recent_season_data = getRecentSeason($ak);
    return $recent_season_data;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_recent_season_data();
    }else{
      die('Error while getting season information');
    }
  }
}

function get_schedule_data(){
  $ak = getAccessToken();
  if($ak){
    $schedule_data = getSchedule($ak);
    return $schedule_data;
    print_r($ak);
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_schedule_data();
    }else{
      die('Error while getting season information');
    }
  }
}

function get_schedule_date($date){
  $ak = getAccessToken();
  if($ak){
    $schedule_date = getSchedule($ak, $date);
    return $schedule_date;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_schedule_date($date);
    }else{
      die('Error while getting season information');
    }
  }
}

function get_schedule_season_data($seasonKey){
  $ak = getAccessToken();
  if($ak){
    $schedule_season_data = getSeasonSchedule($ak, $seasonKey);
    return $schedule_season_data;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_schedule_season_data($seasonKey);
    }else{
      die('Error while getting season information');
    }
  }
}



function get_season_stats_data($seasonKey){
  $ak = getAccessToken();
  if($ak){
    $season_stats = getSeasonStats($ak, $seasonKey);
    return $season_stats;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_season_stats_data($seasonKey);
    }else{
      die('Error while getting season information');
    }
  }
}

function get_season_points_data($seasonKey){
  $ak = getAccessToken();
  if($ak){
    $season_points = getSeasonPoints($ak, $seasonKey);
    return $season_points;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_season_points_data($seasonKey);
    }else{
      die('Error while getting season information');
    }
  }
}

function get_player_stats_data($seasonKey, $playerKey){
  $ak = getAccessToken();
  if($ak){
    $player_stats = getSeasonPlayerStats($ak, $seasonKey, $playerKey);
    return $player_stats;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_player_stats_data($seasonKey, $playerKey);
    }else{
      die('Error while getting season information');
    }
  }
}

function get_over_summary_data($matchKey){
  $ak = getAccessToken();
  if($ak){
    $over_summary = getOversSummary($ak, $matchKey);
    return $over_summary;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_over_summary_data($matchKey);
    }else{
      die('Error while getting season information');
    }
  }
}

function get_news_aggregation_data(){
  $ak = getAccessToken();
  if($ak){
    $news_aggregation_data = getNewsAggregation($ak);
    return $news_aggregation_data;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_news_aggregation_data();
    }else{
      die('Error while getting season information');
    }
  } 
}

function rcaseason_request(){
  $ak = getAccessToken();
  if($ak){
    $seasonKey = $_REQUEST['key'];
    $seasonData = getSeason($ak, $seasonKey, 'summary_card');
    
    wp_send_json(array('data'=>$seasonData));
    exit();
  }else{
    setAccessToken();
    $ak = getAccessToken();

    if($ak){
      rcaseason_request();
    }else{
      die('Error while getting season information');
    }

  }
}

function rcamatch_request(){
  $ak = getAccessToken();
  if($ak){
    $matchKey = $_REQUEST['key'];
    $matchData = getMatch($ak, $matchKey, 'full_card');

    wp_send_json(array('data'=>$matchData));
    exit();
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      rcamatch_request();
    }else{
      die('Error');
    }
  }
}

function rcarecentmatch_request(){
  $ak = getAccessToken();
  if($ak){
    $seasonKey = $_REQUEST['key'] == "null" ? '' : $_REQUEST['key'];
    $recentMatchData = getRecentMatch($ak, $seasonKey, 'summary_card');

    wp_send_json(array('data'=>$recentMatchData));
    exit();
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      rcarecentmatch_request();
    }else{
      die('Error');
    }
  }
}

function rcaInit(){
    insert_header_script();
    insert_script_src();
    insert_footer_script();
}

function rcaMatch($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'key' => null,
                'card_type' =>'null',
                'theme' => 'lz-theme-green-red'),
                $attrs, 'rcamatch' );

  if($attrs['key'] && !is_null($attrs['key'])){
    $matchKey = $attrs['key'];
  }else{
    $matchKey = get_query_var('rca_matchkey');
  }
  $pageView = "match";
  $nonceValue = wp_create_nonce( 'rcaapiactionsmatch' );
  echo '
        <div ng-app="rcaCricket">
          <div class="lz-outter-box '. $attrs['theme'] .'" rca-cricket-match='.$matchKey.' sec='.$nonceValue.' page-view='.$pageView.'></div>
        </div>
      ';
}

function rcaSeason($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'key' => 'null',
                'card_type' =>'micro_card',
                'theme' => 'lz-theme-green-red',
                'match_page_id'=>null),
                $attrs, 'rcaseasons');

  $seasonKey = $attrs['key'];
  $nonceValue = wp_create_nonce('rcaapiactionsmatch');

  $pageView = "seasonmatches";

  echo '
        <div ng-app="rcaCricket">
          <div class="lz-outter-box '. $attrs['theme'] .'" rca-season-matches='.$seasonKey.' sec='.$nonceValue.' page-view='.$pageView.'></div>
        </div>
      ';
}

function rcaRecentMatch($attrs) {
  rcaInit();
  $attrs = shortcode_atts(array(
                'key' => 'null',
                'theme' => 'lz-theme-green-red'),
                $attrs, 'rcarecentmatch');

  
  $seasonKey = $attrs['key'];
  
  $nonceValue = wp_create_nonce('rcaapiactionsmatch');

  $pageView = "recentmatches";

  echo '
        <div ng-app="rcaCricket">
          <div class="lz-outter-box '. $attrs['theme'] .'" rca-recent-matches='.$seasonKey.' sec='.$nonceValue.' page-view='.$pageView.'></div>
        </div>
       ';
}

function rcaBallByBall($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                    'matchkey' => 'null',
                    'overkey' => 'null',
                    'theme' => 'lz-theme-green-red'),
                    $attrs, 'rcaballbyball');

  $matchKey = $attrs['matchkey'];
  $overKey = $attrs['overkey'];

  $ballbyballData = get_ballbyball_data($matchKey, $overKey);

  include_once 'views/rca-cricket-season-test.php';
}

function rcaRecentSeasons($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                  'theme' => 'lz-theme-green-red'),
                  $attrs, 'rcarecentseasons');

  $recentSeasons =  get_recent_season_data();

  include_once 'views/rca-cricket-recent-seasons.php';
}

function rcaSchedule($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'theme' => 'lz-theme-green-red'),
                $attrs, 'rcaschedule');

  $scheduleData = get_schedule_data();

  include_once 'views/rca-cricket-schedule.php';
}

function rcaScheduleSeason($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                  'key' => 'null',
                  'theme' => 'lz-theme-green-red'),
                  $attrs, 'rcascheduleseason');

  $seasonKey = $attrs['key'];

  $scheduleseasonData = get_schedule_season_data($seasonKey);

  include_once 'views/rca-cricket-season-test.php';
}

function rcaSeasonStats($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'key' => 'null',
                'theme' => 'lz-theme-green-red'),
                $attrs, 'rcaseasonstats');

  $seasonKey = $attrs['key'];
  $seasonstatsData = get_season_stats_data($seasonKey);

  include_once 'views/rca-cricket-season-test.php';
}

function rcaSeasonPoints($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'key' => 'null',
                'theme' => 'lz-theme-green-red'),
                $attrs, 'rcaseasonpoints');

  $seasonKey = $attrs['key'];
  $seasonpointsData = get_season_points_data($seasonKey);

  include_once 'views/rca-cricket-season-test.php';
}

function rcaPlayerStats($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'seasonkey' => 'null',
                'playerkey' => 'null',
                'theme' => 'lz-theme-green-red'),
                $attrs, 'rcaplayerstats');

  $seasonKey = $attrs['seasonkey'];
  $playerKey = $attrs['playerkey'];
  
  $playerstatsData = get_player_stats_data($seasonKey, $playerKey);

  include_once 'views/rca-cricket-season-test.php';
}

function rcaOverSummary($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'key' => 'null',
                'theme' => 'lz-theme-green-red'),
                $attrs, 'rcaoversummary');

  $matchKey = $attrs['key'];

  $oversummaryData = get_over_summary_data($matchKey);

  include_once 'views/rca-cricket-season-test.php';
}

function rcaNewsAggregation($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                    'theme' => 'lz-theme-green-red'),
                    $attrs, 'rcanewsaggregation');

  $newsaggregationData = get_news_aggregation_data();

  include_once 'views/rca-cricket-season-test.php';
}

function rcaGetTeamLogoUrl($key){
  global $RCA_FLAGS_MAPPING;
  global $RCA_IMAGE_URL;

  if(array_key_exists($key, $RCA_FLAGS_MAPPING)){
    return $RCA_FLAGS_MAPPING[$key];
  }
  return sprintf($RCA_IMAGE_URL, $key);
}

function add_rca_query_vars( $qvars ) {
  $qvars[] = 'rca_matchkey';
  return $qvars;
}

function custom_rca_rewrite_rule() {

  add_rewrite_rule('^matches/([0-9]+)/([^/]*)/?','index.php?page_id=$matches[1]&rca_matchkey=$matches[2]','top');

  $page = get_page_by_title( 'Matches' );
  $pageId = null;
  if($page){
    $pageId = $page->ID;
  }

  add_rewrite_rule('^matches/([^/]*)/?','index.php?page_id='.$pageId.'&rca_matchkey=$matches[1]','top');
}

add_action('query_vars', 'add_rca_query_vars');
add_action('init', 'custom_rca_rewrite_rule', 10, 0);


/**
* List of available shortcodes.
* 
* @param $tag (string)     Shortcode tag to be searched in post content
* @param $func (callable)   Hook to run when shortcode is found
*
*
* <code>
*   <?php add_shortcode($tag , $func); ?>
* </code>
*
*/

// Match & Recent Based Shortcodes
add_shortcode('rcamatch', 'rcaMatch');
add_shortcode('rcarecentmatch', 'rcaRecentMatch');
add_shortcode('rcaballbyball', 'rcaBallByBall');
add_shortcode('rcarecentseasons', 'rcaRecentSeasons');

// Schedule Based Shortcodes
add_shortcode('rcaschedule', 'rcaSchedule');
add_shortcode('rcascheduleseason', 'rcaScheduleSeason');

// Season Based Shortcodes
add_shortcode('rcaseason', 'rcaSeason');
add_shortcode('rcaseasonstats', 'rcaSeasonStats');
add_shortcode('rcaseasonpoints', 'rcaSeasonPoints');
add_shortcode('rcaplayerstats', 'rcaPlayerStats');
add_shortcode('rcaoversummary', 'rcaOverSummary');

// News Feed Shortcodes
add_shortcode('rcanewsaggregation', 'rcaNewsAggregation');


add_action( 'wp_ajax_rcamatch', 'rcamatch_request' );
add_action( 'wp_ajax_nopriv_rcamatch', 'rcamatch_request' );

add_action( 'wp_ajax_rcaseasons', 'rcaseason_request' );
add_action( 'wp_ajax_nopriv_rcaseasons', 'rcaseason_request' );

add_action( 'wp_ajax_rcarecentmatch', 'rcarecentmatch_request' );
add_action( 'wp_ajax_nopriv_rcarecentmatch', 'rcarecentmatch_request' );

wp_register_script('angular', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js');
wp_register_script('angular-animate', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-animate.min.js');
wp_register_script('moment', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js');
wp_register_script('fullcalendar-js', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.min.js');

wp_register_style('lato-font-css', 'https://fonts.googleapis.com/css?family=Lato');
wp_register_style('fullcalender-min-css', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.min.css');
wp_register_style('fullcalender-print-css', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.print.css');
// wp_register_style('calender-theme', 'https://s3-ap-southeast-1.amazonaws.com/cricketapi-widgets/css/black_theme.css');

$plugin_url = plugin_dir_url( __FILE__ );
wp_register_script('rca-js', $plugin_url. '/views/rca-cricket-angular.js');
wp_register_style('rca-css', $plugin_url . '/views/themes/greenTheme.css');


// function use_less_css() {
//   $plugin_url = plugin_dir_url( __FILE__ );
//   echo '
//     <link rel="stylesheet/less" type="text/css" href="'.$plugin_url.'/less/rca-cricket.less">
//     <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.5.1/less.min.js" type="text/javascript"></script>
//     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
//   ';
// }
// add_action( 'wp_head' , 'use_less_css' );

if (is_admin())
  $cricketapi_admin = new CricketApiAdmin();
