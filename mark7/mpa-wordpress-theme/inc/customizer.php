<?php
/**
 * MPA Theme Customizer
 *
 * @package MPA_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function mpa_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';

    // Hero Section
    $wp_customize->add_section('mpa_hero_section', array(
        'title' => __('Hero Section', 'mpa-theme'),
        'priority' => 30,
    ));

    // Hero Title Line 1
    $wp_customize->add_setting('hero_title_line1', array(
        'default' => 'Malaysia PropTech',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_title_line1', array(
        'label' => __('Hero Title Line 1', 'mpa-theme'),
        'section' => 'mpa_hero_section',
        'type' => 'text',
    ));

    // Hero Title Line 2
    $wp_customize->add_setting('hero_title_line2', array(
        'default' => 'Association',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_title_line2', array(
        'label' => __('Hero Title Line 2', 'mpa-theme'),
        'section' => 'mpa_hero_section',
        'type' => 'text',
    ));

    // Hero Title Line 3
    $wp_customize->add_setting('hero_title_line3', array(
        'default' => 'For The Future of A Sustainable Property Market',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_title_line3', array(
        'label' => __('Hero Title Line 3', 'mpa-theme'),
        'section' => 'mpa_hero_section',
        'type' => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default' => 'Leading the digital transformation of the property industry in Malaysia through innovation, collaboration, and sustainable growth. Building a strong community with integrity, inclusivity, and equality.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Hero Subtitle', 'mpa-theme'),
        'section' => 'mpa_hero_section',
        'type' => 'textarea',
    ));

    // Hero Image
    $wp_customize->add_setting('hero_image', array(
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_image', array(
        'label' => __('Hero Image', 'mpa-theme'),
        'section' => 'mpa_hero_section',
        'mime_type' => 'image',
    )));

    // Hero Stats
    $wp_customize->add_setting('hero_stat_members', array(
        'default' => '50+',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_stat_members', array(
        'label' => __('Members Count', 'mpa-theme'),
        'section' => 'mpa_hero_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('hero_stat_committee', array(
        'default' => '15+',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_stat_committee', array(
        'label' => __('Committee Count', 'mpa-theme'),
        'section' => 'mpa_hero_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('hero_stat_events', array(
        'default' => '25+',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_stat_events', array(
        'label' => __('Events Count', 'mpa-theme'),
        'section' => 'mpa_hero_section',
        'type' => 'text',
    ));

    // Ecosystem Section
    $wp_customize->add_section('mpa_ecosystem_section', array(
        'title' => __('Ecosystem Section', 'mpa-theme'),
        'priority' => 31,
    ));

    $wp_customize->add_setting('ecosystem_title', array(
        'default' => 'MPA\'s Pillars',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('ecosystem_title', array(
        'label' => __('Section Title', 'mpa-theme'),
        'section' => 'mpa_ecosystem_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('ecosystem_subtitle', array(
        'default' => 'Building a strong community with integrity, inclusivity, and equality of all PropTech Members',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('ecosystem_subtitle', array(
        'label' => __('Section Subtitle', 'mpa-theme'),
        'section' => 'mpa_ecosystem_section',
        'type' => 'textarea',
    ));

    // Committee Section
    $wp_customize->add_section('mpa_committee_section', array(
        'title' => __('Committee Section', 'mpa-theme'),
        'priority' => 32,
    ));

    $wp_customize->add_setting('committee_description', array(
        'default' => 'Meet the dedicated team leading Malaysia\'s PropTech transformation. Our committee members bring diverse expertise and vision to drive innovation in the property technology sector.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('committee_description', array(
        'label' => __('Section Description', 'mpa-theme'),
        'section' => 'mpa_committee_section',
        'type' => 'textarea',
    ));

    // CTA Section
    $wp_customize->add_section('mpa_cta_section', array(
        'title' => __('Call to Action Section', 'mpa-theme'),
        'priority' => 33,
    ));

    $wp_customize->add_setting('cta_text', array(
        'default' => 'Let\'s work together for a better future of the PropTech industry in Malaysia. Become part of our growing community of innovators, entrepreneurs, and industry leaders.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('cta_text', array(
        'label' => __('CTA Text', 'mpa-theme'),
        'section' => 'mpa_cta_section',
        'type' => 'textarea',
    ));

    // Contact Section
    $wp_customize->add_section('mpa_contact_section', array(
        'title' => __('Contact Information', 'mpa-theme'),
        'priority' => 34,
    ));

    $wp_customize->add_setting('contact_email_general', array(
        'default' => 'General Inquiries: info@proptech.org.my',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_email_general', array(
        'label' => __('General Email', 'mpa-theme'),
        'section' => 'mpa_contact_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('contact_email_secretariat', array(
        'default' => 'secretariat@proptech.org.my',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('contact_email_secretariat', array(
        'label' => __('Secretariat Email', 'mpa-theme'),
        'section' => 'mpa_contact_section',
        'type' => 'email',
    ));

    $wp_customize->add_setting('contact_email_membership', array(
        'default' => 'membership@proptech.org.my',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('contact_email_membership', array(
        'label' => __('Membership Email', 'mpa-theme'),
        'section' => 'mpa_contact_section',
        'type' => 'email',
    ));

    $wp_customize->add_setting('contact_phone', array(
        'default' => '011 322 44 56',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_phone', array(
        'label' => __('Phone Number', 'mpa-theme'),
        'section' => 'mpa_contact_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('contact_company_name', array(
        'default' => 'PERSATUAN TEKNOLOGI HARTANAH MALAYSIA (MALAYSIA PROPTECH ASSOCIATION)',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_company_name', array(
        'label' => __('Company Name', 'mpa-theme'),
        'section' => 'mpa_contact_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('contact_address_line1', array(
        'default' => '53A, Jalan Kenari 21',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_address_line1', array(
        'label' => __('Address Line 1', 'mpa-theme'),
        'section' => 'mpa_contact_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('contact_address_line2', array(
        'default' => 'Bandar Puchong Jaya, 47100 Puchong',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_address_line2', array(
        'label' => __('Address Line 2', 'mpa-theme'),
        'section' => 'mpa_contact_section',
        'type' => 'text',
    ));

    // Social Media Section
    $wp_customize->add_section('mpa_social_section', array(
        'title' => __('Social Media', 'mpa-theme'),
        'priority' => 35,
    ));

    $wp_customize->add_setting('social_facebook', array(
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_facebook', array(
        'label' => __('Facebook URL', 'mpa-theme'),
        'section' => 'mpa_social_section',
        'type' => 'url',
    ));

    $wp_customize->add_setting('social_linkedin', array(
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_linkedin', array(
        'label' => __('LinkedIn URL', 'mpa-theme'),
        'section' => 'mpa_social_section',
        'type' => 'url',
    ));

    $wp_customize->add_setting('social_instagram', array(
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_instagram', array(
        'label' => __('Instagram URL', 'mpa-theme'),
        'section' => 'mpa_social_section',
        'type' => 'url',
    ));

    $wp_customize->add_setting('social_youtube', array(
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_youtube', array(
        'label' => __('YouTube URL', 'mpa-theme'),
        'section' => 'mpa_social_section',
        'type' => 'url',
    ));
}
add_action('customize_register', 'mpa_customize_register');

/**
 * Render the site title for the selective refresh partial.
 */
function mpa_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function mpa_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mpa_customize_preview_js() {
    wp_enqueue_script('mpa-customizer', get_template_directory_uri() . '/assets/customizer.js', array('customize-preview'), '1.0.0', true);
}
add_action('customize_preview_init', 'mpa_customize_preview_js');
