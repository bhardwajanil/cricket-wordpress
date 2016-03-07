<?php

/**
 * Plugin Name: RCA Cricket Score Widget from Cricket API
 * Description: This is a widget to show live cricket score, recent matches and schedules. Litzscore provides live cricket score for ICC, IPL, CL and CPL.
 * Author: CricketAPI Developers
 * Version: 1.0
 * Author URI: http://cricketapi.com/
 */



/**
 *   Widget Name : RCA Match Details
 */
class MatchData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'matchdata_widget',
                __( 'RCA Match Info', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'matchdata_widget',
                    'description' => __( 'Show the Match Information.' )
                    )
            );
        }

    /* Frontend Display */
    public function widget( $args, $instance ) {    
             
            extract( $args );
             
            /* Get the season key */
            $matchkey      = $instance['matchkey'];

            /* Make shortcode */
            $shortcode = '[rcamatch key="'.$matchkey.'"]';

            if ( $matchkey ) {
                do_shortcode( $shortcode );
            }     
        }

    public function update( $new_instance, $old_instance ) {        
             
        $instance = $old_instance;
             
        $instance['matchkey'] = strip_tags( $new_instance['matchkey'] );
        return $instance;     
        }

    /* Admin Widget Form */
    public function form( $instance ) {    

        /**
        * Input Variables
        */
        $matchkey = esc_attr( $instance['matchkey'] );
        ?>

        <!-- Form Content -->
        <p>
            <label for="<?php echo $this->get_field_id('matchkey'); ?>"><?php _e('Enter your Match Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('matchkey'); ?>" name="<?php echo $this->get_field_name('matchkey'); ?>" type="text" value="<?php echo $matchkey; ?>" />
        </p> 

        <?php 
        }
}


/**
 *   Widget Name : RCA BallByBall Stats
 */
class BallByBallData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'ballbyballdata_widget',
                __( 'RCA BallByBall Stats', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'ballbyballdata_widget',
                    'description' => __( 'Show BallByBall details of requested Over.' )
                    )
            );
        }

    /* Frontend Display */
    public function widget( $args, $instance ) {    
             
            extract( $args );
             
            /* Get the match key, over key */
            $matchkey      = $instance['matchkey'];
            $overkey      = $instance['overkey'];

            /* Make shortcode */
            $shortcode = '[rcaballbyball matchkey="'.$matchkey.'" overkey="' .$overkey. '"]';

            do_shortcode( $shortcode );
        }

    public function update( $new_instance, $old_instance ) {        
             
        $instance = $old_instance;
             
        $instance['matchkey'] = strip_tags( $new_instance['matchkey'] );
        $instance['overkey'] = strip_tags( $new_instance['overkey'] );
        return $instance;     
        }

    /* Admin Widget Form */
    public function form( $instance ) {    

        /**
        * Input Variables
        */
        $matchkey = esc_attr( $instance['matchkey'] );
        $overkey = esc_attr( $instance['overkey'] );
        ?>

        <!-- Form Content -->
        <p>
            <label for="<?php echo $this->get_field_id('matchkey'); ?>"><?php _e('Enter your Match Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('matchkey'); ?>" name="<?php echo $this->get_field_name('matchkey'); ?>" type="text" value="<?php echo $matchkey; ?>" />
        </p> 

        <p>
            <label for="<?php echo $this->get_field_id('overkey'); ?>"><?php _e('Enter your Over Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('overkey'); ?>" name="<?php echo $this->get_field_name('overkey'); ?>" type="text" value="<?php echo $overkey; ?>" />
        </p> 

        <?php 
        }
}


/**
 *   Widget Name : RCA Recent Matches
 */
class RecentMatchesData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'recentmatchesdata_widget',
                __( 'RCA Recent Matches', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'recentmatchesdata_widget',
                    'description' => __( 'Show Recent Matches details(Also season based).' )
                    )
            );
        }

    /* Admin Widget Form */
    public function form( $instance ) {    

        /**
        * Input Variables
        */
        $seasonkey = esc_attr( $instance['seasonkey'] );
        ?>

        <!-- Form Content -->
        <p>
            <label for="<?php echo $this->get_field_id('seasonkey'); ?>"><?php _e('Enter Season Key [For Season based only]:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('seasonkey'); ?>" name="<?php echo $this->get_field_name('seasonkey'); ?>" type="text" value="<?php echo $seasonkey; ?>" />
        </p> 

        <?php 
        }

    public function update( $new_instance, $old_instance ) {        
             
        $instance = $old_instance;
             
        $instance['seasonkey'] = strip_tags( $new_instance['seasonkey'] );
        return $instance;     
        }

    /* Frontend Display */
    public function widget( $args, $instance ) {    
             
            extract( $args );
             
            /* Get the season key */
            $seasonkey      = $instance['seasonkey'];

            /* Make shortcode */
            $shortcode = '[rcarecentmatch key="'.$seasonkey.'"]';

            do_shortcode( $shortcode );
        }    
}


