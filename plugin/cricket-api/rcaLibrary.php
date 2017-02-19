<?php
/**
 * @package 	Cricket-API 
 * @author 		CricketAPI Developers
 * @version 	1.0.0
 * 
 * Description: This is a php library to get live cricket score, recent matches and 
 * schedules using Cricket API.
 * It also provides live cricket score for ICC, IPL, CL and CPL.
 * 
 * @link https://www.cricketapi.com/
 */

require_once 'rcaConfig.php';

function getAccessToken(){
  if($_SESSION['rcaak']){
  	return $_SESSION['rcaak'];
  }
  return false;
}

function setAccessToken(){
    $response = auth(session_id());
    $accessToken = $response['auth']['access_token'];
    $expiresIn = intval($response['auth']['expires']);

    $_SESSION['rcaak'] = $accessToken;
    $_SESSION['rcaake'] = $expiresIn;
    return $accessToken;
}

/**
* Authentication
*
* auth function
*
* This function provides you an access token by validating your request which allows you to call remaining functions.
* Call this auth function whenever your access token is expired.
*
* For more info, follow the documentation in the below URL.
* @link https://www.cricketapi.com/docs/auth_api/
*/
function auth($deviceId) {

	$rca_appconfig = get_option( 'cricketapi_app_options_info' );	
	$fields = array(
		'access_key' => $rca_appconfig['access_key'],
		'secret_key' => $rca_appconfig['secret_key'],
		'app_id' => $rca_appconfig['appid'],
		'device_id' => $deviceId,
	);	

	$fields_string = '';
	
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	$fields_string=rtrim($fields_string, '&');
	 
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, RCA_url.'auth/');
	curl_setopt($ch, CURLOPT_POST, true);
	 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	$response = json_decode($response, true);

	curl_close($ch);
	
	return $response;
}



/**
* getData function
*
* This function will build the query url for calling API.
*
* @param $req_url		Pass the desired API url value.
* @param $fields        Pass the parameters for appending to API.
*
*/
function getData($req_url, $fields){
	$url = RCA_url. $req_url. '/?' . http_build_query($fields);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_ENCODING, '');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 
	$response = curl_exec($ch);
	$response = json_decode($response, true);
	curl_close($ch);
	return $response['data'];
}



/**
* Match:
*
* getMatch function
* 
* This function provides full details of a match.
*
* @param $access_token  		Access key of your application.
* @param $match_key 			Key of match to show the Match details.
* @param $card_type (optional) 	There are three card types. 
*                       			i)   full_card (Default).
*                       			ii)  summary_card.
*									iii) micro_card.
*
* For more info, follow the documentation in the below URL.
* @link https://www.cricketapi.com/docs/match_api/
*/
function getMatch($access_token, $match_key, $card_type){
	$fields = array(
	    'access_token' => $access_token,
	    'card_type' => $card_type,
	);

	$url = 'match/' .$match_key;
	$response = getData($url, $fields);
	return $response;
}



/**
* Recent Matches:
* 
* getRecentMatch function 
*
* This function provides the recent matches for specific season.
* Usually it will give 3 completed matches, 3 upcoming matches and all live matches.
*
* @param $access_token  		Access key of your application.
* @param $season_key (optional)	Key of season to show the seasons recent matches data.
* @param $card_type (optional) 	There are three card types. 
*                       			i)   micro_card (Default).
*                       			ii)  summary_card.
*									iii) full_card (Not Supported).
*
* For more info, follow the documentation in the below URL.
* @link https://www.cricketapi.com/docs/recent_match_api/
*/
function getRecentMatch($access_token, $season_key, $card_type){

	$fields = array(
	    'access_token' => $access_token,
	    'card_type' => $card_type,
	);

	/**
	* If Season Key is passed,
	* It will get the details of recent matches in a particular season.
	* 
	* Otherwise, it will get the default recent matches information.
	*/
	if($season_key != "") {
		$url = 'season/' .$season_key .'/recent_matches';	
	} else {
		$url = 'recent_matches';
	}
	
	$response = getData($url, $fields);
	return $response;
}



/**
* Recent Seasons:
*
* getRecentSeason function
* 
* This function provides list of all recent seasons. 
* It includes seasons from last two months, current month and next month.
*
* @param $access_token  		Access key of your application.
*
* For more info, follow the documentation in the below URL.
* @link https://www.cricketapi.com/docs/recent_season_api/
*/
function getRecentSeason($access_token){
	$fields = array(
	    'access_token' => $access_token,
	);
	$url = 'recent_seasons';
	$response = getData($url, $fields);
	return $response;
}



/**
* Schedule:
*
* getSchedule function
* 
* This function provides schedule for the given month.
* By default it provides current month schedule.
* If the date is provided with the request, you will get the schedule for that particular day.
*
* @param $access_token  		Access key of your application.
* @param $date (optional) 			
*
* For more info, follow the documentation in the below URL.
* @link https://www.cricketapi.com/docs/schedule_api/		
*/
function getSchedule($access_token, $date){
	$fields = array(
	    'access_token' => $access_token,
	    'date' => $date,
	);
	$url = 'schedule';
	$response = getData($url, $fields);
	return $response;
}



/**
* Schedule(Season Based):
* 
* getSeasonSchedule function
* 
* This function provides schedule for the given season.
* By default it provides the schedule of the whole season. 
* If the date is provided with the request, you will get the schedule for that particular day.
*
* @param $access_token  		Access key of your application.
* @param $season_key			Key of season to show the particular season schedule.
* @param $formate 						
*
* For more info, follow the documentation in the below URL.
* @link https://www.cricketapi.com/docs/schedule_api/		
*/
function getSeasonSchedule($access_token, $season_key, $formate){
	$fields = array(
	    'access_token' => $access_token,
	    'formate' => $formate
	);
	$url = 'season/' .$season_key. '/schedule';
	$response = getData($url, $fields);
	return $response;
}



