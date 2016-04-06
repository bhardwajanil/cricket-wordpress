<?php
function month_header($date, $type){
	if($type == 'month'){
		return date('M', strtotime($date));		
	} else if($type == 'list'){
		return date('M"y', strtotime($date));	
	}
	
}

// For Month Wise Schedule
$prev_month = month_header($scheduleData['prev_month'], 'month');
$next_month = month_header($scheduleData['next_month'], 'month');
$current_month = month_header($scheduleData['current_month'], 'month');

// For List Wise Schedule
$prev_list = month_header($scheduleData['prev_month'], 'list');
$next_list = month_header($scheduleData['next_month'], 'list');
$current_list = month_header($scheduleData['current_month'], 'list');
?>
<div class="rca-container rca-margin">
	<div class="rca-row">
		<div class="rca-column-12">
		  <div class="rca-schedule-widget">
		  	<h2>INTERNATIONAL CRICKET SCHEDULES</h2>
		  	<div class="rca-schedule-top">
              <span><?php echo date('F Y', strtotime($scheduleData['current_month'])); ?></span>
              <span class="rca-right">
              	<a href="#stab-month">
                  <span>MONTH</span>
                </a>
                <a href="#stab-list">
                  <span>LIST</span>
                </a>
              </span>
            </div>

            <!-- List Wise Schedule Template Starts here -->
            <div class="rca-mini-widget schedule-widget rca-top-border" id="stab-list">
              <ul class="rca-tab-list">
                <li class="rca-tab-link" data-tab="stab-<?php echo $prev_list; ?>" onclick="showTab(this);"><?php echo $prev_list; ?></li>
                <li class="rca-tab-link active" data-tab="stab-<?php echo $current_list; ?>" onclick="showTab(this);"><?php echo $current_list; ?></li>
                <li class="rca-tab-link" data-tab="tab-<?php echo $next_list; ?>" onclick="showTab(this);"><?php echo $next_list; ?></li>
              </ul>
              <div id="stab-<?php echo $current_list; ?>" class="rca-padding rca-tab-content active">
	              <?php foreach($scheduleData['months'][0]['days'] as $days): ?>
	              	<?php foreach($days as $matches): ?>
	              		<?php foreach($matches as $match): ?>
	  						<?php
	          					$date = new DateTime($match['start_date']['iso'], new DateTimeZone('GMT'));
								$date->setTimezone(new DateTimeZone('Asia/Kolkata'));
								$match_header = $date->format('jS M - l');
								$match_time = $date->format('h.i A');
							?>
							<div class="rca-schedule-date">
								<h4><?php echo $match_header; ?></h4>
	          					<div class="rca-schedule-detail rca-<?php echo $match['format']; ?>">
				                    <h2>
				                    	<a href="<?php echo $match['key']; ?>">
				                        	<span class="rca-team"><?php echo $match['short_name']; ?></span>
				                        	<span class="rca-match-time"><?php echo $match_time; ?>	</span>
				                    	</a>
				                    </h2>
				                	<p><?php echo $match['title']; ?></p>
				                 </div>
	          				</div>
	      				<?php endforeach; ?>          			
	              	<?php endforeach; ?>
	              <?php endforeach; ?>
              </div>
            </div>
			<!-- List Wise Schedule Template Ends here -->            

            <!-- Month Wise Schedule Template Starts here -->
		    <div class="rca-mini-widget schedule-widget rca-top-border" id="stab-month">

		    	<ul class="rca-tab-list">
			        <li class="rca-tab-link" data-tab="tab-<?php echo $prev_month; ?>" onclick="showTab(this);"><?php echo $prev_month; ?></li>
			        <li class="rca-tab-link active" data-tab="tab-<?php echo $current_month; ?>" onclick="showTab(this);"><?php echo $current_month; ?></li>
			        <li class="rca-tab-link" data-tab="tab-<?php echo $next_month; ?>" onclick="showTab(this);"><?php echo $next_month; ?></li>
		      	</ul>

			    <div id="tab-<?php echo $current_month; ?>" class="rca-tab-content active">
			    	<div class="rca-day-calendar">
						<div class="rca-row">
							<div class="rca-week-day-header">
							  SUN
							</div>
							<div class="rca-week-day-header">
							  MON
							</div>
							<div class="rca-week-day-header">
							  TUE
							</div>
							<div class="rca-week-day-header">
							  WED
							</div>
							<div class="rca-week-day-header">
							  THU
							</div>
							<div class="rca-week-day-header">
							  FRI
							</div>
							<div class="rca-week-day-header">
							  SAT
							</div>
						</div>				

						<?php $cols = array_chunk($scheduleData['months'][0]['days'], count($scheduleData['months'][0]['days'])/4); ?>
						
						<?php foreach ($cols as $col){ ?>
							<div class="rca-row">
								<?php foreach ($col as $day){ ?>
									<div class="rca-week-day">
										<div class="rca-index">
											<?php echo $day['day']; ?>
										</div>

										<?php foreach($day['matches'] as $match) { ?>
											<div class="rca-schedule-detail rca-<?php echo $match['format']; ?>">
												<h2>
												  <a href="<?php echo $match['key']; ?>">
												  <?php
												  	$date = new DateTime($match['start_date']['iso'], new DateTimeZone('GMT'));
													$date->setTimezone(new DateTimeZone('Asia/Kolkata'));
													$match_time = $date->format('h.i a');
												  ?>
												    <span class="rca-match-time"><?php echo $match_time; ?></span>
												    <span class="rca-team"><?php echo $match['short_name']; ?></span>
												  </a>
												</h2>
											</div>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						<?php } ?>				
			        </div>
			    </div>
		    </div>
		    <!-- Month Wise Schedule Template Ends here -->
		  </div>
		</div>
	</div>
</div>