<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if ( !class_exists('WeDevs_Settings_API_Test' ) ):
class WeDevs_Settings_API_Test {

    private $settings_api;

    function __construct() {
        $this->settings_api = new WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_options_page( 'Woo OTP', 'Woo OTP', 'delete_posts', 'woo_otp_setting', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'wedevs_basics_woo_otp',
                'title' => __( 'Woo OTP Settings', 'wpp_otp' )
            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'wedevs_basics_woo_otp' => array(
                array(
                    'name'              => 'woo_otp_api',
                    'label'             => __( 'Woo OTP API Credential ', 'wpp_otp' ),
                    'desc'              => __( 'Messagebird.com SMS 2FA API Key https://dashboard.messagebird.com/en/developers/access', 'wpp_otp' ),
                    'placeholder'       => __( 'Woo OTP API', 'wpp_otp' ),
                    'type'              => 'text',
                    'default'           => '4utFT4DhqydjIV003tj0ZB60P',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'              => 'sender_name',
                    'label'             => __( 'SMS Sender Name ', 'wpp_otp' ),
                    'desc'              => __( 'SMS sender name', 'wpp_otp' ),
                    'placeholder'       => __( 'SMS Sender Name', 'wpp_otp' ),
                    'type'              => 'text',
                    'default'           => 'DevShop',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
            ),
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;