/**
* Season:
* 
* getSeason function 
*
* This function provides all information about a season such matches, teams, players, rounds and groups.
*
* @param $access_token  		Access key of your application.
* @param $season_key 			Key of season match to show the data.
* @param $card_type (optional) 	There are three card types. 
*                       			i)   micro_card (Default).
*                       			ii)  summary_card.
*									iii) full_card (Not supported).
*
* For more info, follow the documentation in the below URL.
* @link https://www.cricketapi.com/docs/season_api/
*/
function getSeason($access_token, $season_key, $card_type){
	$fields = array(
	    'access_token' => $access_token,
	    'card_type' => $card_type,
	);
	$url = 'season/' .$season_key;
	$response = getData($url, $fields);
	return $response;
}



/**
* Season Stats:
* 
* getSeasonStats function
*
* This function provides stats for the given season (series). It includes the following information.
* 	a) Total Number of Fours, Sixes and Runs scored in the season.
* 	b) Fielding: Most number of catches
* 	c) Batting: Best battings, Most fours, Most sixes, Most dots, Most boundries and Best battings.
*   d) Bowling: Most wickets, Most runs, Most fours, Most sixes, Most boundries and Best bowling.
*
* @param $access_token		Access key of your application.
* @param $season_key 		Key of season match to show the season stats.
* 
* For more info, follow the documentation in the below URL.
* @link https://www.cricketapi.com/docs/season_stats_api/
*/
function getSeasonStats($access_token, $season_key){
	$fields = array(
	    'access_token' => $access_token,
	);
	$url = 'season/' .$season_key. '/stats';
	$response = getData($url, $fields);
	return $response;
}



/**
* Season Points:
* 
* getSeasonPoints function
*
* This function gives points table for the given season.
*
* @param $access_token		Access key of your application.
* @param $season_key 		Key of season match to show the season points.
* 
* For more info, follow the documentation in the below URL.
* @link https://www.cricketapi.com/docs/season_points_api/
*/
function getSeasonPoints($access_token, $season_key){
	$fields = array(
	    'access_token' => $access_token,
	);
	$url = 'season/' .$season_key. '/points';
	$response = getData($url, $fields);
	return $response;
}



/**
* Season Player Stats:
* 
* getSeasonPlayerStats function
*
* This function gives stats about a player for the specified season. It includes the following information.
* 	a) Fielding: Number of catches.
* 	b) Batting: Best batting and Total Number of fours, sixes and runs scored in the season.
* 	c) Bowling: Best bowling and Total numbers boundries, runs given and total number of wickets taken.
*
* @param $access_token		Access key of your application.
* @param $season_key 		Key of season match to show the season player stats.
* @param $player_key		Key of player to show particular player stats.
*
* For more info, follow the documentation in the below URL.
* @link https://www.cricketapi.com/docs/season_points_api/
*/
function getSeasonPlayerStats($access_token, $season_key, $player_key){
	$fields = array(
	    'access_token' => $access_token,
	);

	$url = 'season/' .$season_key. '/player/'.$player_key .'/stats';
	$response = getData($url, $fields);
	return $response;
}



/**
* OversSummary:
* 
* getOversSummary function
*
* This function will provides summary of each overs in a match. 
* Its usefull for showing over comparison, score worm and other charts.
*
* @param $access_token		Access key of your application.
* @param $match_key 		Key of match to show the Overs Summary.
*
* For more info, follow the documentation in the below URL.
* @link https://www.cricketapi.com/docs/over_summary_api/
*/
function getOversSummary($access_token, $match_key){
	$fields = array(
	    'access_token' => $access_token,
	);
	$url = 'match/' .$match_key. '/overs_summary';
	$response = getData($url, $fields);
	return $response;
}



/**
* News Aggregation:
* 
* getNewsAggregation function
*
* This function provides news feed from the popular rss.
*
* @param $access_token		Access key of your application.
*
* For more info, follow the documentation in the below URL.
* @link https://www.cricketapi.com/docs/news_aggregation_api/
*/
function getNewsAggregation($access_token){
	$fields = array(
	    'access_token' => $access_token,
	);
	$url = 'news_aggregation';
	$response = getData($url, $fields);
	return $response;
}



/**
* Ball By Ball:
* 
* getBallByBall function
*
* This function provides all details about balls of requested over. 
* If the over key is not provided with request, response will have 1st over of 1st innings.
*
* @param $access_token		Access key of your application.
* @param $match_key			Key of match to show ball-by-ball details.
* @param $over_key			Over Key is a combination of {TEAM_KEY}_{INNINGS_KEY}_{OVER_NUMBER}
*
* TEAM_KEY			Match team key, possible values are 'a' and 'b'.
* INNINGS_KEY 		Key of the innings, possible values are 1,2 and superover.
* OVER_NUMBER 		Over number starts from 1.
*
* For more info, follow the documentation in the below URL.
* @link https://www.cricketapi.com/docs/ball_by_ball_api/
*/
function getBallByBall($access_token, $match_key, $over_key){
	$fields = array(
	    'access_token' => $access_token,
	);

	if($over_key != ''){
		/**
		* This url will results in particular over of that match.
		*/
		$url = 'match/' .$match_key. '/balls/' .$over_key;
	} 

	if($over_key == ''){
		/**
		* This url will results in first over of that match.
		*/
		$url = 'match/' .$match_key. '/balls';
	}
	$response = getData($url, $fields);
	return $response;
}
