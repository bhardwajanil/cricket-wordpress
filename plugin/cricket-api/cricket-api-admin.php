<?php

class CricketApiAdmin{

  private $fields = array(
    'appid'       =>  'App ID',
    'access_key'  =>  'Access Key', 
    'secret_key'  =>  'Secret Key');

    /**
     * Start up
     */ 
  public function __construct(){
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
  }

    /**
     * Add options page
     */
  public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Cricket API Settings > Admin', 
            'Cricket API', 
            'manage_options', 
            'cricketapi-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    } 

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'cricketapi_app_options_info' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Cricket API settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'cricketapi_app_options' );   
                do_settings_sections( 'cricketapi-setting-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }


    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'cricketapi_app_options', // Option group
            'cricketapi_app_options_info', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'rca_setting_section_id', // ID
            '', // Title
            array( $this, 'print_section_info' ), // Callback
            'cricketapi-setting-admin' // Page
        );  

        foreach ($this->fields as $field => $name) {
          add_settings_field(
              $field, // ID
              $name, // Title 
              array( $this, 'field_callback'), // Callback
              'cricketapi-setting-admin', // Page
              'rca_setting_section_id', // Section
              array($field)           
          );
        }
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();

        foreach ($this->fields as $field => $name) {
          if( isset( $input[$field] ) )
              $new_input[$field] = sanitize_text_field( $input[$field] );
      }
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your CricketAPI app details here. For more information check <a href="https://www.cricketapi.com/docs/" target="_blank">cricketapi.com</a>';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function field_callback($args)
    {
      $name = $args[0];
        printf(
            '<input type="text" id="'.$name.'" name="cricketapi_app_options_info['.$name.']" value="%s" required="required"/>',
            isset( $this->options[$name] ) ? esc_attr( $this->options[$name]) : ''
        );
    }

}