/**
 *   Widget Name : RCA Recent Season Data
 */
class RecentSeasonData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'recentseasondata_widget',
                __( 'RCA Recent Season', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'recentseasondata_widget',
                    'description' => __( 'Show Recent Season Match details.' )
                    )
            );
        }

    /* Frontend Display */
    public function widget($args) {    
             
            extract( $args );
             
            /* Make shortcode */
            $shortcode = '[rcarecentseason]';

            do_shortcode( $shortcode );
        }
}

/**
 *   Widget Name : RCA Cricket Schedules
 */
class ScheduleData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'scheduledata_widget',
                __( 'RCA Cricket Schedules', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'scheduledata_widget',
                    'description' => __( 'Show Cricket Schedules.' )
                    )
            );
        }

    /* Frontend Display */
    public function widget($args) {    
             
            extract( $args );
             
            /* Make shortcode */
            $shortcode = '[rcaschedule]';

            do_shortcode( $shortcode );
        }
}

/**
 *   Widget Name : RCA Cricket Season Schedules
 */
class ScheduleSeasonData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'scheduleseasondata_widget',
                __( 'RCA Cricket Season Schedules', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'scheduleseasondata_widget',
                    'description' => __( 'Show Cricket Schedules as per Seasons.' )
                    )
            );
        }

    /* Frontend Display */
    public function widget( $args, $instance ) {    
             
            extract( $args );
             
            /* Get the season key */
            $seasonkey      = $instance['seasonkey'];

            /* Make shortcode */
            $shortcode = '[rcascheduleseason key="'.$seasonkey.'"]';

            if ( $seasonkey ) {
                do_shortcode( $shortcode );
            }     
        }

    public function update( $new_instance, $old_instance ) {        
             
        $instance = $old_instance;
             
        $instance['seasonkey'] = strip_tags( $new_instance['seasonkey'] );
        return $instance;     
        }

    /* Admin Widget Form */
    public function form( $instance ) {    

        /**
        * Input Variables
        */
        $seasonkey = esc_attr( $instance['seasonkey'] );
        ?>

        <!-- Form Content -->
        <p>
            <label for="<?php echo $this->get_field_id('seasonkey'); ?>"><?php _e('Enter your Season Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('seasonkey'); ?>" name="<?php echo $this->get_field_name('seasonkey'); ?>" type="text" value="<?php echo $seasonkey; ?>" />
        </p> 

        <?php 
        }
}

/**
 *   Widget Name : RCA Season Matches
 */
