<?php
  $match_time = strtotime($seasonData['season']['start_date']['iso']);
  $match_year = date('Y', $match_time);
?>
  <section id="<?php echo $seasonData['season']['series'].'_'.$match_year; ?>">
  <?php foreach ($seasonData['season']['matches'] as $key => $match) :?>
  <section id="<?php echo $match['key']; ?>">
    <div class="rca-column-6">

      <!-- Date Conversions -->
      <?php 
        $dateIso = $match['start_date']['iso'];
        $time = strtotime($match['start_date']['iso']);
        $top_time = date('jS M Y', $time);
        $dateStr = date('F jS Y \a\t g:ia', $time);
      ?>

      <!--Match Not Started -->
      <?php if($match['status'] == 'notstarted'): ?>

        <div class="rca-medium-widget rca-padding rca-completed-match rca-top-border">
          <a href="<?php echo $matchUrlPrefix. $match['key'] . '/' ?>">
            <div class="rca-right rca-basic-text"><?php echo $top_time; ?></div>
            <div class="rca-clear"></div>

            <div class="rca-padding">       
              <h3 class="rca-match-title rca-theme-text">
                <span><?php echo strtoupper($match['teams']['a']['key']); ?></span>
                <span>VS</span>
                <span><?php echo strtoupper($match['teams']['b']['key']); ?></span>
              </h3>
              <p class="rca-match-info">
                <span><?php echo $match['season']['name']?></span>
              </p>
              <div class="rca-top-padding">
                <div class="rca-teams rca-table">
                  <div class="team rca-cell"><?php echo $match['teams']['a']['name']; ?></div>
                  <div class="rca-vs rca-cell"></div>
                  <div class="team rca-cell"><?php echo $match['teams']['b']['name']; ?></div>
                </div>
              </div>

              <?php
                $current_time = new DateTime('now');
                $match_time = new DateTime($dateIso);
                $interval = $current_time->diff($match_time);

                if($interval->d < 1){ // If Match Starts Within One Day

                  // Show the Match start duration in Hrs & Mins format
                  if($interval->h > 1){
                    $match_start = $interval->h .' hour'. ($interval->h >1 ? "s" : '');
                  }
                    $match_start .= '  '.$interval->i .' minute'. ($interval->i >1 ? "s" : '');
                } elseif($interval->i < 1){
                  $match_start = $interval->s .' sec'. ($interval->s > 1 ? "s" : '');
                } else{
                 // Otherwise Show the Days Duration
                  $match_start = $interval->d .' day'. ($interval->d > 1 ? "s" : '');
                }
              ?>
              <div class="rca-match-start">
                <h3>Starts in</h3>
                <div class="rca-padding">
                  <h2><?php echo $match_start; ?></h2>                  
                  <p class="rca-center" data-convert-to-local-time="<?php echo $dateIso ?>"><?php echo $dateStr; ?>(local time)</p>
                </div>
              </div>

            </div>  
          </a>    
        </div>

      <?php endif; ?>


      <!-- Match Started -->
      <?php if($match['status'] == 'started'): ?>

        <div class="rca-medium-widget rca-padding started rca-top-border">
          <a href="<?php echo $matchUrlPrefix. $match['key'] . '/' ?>">
            <div class="rca-live-label rca-right">
              <span><?php echo strtoupper($match['teams']['a']['key']); ?></span>
              <span>vs</span>
              <span><?php echo strtoupper($match['teams']['b']['key']); ?></span>
            </div>
            <div class="rca-clear"></div>
            <div class="rca-padding">       
              <h3 class="rca-match-title">
                <?php 
                  $batting_team = $match['now']['batting_team']; 
                  echo $match['teams'][$batting_team]['short_name'].':'.$match['now']['runs_str'];
                ?>
              </h3>
              <p class="rca-match-info">
                <span>CRR:<?php echo $match['now']['run_rate']; ?></span>
                <span>
                  <?php if($match['now']['req']): ?>
                    <?php echo 'Req RR:' .$match['now']['req']['runs_rate']; ?>
                  <?php endif; ?>
                </span>
              </p>
              <p class="rca-match-info">
                <?php 
                  $bowling_team = $match['now']['bowling_team'];
                  $innings = $match['now']['innings'];

                  $first_batting_team_score = $bowling_team.'_'.$innings;
                ?>
                <span>
                  <?php echo $match['teams'][$bowling_team]['short_name'] .': '. $match['innings'][$first_batting_team_score]['run_str']; ?>
                </span>
              </p>
              <div class="rca-top-padding">
                <div class="rca-batsman striker">
                  <span class="player">
                    <?php 
                      $striker = $match['now']['striker'];

                      if($striker){
                        echo $match['players'][$striker]['name'];
                      } else {
                        echo 'Waiting for Batsman';
                      }
                    ?>
                  </span>

                  <?php 
                    $player_active = $match['players'][$striker]['match']['innings'];
                    $striker_runs = $player_active[$innings]['batting']['runs'] ?: '0';
                    $striker_balls = $player_active[$innings]['batting']['balls'] ?: '0';
                   ?>
                  <span>
                    <?php 
                      echo $striker_runs.'('.$striker_balls.')';
                    ?>
                  </span>
                </div>
                <div class="rca-batsman">
                  <span class="player">
                    <?php
                      $non_striker = $match['now']['nonstriker'];

                      if($non_striker){
                        echo $match['players'][$non_striker]['name'];
                      } else {
                        echo 'Waiting for Batsman';
                      }
                    ?>
                  </span>

                  <?php 
                    $player_inactive = $match['players'][$non_striker]['match']['innings'];
                    $nonstriker_runs = $player_inactive[$innings]['batting']['runs'] ?: '0';
                    $nonstriker_balls = $player_inactive[$innings]['batting']['balls'] ?: '0';
                  ?>
                  <span>
                    <?php 
                      echo $nonstriker_runs.'('.$nonstriker_balls. ')';
                    ?>
                  </span>
                </div>
              </div>

              <?php 
                $balls = $match['now']['balls'];
                $overs = (int)($balls / 6.0) + .1 * ( $balls % 6);
              ?>
              <div class="rca-ball-detail">
                <div class="rca-match-schedule">
                  Over: <?php echo $overs; ?>
                </div>
            
                <ul class="rca-ball-by">
                  <?php $over_str = $match['now']['recent_overs_str'][0][1]; ?>
                  <?php foreach($over_str as $key => $ball_state): ?>
                    <?php if($ball_state): ?>
                      <?php 
                          $ball = strtr($ball_state, array(
                                          "e1,wd" => "1wd",
                                          "e2,wd" => "2wd",
                                          "e3,wd" => "3wd",
                                          "b4;e1,nb" => "4 & 1nb",
                                          "e4,lb" => "4 lb",
                                          "b" => "",
                                          "r" => "")); ?>
                    <?php else: ?>
                      <?php $ball = $ball_state; ?>

                    <?php endif; ?>

                      <li class="<?php echo $ball_state; ?>"><?php echo $ball; ?></li>
                      
                  <?php endforeach; ?>
                </ul>

                <div class="rca-bowler-info">
                <?php 
                  $bowler = $match['now']['bowler'];
                  $bowler_runs = $match['players'][$bowler]['match']['innings'][$innings]['bowling']['runs'];
                  $bowler_wickets = $match['players'][$bowler]['match']['innings'][$innings]['bowling']['wickets'];
                  $bowler_overs = $match['players'][$bowler]['match']['innings'][$innings]['bowling']['overs'];
                ?>
                  <span>
                    <?php 
                      if($bowler) {
                          echo $match['players'][$bowler]['name'];
                    ?>
                      : </span><span class="rca-bolwing">
                       <?php echo $bowler_runs.'/'.$bowler_wickets. ' in ' .$bowler_overs; ?> 
                      </span>
                    <?php 
                        } else {
                          echo 'Waiting for Bowler';
                          }
                     ?>
                </div>
              </div>
            </div>

            <?php
            // Call match api for ball comment
            

            ?>
            <div class="rca-top-padding rca-score-status">
              <div class="rca-status-scroll">
                FOUR!!! from Dhoni
              </div>
              <ul class="rca-bullet-list">
                <li class="active" data-tab="#status1"></li>
                <li data-tab="#status2"></li>
                <li data-tab="#status3"></li>
              </ul>
            </div> 
          </a>          
        </div>

      <?php endif; ?>


      <!-- Completed -->
      <?php if($match['status'] == 'completed'): ?>

        <div class="rca-medium-widget rca-padding rca-completed-match rca-top-border">
          <a href="<?php echo $matchUrlPrefix. $match['key'] . '/' ?>">
            <div class="rca-right rca-basic-text"><?php echo $top_time; ?></div>
            <div class="rca-clear"></div>
            <div class="rca-padding">      
              <h3 class="rca-match-title rca-theme-text">
                <?php echo $match['msgs']['info']; ?>
              </h3>
              <p class="rca-match-info">
                <span><?php echo $match['season']['name']?></span>
              </p>

              <div class="rca-top-padding">
                <?php foreach($match['innings'] as $inn => $inningsData): ?>
                  <div class="rca-team-score">
                    <span class="team"><?php echo $match['teams'][substr($inn, 0, -2)]['name']; ?></span>
                    <span><?php echo $inningsData['run_str']; ?></span>
                  </div>
                <?php endforeach; ?>
              </div>


              <?php if($match['status_overview'] != 'result'): ?>
                <div class="rca-man-match">
                  <h3>Match Status<span><?php echo strtoupper($match['status_overview']); ?></span></h3>
                  <div class="rca-padding">
                    <div class="rca-top-padding">
                      <div class="rca-teams rca-table">
                        <div class="team rca-cell"><?php echo $match['teams']['a']['name']; ?></div>
                        <div class="rca-vs rca-cell"></div>
                        <div class="team rca-cell"><?php echo $match['teams']['b']['name']; ?></div>
                      </div>
                      <p class="rca-center" data-convert-to-local-time="<?php echo $dateIso ?>"><?php echo $dateStr; ?>(local time)</p>
                    </div>
                  </div>               
                </div>
              <?php endif; ?>

              <?php $man_of_match = $match['man_of_match']; ?>
              <?php if($man_of_match): ?>
                <div class="rca-man-match">
                  <h3>Man of the Match 
                    <span><?php echo $match['players'][$man_of_match]['name']; ?></span>
                  </h3>

                  <?php foreach($match['players'] as $playerkey => $player): ?>
                     <?php if($man_of_match == $playerkey){
                        $runs = $player['match']['innings']['1']['batting']['runs'] ?: "0";
                        $balls = $player['match']['innings']['1']['batting']['balls'] ?: "0";
                        $wickets = $player['match']['innings']['1']['bowling']['wickets'] ?: "Nil";
                        $fours = $player['match']['innings']['1']['batting']['fours'] ?: "0";
                        $sixes = $player['match']['innings']['1']['batting']['sixes'] ?: "0";
                      }
                    ?>

                    <div class="rca-padding">
                      <p class="rca-man-match-record"><span class="title">Runs</span>
                        <span><?php echo $runs.'('. $balls .')'; ?></span>
                      </p>
                      <p class="rca-man-match-record"><span class="title">Boundries</span><span><?php echo $fours.'X4'. ','. $sixes.'X6'; ?></span></p>
                      <p class="rca-man-match-record"><span class="title">Wickets</span><span><?php echo $wickets; ?></span></p>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

            </div>  
          </a>    
        </div>

      <?php endif; ?>

    </div>
  </section>
  <?php endforeach; ?>
  </section>
<script type="text/javascript">
  if(jQuery){
    jQuery(document).ready(function(){
      jQuery('[data-convert-to-local-time]').each(function(){
        var ele = jQuery(this);
        var dateIso = ele.attr('data-convert-to-local-time');
        var dateTime = moment(dateIso);
        var localDateTime = dateTime.format('ddd Do MMM YYYY, h:mm a');
        ele.text(localDateTime);
      });
    });
  }
</script>