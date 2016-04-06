<?php

/**
 * Plugin Name: RCA Cricket Score Widget from Cricket API
 * Description: This is a widget to show live cricket score, recent matches and schedules. Litzscore provides live cricket score for ICC, IPL, CL and CPL.
 * Author: CricketAPI Developers
 * Version: 1.0
 * Author URI: http://cricketapi.com/
 */


/**
 * Adds Match_Widget widget.
 */
class Match_Widget extends WP_Widget {

    /**
     * Register widget with Wordpress.
     */
    public function __construct() {
        parent::__construct(
            'match_widget', // Base ID
            __( 'RCA Match Info', 'wp_widget_plugin' ), // Name
            array(
                'classname'   => 'match_widget',
                'description' => __( 'Show the Match Information.' ) ) // Args
        );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance   Previously saved values from database.
     */
    public function form( $instance ) {
        /**
         * Input Variables
         */
        $matchkey = esc_attr( $instance['matchkey'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('matchkey'); ?>"><?php _e('Enter your Match Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('matchkey'); ?>" name="<?php echo $this->get_field_name('matchkey'); ?>" type="text" value="<?php echo $matchkey; ?>" />
        </p>
        <?php 
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
         
        /* Get the key */
        $matchkey      = $instance['matchkey'];

        /* Make shortcode */
        $shortcode = '[rcamatch key="'.$matchkey.'"]';

        if ( $matchkey ) {
            do_shortcode( $shortcode );
        }     
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {             
        $instance = array();
             
        $instance['matchkey'] = ( ! empty( $new_instance['matchkey'] ) ) ? strip_tags( $new_instance['matchkey'] ) : '';
        return $instance;     
        }
}

/**
 * Adds BallByBall_Widget widget.
 */
class BallByBall_Widget extends WP_Widget {

    /**
     * Register widget with Wordpress.
     */
    public function __construct() {
        parent::__construct(
            'ballbyball_widget', // Base ID
            __( 'RCA BallByBall', 'wp_widget_plugin' ), // Name
            array(
                'classname'   => 'ballbyball_widget',
                'description' => __( 'All details about balls of requested over.' ) ) // Args
        );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance   Previously saved values from database.
     */
    public function form( $instance ) {    
        /**
         * Input Variables
         */
        $matchkey = esc_attr( $instance['matchkey'] );
        $overkey = esc_attr( $instance['overkey'] );
        ?>
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

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
         
        /* Get the match key, over key */
        $matchkey     = $instance['matchkey'];
        $overkey      = $instance['overkey'];

        /* Make shortcode */
        $shortcode = '[rcaballbyball matchkey="'.$matchkey.'" overkey="' .$overkey. '"]';

        do_shortcode( $shortcode );
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        
        $instance['matchkey'] = ( ! empty( $new_instance['matchkey'] ) ) ? strip_tags( $new_instance['matchkey'] ) : '';
        $instance['overkey'] = ( ! empty( $new_instance['overkey'] ) ) ? strip_tags( $new_instance['overkey'] ) : '';

        return $instance;
        }
}

/**
 * Adds RecentMatches_Widget widget.
 */
class RecentMatches_Widget extends WP_Widget {

    /**
     * Register widget with Wordpress.
     */
    public function __construct() {
        parent::__construct(
            'recentmatches_widget', // Base ID
            __( 'RCA Recent Matches', 'wp_widget_plugin' ), // Name
            array(
                'classname'   => 'recentmatches_widget',
                'description' => __( 'Show Recent Matches details(Also season based).' ) ) // Args
        );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance   Previously saved values from database.
     */
    public function form( $instance ) {
        /**
         * Input Variables
         */
        $seasonkey = esc_attr( $instance['seasonkey'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('seasonkey'); ?>"><?php _e('Enter Season Key [For Season based only]:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('seasonkey'); ?>" name="<?php echo $this->get_field_name('seasonkey'); ?>" type="text" value="<?php echo $seasonkey; ?>" />
        </p>
        <?php 
        }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {  
        extract( $args );
         
        /* Get the key */
        $seasonkey      = $instance['seasonkey'];

        /* Make shortcode */
        $shortcode = '[rcarecentmatch key="'.$seasonkey.'"]';

        do_shortcode( $shortcode );
    }  

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
             
        $instance['seasonkey'] = ( ! empty( $new_instance['seasonkey'] ) ) ? strip_tags( $new_instance['seasonkey'] ) : '';
        return $instance;     
        }  
}

/**
 * Adds RecentSeason_Widget widget.
 */
class RecentSeason_Widget extends WP_Widget {

    /**
     * Register widget with Wordpress.
     */
    public function __construct() {
        parent::__construct(
            'recentseason_widget', // Base ID
            __( 'RCA Recent Season', 'wp_widget_plugin' ), // Name
            array(
                'classname'   => 'recentseason_widget',
                'description' => __( 'Show Recent Season Match details.' ) ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     */
    public function widget($args) {
        extract( $args );
         
        /* Make shortcode */
        $shortcode = '[rcarecentseason]';

        do_shortcode( $shortcode );
    }
}

/**
 * Adds Schedule_Widget widget.
 */
class Schedule_Widget extends WP_Widget {

    /**
     * Register widget with Wordpress.
     */
    public function __construct() {
        parent::__construct(
            'schedule_widget', // Base ID
            __( 'RCA Cricket Schedules', 'wp_widget_plugin' ), // Name
            array(
                'classname'   => 'schedule_widget',
                'description' => __( 'Show Cricket Schedules.' ) ) // Args
        );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance   Previously saved values from database.
     */
    public function form( $instance ) {    

        /**
         * Input Variables
         */
        $dateformat = esc_attr( $instance['dateformat'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('dateformat'); ?>"><?php _e('Enter the date [Optional]: [YYYY-MM] OR [YYYY-MM-DD]'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('dateformat'); ?>" name="<?php echo $this->get_field_name('dateformat'); ?>" type="text" value="<?php echo $dateformat; ?>" />
        </p>
        <?php 
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
         
        /* Get the key */
        $dateformat      = $instance['dateformat'];

        /* Make shortcode */
        if($dateformat == ''){
            $shortcode = '[rcaschedule date=""]';
        } else {
            $shortcode = '[rcaschedule date="'.$dateformat.'"]';
        }

        do_shortcode( $shortcode );
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {        
             
        $instance = array();
             
        $instance['dateformat'] = ( ! empty( $new_instance['dateformat'] ) ) ? strip_tags( $new_instance['dateformat'] ) : '';
        return $instance;     
    }
}

/**
 * Adds ScheduleSeason_Widget widget.
 */
class ScheduleSeason_Widget extends WP_Widget {

    /**
     * Register widget with Wordpress.
     */
    public function __construct() {
        parent::__construct(
            'scheduleseason_widget', // Base ID
            __( 'RCA Cricket Season Schedules', 'wp_widget_plugin' ), // Name
            array(
                'classname'   => 'scheduleseason_widget',
                'description' => __( 'Show Cricket Schedules as per Seasons.' ) ) // Args
        );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance   Previously saved values from database.
     */
    public function form( $instance ) {    

        /**
         * Input Variables
         */
        $seasonkey = esc_attr( $instance['seasonkey'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('seasonkey'); ?>"><?php _e('Enter your Season Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('seasonkey'); ?>" name="<?php echo $this->get_field_name('seasonkey'); ?>" type="text" value="<?php echo $seasonkey; ?>" />
        </p>
        <?php 
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
         
        /* Get the key */
        $seasonkey      = $instance['seasonkey'];

        /* Make shortcode */
        $shortcode = '[rcascheduleseason key="'.$seasonkey.'"]';

        if ( $seasonkey ) {
            do_shortcode( $shortcode );
        }     
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {        
             
        $instance = array();
             
        $instance['seasonkey'] = ( ! empty( $new_instance['seasonkey'] ) ) ? strip_tags( $new_instance['seasonkey'] ) : '';
        return $instance;     
    }
}

/**
 * Adds PlayerStats_Widget widget.
 */
class PlayerStats_Widget extends WP_Widget {

    /**
     * Register widget with Wordpress.
     */
    public function __construct() {
        parent::__construct(
            'playerstats_widget', // Base ID
            __( 'RCA Player Stats', 'wp_widget_plugin' ), // Name
            array(
                'classname'   => 'playerstats_widget',
                'description' => __( 'Show stats about a player for the specified league or board.' ) ) // Args
        );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance   Previously saved values from database.
     */
    public function form( $instance ) {    

        /**
        * Input Variables
        */
        $playerkey = esc_attr( $instance['playerkey'] );
        $leaguekey = esc_attr( $instance['leaguekey'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('playerkey'); ?>"><?php _e('Enter your Player Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('playerkey'); ?>" name="<?php echo $this->get_field_name('playerkey'); ?>" type="text" value="<?php echo $playerkey; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('leaguekey'); ?>"><?php _e('Enter your League Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('leaguekey'); ?>" name="<?php echo $this->get_field_name('leaguekey'); ?>" type="text" value="<?php echo $leaguekey; ?>" />
        </p>
        <?php 
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {   
        extract( $args );
         
        // Get the season key, player key
        $playerkey      = $instance['playerkey'];
        $leaguekey      = $instance['leaguekey'];

        // Make shortcode
        $shortcode = '[rcaplayerstats playerkey="'.$playerkey.'" leaguekey="' .$leaguekey. '"]';

        if ( $playerkey && $leaguekey ) {
            do_shortcode( $shortcode );
        }     
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {    
        $instance = array();
             
        $instance['playerkey'] = ( ! empty( $new_instance['playerkey'] ) ) ? strip_tags( $new_instance['playerkey'] ) : '';
        $instance['leaguekey'] = ( ! empty( $new_instance['leaguekey'] ) ) ? strip_tags( $new_instance['leaguekey'] ) : '';
        
        return $instance;     
    }
}

/**
 * Adds Season_Widget widget.
 */
class Season_Widget extends WP_Widget {

    /**
     * Register widget with Wordpress.
     */
    public function __construct() {
        parent::__construct(
            'season_widget', // Base ID
            __( 'RCA Season Data', 'wp_widget_plugin' ), // Name
            array( 
                'classname'   => 'season_widget',
                'description' => __( 'Show Cricket Season Data.' ) ) // Args
        );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance   Previously saved values from database.
     */
    public function form( $instance ) {    
        /**
         * Input Variables
         */
        $seasonkey = esc_attr( $instance['seasonkey'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('seasonkey'); ?>"><?php _e('Enter your Season Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('seasonkey'); ?>" name="<?php echo $this->get_field_name('seasonkey'); ?>" type="text" value="<?php echo $seasonkey; ?>" />
        </p>
        <?php 
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) { 
        extract( $args );
         
        /* Get the key */
        $seasonkey      = $instance['seasonkey'];

        /* Make shortcode */
        $shortcode = '[rcaseason key="'.$seasonkey.'"]';

        if ( $seasonkey ) {
            do_shortcode( $shortcode );
        }     
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {        
             
        $instance = array();
             
        $instance['seasonkey'] = ( ! empty( $new_instance['seasonkey'] ) ) ? strip_tags( $new_instance['seasonkey'] ) : '';
        return $instance;     
    }
}

/**
 * Adds SeasonStats_Widget widget.
 */
class SeasonStats_Widget extends WP_Widget {

    /**
     * Register widget with Wordpress.
     */
    public function __construct() {
        parent::__construct(
            'seasonstats_widget', // Base ID
            __( 'RCA Season Stats', 'wp_widget_plugin' ), // Name
            array(
                'classname'   => 'seasonstats_widget',
                'description' => __( 'Show Seasons Recent Matches.' ) ) // Args
        );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance   Previously saved values from database.
     */
    public function form( $instance ) {    

        /**
        * Input Variables
        */
        $seasonkey = esc_attr( $instance['seasonkey'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('seasonkey'); ?>"><?php _e('Enter your Season Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('seasonkey'); ?>" name="<?php echo $this->get_field_name('seasonkey'); ?>" type="text" value="<?php echo $seasonkey; ?>" />
        </p>
        <?php 
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) { 
        extract( $args );
         
        /* Get the key */
        $seasonkey      = $instance['seasonkey'];

        /* Make shortcode */
        $shortcode = '[rcaseasonstats key="'.$seasonkey.'"]';

        if ( $seasonkey ) {
            do_shortcode( $shortcode );
        }     
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {        
             
        $instance = array();
             
        $instance['seasonkey'] = ( ! empty( $new_instance['seasonkey'] ) ) ? strip_tags( $new_instance['seasonkey'] ) : '';
        return $instance;     
    }
}

/**
 * Adds SeasonPoints_Widget widget.
 */
class SeasonPoints_Widget extends WP_Widget {

    /**
     * Register widget with Wordpress.
     */
    public function __construct() {
        parent::__construct(
            'seasonpoints_widget', // Base ID
            __( 'RCA Season Points', 'wp_widget_plugin' ), // Name
            array(
                'classname'   => 'seasonpoints_widget',
                'description' => __( 'Show Season Points.' ) ) // Args
        );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance   Previously saved values from database.
     */
    public function form( $instance ) {    

        /**
         * Input Variables
         */
        $seasonkey = esc_attr( $instance['seasonkey'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('seasonkey'); ?>"><?php _e('Enter your Season Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('seasonkey'); ?>" name="<?php echo $this->get_field_name('seasonkey'); ?>" type="text" value="<?php echo $seasonkey; ?>" />
        </p>
        <?php 
    }


    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {  
        extract( $args );
         
        // Get the key
        $seasonkey      = $instance['seasonkey'];

        // Make shortcode
        $shortcode = '[rcaseasonpoints key="'.$seasonkey.'"]';

        if ( $seasonkey ) {
            do_shortcode( $shortcode );
        }     
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {  
        $instance = array();
             
        $instance['seasonkey'] = ( ! empty( $new_instance['seasonkey'] ) ) ? strip_tags( $new_instance['seasonkey'] ) : '';
        return $instance;     
    }
}

/**
 * Adds SeasonTeam_Widget widget.
 */
class SeasonTeam_Widget extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'seasonteam_widget', // Base ID
            __('RCA Season Team', 'wp_widget_plugin'), // Name
            array(
                'classname' => 'seasonteam_widget',
                'description' => __( 'Information about team and players in season team.' ) ) // Args
            );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance   Previously saved values from database.
     */
    public function form( $instance ) {    

        /**
         * Input Variables
         */
        $seasonkey = esc_attr( $instance['seasonkey'] );
        $teamkey = esc_attr( $instance['teamkey'] );
        $statstype = esc_attr( $instance['statstype'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('seasonkey'); ?>"><?php _e('Enter your Season Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('seasonkey'); ?>" name="<?php echo $this->get_field_name('seasonkey'); ?>" type="text" value="<?php echo $seasonkey; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('teamkey'); ?>"><?php _e('Enter your Team Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('teamkey'); ?>" name="<?php echo $this->get_field_name('teamkey'); ?>" type="text" value="<?php echo $teamkey; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('statstype'); ?>"><?php _e('Enter your Stats Type:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('statstype'); ?>" name="<?php echo $this->get_field_name('statstype'); ?>" type="text" value="<?php echo $statstype; ?>" />
        </p> 
        <?php 
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {    
        extract( $args );
         
        // Get the key
        $seasonkey      = $instance['seasonkey'];
        $teamkey = $instance['teamkey'];
        $statstype = $instance['statstype'];

        // Make shortcode
        $shortcode = '[rcaseasonteam seasonkey="'.$seasonkey.'" teamkey="'.$teamkey.'" statstype="'.$statstype.'"]';

        if ( $seasonkey && $teamkey && $statstype ) {
            do_shortcode( $shortcode );
        }     
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {    
        $instance = array();
             
        $instance['seasonkey'] = ( ! empty( $new_instance['seasonkey'] ) ) ? strip_tags( $new_instance['seasonkey'] ) : '';
        $instance['teamkey'] = ( ! empty( $new_instance['teamkey'] ) ) ? strip_tags( $new_instance['teamkey'] ) : '';
        $instance['statstype'] = ( ! empty( $new_instance['statstype'] ) ) ? strip_tags( $new_instance['statstype'] ) : '';

        return $instance;
    }
}

/**
 * Adds OverSummary_Widget widget.
 */
class OverSummary_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'oversummary_widget', // Base ID
            __( 'RCA Overs Summary', 'wp_widget_plugin' ), // Name
            array(
                'classname'   => 'oversummary_widget',
                'description' => __( 'Show Overs Summary of a match.' ) ) // Args
        );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance   Previously saved values from database.
     */
    public function form( $instance ) {    

        /**
         * Input Variables
         */
        $matchkey = esc_attr( $instance['matchkey'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('matchkey'); ?>"><?php _e('Enter your Match Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('matchkey'); ?>" name="<?php echo $this->get_field_name('matchkey'); ?>" type="text" value="<?php echo $matchkey; ?>" />
        </p> 
        <?php 
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {    
        extract( $args );
         
        // Get the key
        $matchkey      = $instance['matchkey'];

        // Make shortcode
        $shortcode = '[rcaoversummary key="'.$matchkey.'"]';

        if ( $matchkey ) {
            do_shortcode( $shortcode );
        }     
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {    
        $instance = array();
             
        $instance['matchkey'] = ( ! empty( $new_instance['matchkey'] ) ) ? strip_tags( $new_instance['matchkey'] ) : '';

        return $instance;
    }
}

/**
 * Adds NewsAggregation_Widget widget.
 */
class NewsAggregation_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'newsaggregation_widget', // Base ID
            __( 'RCA News Aggregation', 'wp_widget_plugin' ), // Name
            array(
                'classname'   => 'newsaggregation_widget',
                'description' => __( 'Get Cricket News feed from the popular rss.' ) ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     */
    public function widget($args) {    
        extract( $args );
         
        // Make shortcode
        $shortcode = '[rcanewsaggregation]';

        do_shortcode( $shortcode );
    }
}

/**
 * Adds MatchStatusCard_Widget widget.
 */
class MatchStatusCard_Widget extends WP_Widget {

    /**
     * Register widget with Wordpress.
     */
    public function __construct() {
        parent::__construct(
            'matchstatuscard_widget', // Base ID
            __( 'RCA Match Promo Card', 'wp_widget_plugin' ), // Name
            array(
                'classname'   => 'matchstatuscard_widget',
                'description' => __( 'Display match status in Promo Card format.' ) ) // Args
        );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance   Previously saved values from database.
     */
    public function form( $instance ) {
        /**
         * Input Variables
         */
        $matchkey = esc_attr( $instance['matchkey'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('matchkey'); ?>"><?php _e('Enter your Match Key:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('matchkey'); ?>" name="<?php echo $this->get_field_name('matchkey'); ?>" type="text" value="<?php echo $matchkey; ?>" />
        </p>
        <?php 
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
         
        /* Get the key */
        $matchkey      = $instance['matchkey'];

        /* Make shortcode */
        $shortcode = '[rcamatchpromo key="'.$matchkey.'"]';

        if ( $matchkey ) {
            do_shortcode( $shortcode );
        }     
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {             
        $instance = array();
             
        $instance['matchkey'] = ( ! empty( $new_instance['matchkey'] ) ) ? strip_tags( $new_instance['matchkey'] ) : '';
        return $instance;     
        }
}


/* Register the widgets */
function rca_widgets_register() {
    register_widget('Match_Widget');
    register_widget('BallByBall_Widget');
    register_widget('RecentMatches_Widget');
    register_widget('RecentSeason_Widget');
    register_widget('Schedule_Widget');
    register_widget('ScheduleSeason_Widget');
    register_widget('PlayerStats_Widget');
    register_widget('Season_Widget');
    register_widget('SeasonStats_Widget');
    register_widget('SeasonPoints_Widget');
    register_widget('SeasonTeam_Widget');
    register_widget('OverSummary_Widget');
    register_widget('NewsAggregation_Widget');
    register_widget('MatchStatusCard_Widget');
}

add_action( 'widgets_init', 'rca_widgets_register' );
