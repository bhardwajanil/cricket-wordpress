<?php
/**
 * @package   Cricket-API
 * @author    CricketAPI Developers
 * @version   2.0.0
 */

/**
 * Plugin Name: Cricket API Widget
 * Description: This is a widget to show Cricket Scores which are provided by Cricket API.
 * Author: CricketAPI Developers
 * Version: 2.0.0
 * Author URI: https://www.cricketapi.com/
 */



/**
 *   Widget : RCA Match Card
 */
class MatchData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'matchdata_widget',
                __( 'RCA: Match Card', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'matchdata_widget',
                    'description' => __( 'Provides the full details of a match.' )
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
 *   Widget Name : RCA Recent Matches
 */
class RecentMatchesData_Widget extends WP_Widget {

    /* Naming the widget */
    public function __construct() {

            parent::__construct(
                'recentmatchesdata_widget',
                __( 'RCA: Recent Matches', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'recentmatchesdata_widget',
                    'description' => __( 'Provides recent matches data.' )
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
            <label for="<?php echo $this->get_field_id('seasonkey'); ?>"><?php _e('Enter Season Key [Optional]:'); ?></label> 
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
            $seasonkey      = empty($instance['seasonkey']) ? 'null' : $instance['seasonkey'];

            /* Make shortcode */
            $shortcode = '[rcarecentmatch key="'.$seasonkey.'"]';

            do_shortcode( $shortcode );
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
                __( 'RCA: Season Data', 'wp_widget_plugin' ),
                array(
                    'classname'   => 'seasondata_widget',
                    'description' => __( 'Provides all match cards in a season.' )
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
 *   Widget Name : Recent Seasons
 */
class RecentSeasons_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'recentseasons_widget',
            __( 'RCA: Recent Seasons', 'wp_widget_plugin' ),
            array(
                'classname'   => 'recentseasons_widget',
                'description' => __( 'Provides list of all recent seasons.' )
                )
        );
    }

    public function widget($args) {    
        extract( $args );

        $shortcode = '[rcarecentseasons]';
        do_shortcode( $shortcode );    
 
    }
    
}





/* Register the widgets */
function rca_widgets_register() {
    register_widget('MatchData_Widget');
    register_widget('RecentMatchesData_Widget');
    register_widget('SeasonData_Widget');
    register_widget('RecentSeasons_Widget');
}

add_action( 'widgets_init', 'rca_widgets_register' );