class SeasonData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'seasondata_widget',
                __( 'RCA Season Data', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'seasondata_widget',
                    'description' => __( 'Show Cricket Season Data.' )
                    )
            );
        }

    /* Frontend Display */
    public function widget( $args, $instance ) {    
             
            extract( $args );
             
            /* Get the season key */
            $seasonkey      = $instance['seasonkey'];

            /* Make shortcode */
    		$shortcode = '[rcaseason key="'.$seasonkey.'"]';

            if ( $seasonkey ) {
                do_shortcode( $shortcode );
            }     
        }

    public function update( $new_instance, $old_instance ) {        
             
        $instance = $old_instance;
             
        $instance['seasonkey'] = strip_tags( $new_instance['seasonkey'] );
        return $instance;     
        }

    /* Admin Widget Form */
    public function form( $instance ) {    

    	/**
    	* Input Variables
    	*/
        $seasonkey = esc_attr( $instance['seasonkey'] );
    	?>

        <!-- Form Content -->
        <p>
            <label for="<?php echo $this->get_field_id('seasonkey'); ?>"><?php _e('Enter your Season Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('seasonkey'); ?>" name="<?php echo $this->get_field_name('seasonkey'); ?>" type="text" value="<?php echo $seasonkey; ?>" />
        </p> 

        <?php 
        }
}

/**
 *   Widget Name : RCA Season Stats
 */
class SeasonStatsData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'seasonstatsdata_widget',
                __( 'RCA Season Stats', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'seasonstatsdata_widget',
                    'description' => __( 'Show Seasons Recent Matches.' )
                    )
            );
        }

    /* Frontend Display */
    public function widget( $args, $instance ) {    
             
            extract( $args );
             
            /* Get the season key */
            $seasonkey      = $instance['seasonkey'];

            /* Make shortcode */
            $shortcode = '[rcaseasonstats key="'.$seasonkey.'"]';

            if ( $seasonkey ) {
                do_shortcode( $shortcode );
            }     
        }

    public function update( $new_instance, $old_instance ) {        
             
        $instance = $old_instance;
             
        $instance['seasonkey'] = strip_tags( $new_instance['seasonkey'] );
        return $instance;     
        }

    /* Admin Widget Form */
    public function form( $instance ) {    

        /**
        * Input Variables
        */
        $seasonkey = esc_attr( $instance['seasonkey'] );
        ?>

        <!-- Form Content -->
        <p>
            <label for="<?php echo $this->get_field_id('seasonkey'); ?>"><?php _e('Enter your Season Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('seasonkey'); ?>" name="<?php echo $this->get_field_name('seasonkey'); ?>" type="text" value="<?php echo $seasonkey; ?>" />
        </p> 

        <?php 
        }
}

/**
 *   Widget Name : RCA Season Points
 */
class SeasonPointsData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'seasonpointsdata_widget',
                __( 'RCA Season Points', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'seasonpointsdata_widget',
                    'description' => __( 'Show Season Points.' )
                    )
            );
        }

    /* Frontend Display */
    public function widget( $args, $instance ) {    
             
            extract( $args );
             
            /* Get the season key */
            $seasonkey      = $instance['seasonkey'];

            /* Make shortcode */
            $shortcode = '[rcaseasonpoints key="'.$seasonkey.'"]';

            if ( $seasonkey ) {
                do_shortcode( $shortcode );
            }     
        }

    public function update( $new_instance, $old_instance ) {        
             
        $instance = $old_instance;
             
        $instance['seasonkey'] = strip_tags( $new_instance['seasonkey'] );
        return $instance;     
        }

    /* Admin Widget Form */
    public function form( $instance ) {    

        /**
        * Input Variables
        */
        $seasonkey = esc_attr( $instance['seasonkey'] );
        ?>

        <!-- Form Content -->
        <p>
            <label for="<?php echo $this->get_field_id('seasonkey'); ?>"><?php _e('Enter your Season Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('seasonkey'); ?>" name="<?php echo $this->get_field_name('seasonkey'); ?>" type="text" value="<?php echo $seasonkey; ?>" />
        </p> 

        <?php 
        }
}

/**
 *   Widget Name : RCA Player Stats
 */
