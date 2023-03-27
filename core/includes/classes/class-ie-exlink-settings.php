<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Ie_Exlink_Settings' ) ):
    class Ie_Exlink_Settings {

        private $settings_api;

        function __construct() {
            $this->settings_api = new Exlink_WP_Settings_API();

            add_action( 'admin_init', array( $this, 'admin_init' ) );
            add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        }

        function admin_init() {
            //set the settings
            $this->settings_api->set_sections( $this->get_settings_sections() );
            $this->settings_api->set_fields( $this->get_settings_fields() );

            //initialize settings
            $this->settings_api->admin_init();
        }

        function admin_menu() {
            $page_title = 'ie exLink';
		    $menu_title = 'ie exLink';
		    $capability = 'manage_options';
		    $slug = 'ieexLink';
		    $callback = array($this, 'plugin_page');
            add_options_page($page_title, $menu_title, $capability, $slug, $callback);
        }

        function get_settings_sections() {
            $sections = array(
                array(
                    'id'    => 'iexlink_general',
                    'title' => __( 'Ie exLink Setting', 'ie-exlink' ),
                    'desc'  => __( 'General options for enExlink', 'ie-exlink' )
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
                'iexlink_general'   => array(
                    array(
                        'name'     => 'iex-linkwarning',
                        'label'    => __( 'Enable linkWarning', 'ie-exlink' ),
                        'desc'     => __( 'clicked enable external links warning', 'ie-exlink' ),
                        'type'     => 'checkbox',
                        'default'  => 'on'
                    ),
                    array(
                        'name'     => 'iex-nofollow',
                        'label'    => __( 'Auto add noFollow', 'ie-exlink' ),
                        'desc'     => __( 'external links auto add nofollow', 'ie-exlink' ),
                        'type'     => 'checkbox',
                        'default'  => 'off'
                    ),
                    array(
                        'name'     => 'iex-showurl',
                        'label'    => __( 'ShowUrl', 'ie-exlink' ),
                        'desc'     => __( 'show external link in popup', 'ie-exlink' ),
                        'type'     => 'checkbox',
                        'default'  => 'on'
                    ),
                    array(
                        'name'        => 'iex-warning',
                        'label'       => __( 'Warning text', 'ie-exlink' ),
                        'desc'        => __( 'custom popup warning text here', 'ie-exlink' ),
                        'placeholder' => __( 'You are about to leave this website and navigate to the link below. Would you like to continue?', 'ie-exlink' ),
                        'type'        => 'textarea',
                        'default'     => __( 'You are about to leave this website and navigate to the link below. Would you like to continue?', 'ie-exlink' ),
                    ),
                    array(
                        'name'              => 'iex-cancel',
                        'label'             => __( 'Cancel Button', 'ie-exlink' ),
                        'desc'              => __( 'custom cancel button text', 'ie-exlink' ),
                        'placeholder'       => __( 'Cancel', 'ie-exlink' ),
                        'type'              => 'text',
                        'default'           => __( 'Cancel', 'ie-exlink' ),
                        'sanitize_callback' => 'sanitize_text_field'
                    ),
                    array(
                        'name'              => 'iex-continue',
                        'label'             => __( 'Continue Button', 'ie-exlink' ),
                        'desc'              => __( 'custom continue button text', 'ie-exlink' ),
                        'placeholder'       => __( 'Continue', 'ie-exlink' ),
                        'type'              => 'text',
                        'default'           => __( 'Continue', 'ie-exlink' ),
                        'sanitize_callback' => 'sanitize_text_field'
                    ),
                    array(
                        'name'    => 'iex-external-color',
                        'label'   => __( 'External link color', 'ie-exlink' ),
                        'desc'    => __( 'custom external link color', 'ie-exlink' ),
                        'type'    => 'color',
                        'default' => '#fc5531'
                    )
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
            $pages         = get_pages();
            $pages_options = array();
            if ( $pages ) {
                foreach ( $pages as $page ) {
                    $pages_options[ $page->ID ] = $page->post_title;
                }
            }

            return $pages_options;
        }

    }
endif;

//new WP_Settings();