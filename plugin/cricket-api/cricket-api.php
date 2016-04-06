<?php
/**
 * @package   Cricket-API
 * @author    CricketAPI Developers
 * @version   1.0.0
 */

/**
* Plugin Name: Cricket Scorecard from CricketAPI
* Plugin URI: http://static.litzscore.com/plugins/wordpress/cricket-litzscore
* Description: Show live cricket score, recent matches and schedules. Litzscore provides live cricket score for ICC, IPL, CL and CPL.
* Author: CricketAPI Developers
* Version: 1.0
* Author URI: http://cricketapi.com/
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
}

function insert_header_script(){
  wp_enqueue_style('roboto-font-css');
  wp_enqueue_style('bootsrap-css');
  wp_enqueue_style('rca-css');
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

/**
 * Helper functions for Shortcodes Starts Here
 */
function rcamatch_request(){
  $ak = getAccessToken();

  if($ak){
    $matchKey = $_REQUEST['key'];
    $matchData = getMatch($matchKey, 'full_card');
    wp_send_json(array('data'=>$matchData));
    exit();
  } else {
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      rcamatch_request();
    }else{
      die('Error');
    }
  }
}

function get_ballbyball_data($matchKey, $overKey){
  $ak = getAccessToken();
  if($ak){
    $ballbyball_data = getBallByBall($matchKey, $overKey);
    return $ballbyball_data;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_ballbyball_data($matchKey, $overKey);
    }else{
      die('Error while getting BallByBall information');
    }
  } 
}

function rcarecentmatch_request(){
  $ak = getAccessToken();
  if($ak){
    $seasonKey = $_REQUEST['key'];
    $matchData = getRecentMatch($seasonKey, 'micro_card');

    wp_send_json(array('data'=>$matchData));
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

function get_recent_season_data(){
  $ak = getAccessToken();
  if($ak){
    $recent_season_data = getRecentSeason();
    return $recent_season_data;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_recent_season_data();
    }else{
      die('Error while getting Recent Season information');
    }
  }
}

function get_schedule_data($date){
  $ak = getAccessToken();
  if($ak){
    $schedule_data = getSchedule($date);
    return $schedule_data;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_schedule_data();
    }else{
      die('Error while getting Schedule information');
    }
  }
}

function get_schedule_season_data($seasonKey){
  $ak = getAccessToken();
  if($ak){
    $schedule_season_data = getSeasonSchedule($seasonKey);
    return $schedule_season_data;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_schedule_season_data($seasonKey);
    }else{
      die('Error while getting Season Schedule information');
    }
  }
}

function get_player_stats_data($playerKey, $leagueKey){
  $ak = getAccessToken();
  if($ak){
    $player_stats = getPlayerStats($playerKey, $leagueKey);
    return $player_stats;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_player_stats_data($playerKey, $leagueKey);
    }else{
      die('Error while getting Player Stats information');
    }
  }
}

function get_season_data($seasonKey){
  $ak = getAccessToken();
  if($ak){
    $season = getSeason($seasonKey, 'summary_card');
    return $season;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_season_data($seasonKey);
    }else{
      die('Error while getting Season information');
    }
  }
}

function get_season_stats_data($seasonKey){
  $ak = getAccessToken();
  if($ak){
    $season_stats = getSeasonStats($seasonKey);
    return $season_stats;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_season_stats_data($seasonKey);
    }else{
      die('Error while getting Season Stats information');
    }
  }
}

function get_season_points_data($seasonKey){
  $ak = getAccessToken();
  if($ak){
    $season_points = getSeasonPoints($seasonKey);
    return $season_points;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_season_points_data($seasonKey);
    }else{
      die('Error while getting Season Points information');
    }
  }
}

function get_seasonteam_data($seasonKey, $teamKey, $statsType){
  $ak = getAccessToken();
  if($ak){
    $seasonteam = getSeasonTeam($seasonKey, $teamKey, $statsType);
    return $seasonteam;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_seasonteam_data($seasonKey, $teamKey, $statsType);
    }else{
      die('Error while getting Season Team information');
    }
  }
}

function get_over_summary_data($matchKey){
  $ak = getAccessToken();
  if($ak){
    $over_summary = getOversSummary($matchKey);
    return $over_summary;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_over_summary_data($matchKey);
    }else{
      die('Error while getting Overs Summary information');
    }
  }
}