class SeasonPlayerStatsData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'seasonplayerstatsdata_widget',
                __( 'RCA Player Stats', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'seasonplayerstatsdata_widget',
                    'description' => __( 'Show stats about a player for the specified season.' )
                    )
            );
        }

    /* Frontend Display */
    public function widget( $args, $instance ) {    
             
            extract( $args );
             
            /* Get the season key, player key */
            $seasonkey      = $instance['seasonkey'];
            $playerkey      = $instance['playerkey'];

            /* Make shortcode */
            $shortcode = '[rcaplayerstats seasonkey="'.$seasonkey.'" playerkey="' .$playerkey. '"]';

            if ( $seasonkey && $matchkey ) {
                do_shortcode( $shortcode );
            }     
        }

    public function update( $new_instance, $old_instance ) {        
             
        $instance = $old_instance;
             
        $instance['seasonkey'] = strip_tags( $new_instance['seasonkey'] );
        $instance['playerkey'] = strip_tags( $new_instance['playerkey'] );
        return $instance;     
        }

    /* Admin Widget Form */
    public function form( $instance ) {    

        /**
        * Input Variables
        */
        $seasonkey = esc_attr( $instance['seasonkey'] );
        $playerkey = esc_attr( $instance['playerkey'] );
        ?>

        <!-- Form Content -->
        <p>
            <label for="<?php echo $this->get_field_id('seasonkey'); ?>"><?php _e('Enter your Season Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('seasonkey'); ?>" name="<?php echo $this->get_field_name('seasonkey'); ?>" type="text" value="<?php echo $seasonkey; ?>" />
        </p> 

        <p>
            <label for="<?php echo $this->get_field_id('playerkey'); ?>"><?php _e('Enter your Player Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('playerkey'); ?>" name="<?php echo $this->get_field_name('playerkey'); ?>" type="text" value="<?php echo $playerkey; ?>" />
        </p> 

        <?php 
        }
}

/**
 *   Widget Name : RCA Overs Summary
 */
class OverSummaryData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'oversummarydata_widget',
                __( 'RCA Overs Summary', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'oversummarydata_widget',
                    'description' => __( 'Show Overs Summary of a match.' )
                    )
            );
        }

    /* Frontend Display */
    public function widget( $args, $instance ) {    
             
            extract( $args );
             
            /* Get the season key */
            $matchkey      = $instance['matchkey'];

            /* Make shortcode */
            $shortcode = '[rcaoversummary key="'.$matchkey.'"]';

            if ( $matchkey ) {
                do_shortcode( $shortcode );
            }     
        }

    public function update( $new_instance, $old_instance ) {        
             
        $instance = $old_instance;
             
        $instance['matchkey'] = strip_tags( $new_instance['matchkey'] );
        return $instance;     
        }

    /* Admin Widget Form */
    public function form( $instance ) {    

        /**
        * Input Variables
        */
        $matchkey = esc_attr( $instance['matchkey'] );
        ?>

        <!-- Form Content -->
        <p>
            <label for="<?php echo $this->get_field_id('matchkey'); ?>"><?php _e('Enter your Match Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('matchkey'); ?>" name="<?php echo $this->get_field_name('matchkey'); ?>" type="text" value="<?php echo $matchkey; ?>" />
        </p> 

        <?php 
        }
}

/**
 *   Widget Name : RCA News Aggregation
 */
class NewsAggregationData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'newsaggregationdata_widget',
                __( 'RCA News Aggregation', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'newsaggregationdata_widget',
                    'description' => __( 'Get Cricket News feed from the popular rss.' )
                    )
            );
        }

    /* Frontend Display */
    public function widget($args) {    
             
            extract( $args );
             
            /* Make shortcode */
            $shortcode = '[rcanewsaggregation]';

            do_shortcode( $shortcode );
        }
}

/* Register the widgets */
function rca_widgets_register() {
    register_widget('MatchData_Widget');
    register_widget('BallByBallData_Widget');
    register_widget('RecentMatchesData_Widget');
    register_widget('RecentSeasonData_Widget');
    register_widget('ScheduleData_Widget');
    register_widget('ScheduleSeasonData_Widget');
    register_widget('SeasonData_Widget');
    register_widget('SeasonStatsData_Widget');
    register_widget('SeasonPointsData_Widget');
    register_widget('SeasonPlayerStatsData_Widget');
    register_widget('OverSummaryData_Widget');
    register_widget('NewsAggregationData_Widget');
}

add_action( 'widgets_init', 'rca_widgets_register' );