function get_news_aggregation_data(){
  $ak = getAccessToken();
  if($ak){
    $news_aggregation_data = getNewsAggregation();
    return $news_aggregation_data;
  }else{
    setAccessToken();
    $ak = getAccessToken();
    if($ak){
      return get_news_aggregation_data();
    }else{
      die('Error while getting News Aggregation information');
    }
  } 
}
/**
 * Helper functions for Shortcodes Ends Here
 */


function rcaInit(){
    insert_header_script();
    insert_script_src();
    insert_footer_script();
}

function rcaMatch($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'key' => 'null',
                'card_type' =>'null'),
                $attrs, 'rcamatch' );

  if($attrs['key'] && !is_null($attrs['key'])){
    $matchKey = $attrs['key'];
  }else{
    $matchKey = get_query_var('rca_matchkey');
  }

  $nonceValue = wp_create_nonce( 'rcaapiactionsmatch' );
  echo '
          <div ng-app="rcaCricket">
            <div class="lz-outter-box" rca-cricket-match="'.$matchKey.'" sec="'.$nonceValue.'"></div>
          </div>
        ';
}

function rcaMatchPromo($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'key' => 'null',
                'card_type' =>'null'),
                $attrs, 'rcamatchpromo' );

  if($attrs['key'] && !is_null($attrs['key'])){
    $matchKey = $attrs['key'];
  }else{
    $matchKey = get_query_var('rca_matchkey');
  }

  $nonceValue = wp_create_nonce( 'rcaapiactionsmatch' );
  echo '
          <div ng-app="rcaCricket">
            <div class="lz-outter-box" rca-cricket-match-promo="'.$matchKey.'" sec="'.$nonceValue.'"></div>
          </div>
        ';
}

function rcaBallByBall($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                    'matchkey' => 'null',
                    'overkey' => 'null'),
                    $attrs, 'rcaballbyball');

  $matchKey = $attrs['matchkey'];
  $overKey = $attrs['overkey'];

  $ballbyballData = get_ballbyball_data($matchKey, $overKey);

  include_once 'views/rca-cricket-season-test.php';
}

function rcaRecentMatch($attrs) {
  rcaInit();
  $attrs = shortcode_atts(array(
                'key' => 'null',
                'card_type' => 'null'),
                $attrs, 'rcarecentmatch');

  $seasonKey = $attrs['key'];

  $nonceValue = wp_create_nonce('rcaapiactionsmatch');
  echo '
        <div ng-app="rcaCricket">
          <div class="lz-outter-box '. $attrs['theme'] .'" rca-cricket-recent-match="'.$seasonKey.'" sec="'.$nonceValue.'"></div>
          </div>
        </div>
       ';
}

function rcaRecentSeason($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(),
                  $attrs, 'rcarecentseason');

  $recentSeasonData = get_recent_season_data();

  include_once 'views/rca-cricket-recent-season.php';
}

function rcaSchedule($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'date' => 'null'),
                $attrs, 'rcaschedule');

  $date = $attrs['date'];

  $scheduleData = get_schedule_data($date);

  include_once 'views/rca-cricket-schedule.php';
}

function rcaScheduleSeason($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                  'key' => 'null'),
                  $attrs, 'rcascheduleseason');

  $seasonKey = $attrs['key'];

  $scheduleseasonData = get_schedule_season_data($seasonKey);

  include_once 'views/rca-cricket-schedule.php';
}

function rcaPlayerStats($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'playerkey' => 'null',
                'leaguekey' => 'null'),
                $attrs, 'rcaplayerstats');

  $leagueKey = $attrs['leaguekey'];
  $playerKey = $attrs['playerkey'];
  
  $playerstatsData = get_player_stats_data($playerKey, $leagueKey);

  include_once 'views/rca-cricket-season-test.php';
}

function rcaSeason($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'key' => 'null',
                'card_type' =>'null',
                'match_page_id'=>null),
                $attrs, 'rcaseasons');

  $seasonKey = $attrs['key'];
  $seasonData = get_season_data($seasonKey);
  $matchUrlPrefix = get_site_url().'/';

  if(!is_null($attrs['match_page_id'])){
    $matchUrlPrefix = $matchUrlPrefix . $attrs['match_page_id'] . '/';
  }

  include_once 'views/rca-cricket-season.php';
}

function rcaSeasonStats($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'key' => 'null'),
                $attrs, 'rcaseasonstats');

  $seasonKey = $attrs['key'];
  $seasonstatsData = get_season_stats_data($seasonKey);

  include_once 'views/rca-cricket-season-test.php';
}

function rcaSeasonPoints($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'key' => 'null'),
                $attrs, 'rcaseasonpoints');

  $seasonKey = $attrs['key'];
  $seasonpointsData = get_season_points_data($seasonKey);

  include_once 'views/rca-cricket-season-test.php';
}

function rcaSeasonTeam($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                    'seasonkey' => 'null',
                    'teamkey' => 'null',
                    'statstype' => 'null'),
                    $attrs, 'rcaseasonteam');

  $seasonKey = $attrs['seasonkey'];
  $teamKey = $attrs['teamkey'];
  $statsType = $attrs['statstype'];

  $seasonteamData = get_seasonteam_data($seasonKey, $teamKey, $statsType);

  include_once 'views/rca-cricket-season-test.php';
}

function rcaOverSummary($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(
                'key' => 'null'),
                $attrs, 'rcaoversummary');

  $matchKey = $attrs['key'];

  $oversummaryData = get_over_summary_data($matchKey);

  include_once 'views/rca-cricket-season-test.php';
}

function rcaNewsAggregation($attrs){
  rcaInit();
  $attrs = shortcode_atts(array(),
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

  add_rewrite_rule('^$base_url/([0-9]+)/([^/]*)/?','index.php?page_id=$matches[1]&rca_matchkey=$matches[2]','top');

  $page = get_page_by_title( 'Matches' );
  $pageId = null;
  if($page){
    $pageId = $page->ID;
  }

  add_rewrite_rule('^$base_url/([^/]*)/?','index.php?page_id='.$pageId.'&rca_matchkey=$matches[1]','top');
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
add_shortcode('rcamatch', 'rcaMatch');
add_shortcode('rcaballbyball', 'rcaBallByBall');
add_shortcode('rcarecentmatch', 'rcaRecentMatch');
add_shortcode('rcarecentseason', 'rcaRecentSeason');
add_shortcode('rcaschedule', 'rcaSchedule');
add_shortcode('rcascheduleseason', 'rcaScheduleSeason');
add_shortcode('rcaseason', 'rcaSeason');
add_shortcode('rcaseasonstats', 'rcaSeasonStats');
add_shortcode('rcaseasonpoints', 'rcaSeasonPoints');
add_shortcode('rcaseasonteam', 'rcaSeasonTeam');
add_shortcode('rcaplayerstats', 'rcaPlayerStats');
add_shortcode('rcaoversummary', 'rcaOverSummary');
add_shortcode('rcanewsaggregation', 'rcaNewsAggregation');

// Beta Shortcode
add_shortcode('rcamatchpromo', 'rcaMatchPromo');


add_action( 'wp_ajax_rcamatch', 'rcamatch_request' );
add_action( 'wp_ajax_nopriv_rcamatch', 'rcamatch_request' );
add_action( 'wp_ajax_rcarecentmatch', 'rcarecentmatch_request' );
add_action( 'wp_ajax_nopriv_rcarecentmatch', 'rcarecentmatch_request' );
add_action( 'wp_ajax_rcamatchpromo', 'rcamatch_request' );
add_action( 'wp_ajax_nopriv_rcamatchpromo', 'rcamatch_request' );

wp_register_script('angular', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js');
wp_register_script('angular-animate', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-animate.min.js');
wp_register_script('moment', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js');

wp_register_style('roboto-font-css', 'https://fonts.googleapis.com/css?family=RobotoDraft:300,400,500,700,400italic');
wp_register_style('bootsrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css');

$plugin_url = plugin_dir_url( __FILE__ );
wp_register_script('rca-js', $plugin_url. '/views/rca-cricket-angular.js');

wp_register_style('rca-css', $plugin_url . '/views/rca-cricket.css');

if (is_admin())
  $cricketapi_admin = new CricketApiAdmin();
