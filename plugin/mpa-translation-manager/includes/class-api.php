<?php
/**
 * MPA Translation REST API Class
 * Provides REST API endpoints for translations
 */

if (!defined('ABSPATH')) {
    exit;
}

class MPA_Translation_API {
    
    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }
    
    /**
     * Register REST API routes
     */
    public function register_routes() {
        // GET translations by language
        register_rest_route('mpa/v1', '/translations/(?P<lang>[a-z]{2})', [
            'methods' => 'GET',
            'callback' => [$this, 'get_translations'],
            'permission_callback' => '__return_true', // Public endpoint
            'args' => [
                'lang' => [
                    'required' => true,
                    'validate_callback' => function($param) {
                        return in_array($param, ['en', 'bm', 'cn']);
                    },
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ]
        ]);
        
        // GET all translations (admin only)
        register_rest_route('mpa/v1', '/translations/all', [
            'methods' => 'GET',
            'callback' => [$this, 'get_all_translations'],
            'permission_callback' => function() {
                return current_user_can('manage_options');
            }
        ]);
        
        // POST/UPDATE single translation (admin only)
        register_rest_route('mpa/v1', '/translations', [
            'methods' => 'POST',
            'callback' => [$this, 'update_translation'],
            'permission_callback' => function() {
                return current_user_can('manage_options');
            }
        ]);
        
        // BULK update translations (admin only)
        register_rest_route('mpa/v1', '/translations/bulk', [
            'methods' => 'POST',
            'callback' => [$this, 'bulk_update'],
            'permission_callback' => function() {
                return current_user_can('manage_options');
            }
        ]);
        
        // DELETE translation (admin only)
        register_rest_route('mpa/v1', '/translations/(?P<key>[a-zA-Z0-9_-]+)', [
            'methods' => 'DELETE',
            'callback' => [$this, 'delete_translation'],
            'permission_callback' => function() {
                return current_user_can('manage_options');
            },
            'args' => [
                'key' => [
                    'required' => true,
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                'lang' => [
                    'required' => false,
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ]
        ]);
        
        // GET statistics (admin only)
        register_rest_route('mpa/v1', '/translations/stats', [
            'methods' => 'GET',
            'callback' => [$this, 'get_stats'],
            'permission_callback' => function() {
                return current_user_can('manage_options');
            }
        ]);
    }
    
    /**
     * GET /wp-json/mpa/v1/translations/{lang}
     * Get all translations for a specific language
     */
    public function get_translations($request) {
        $lang = $request['lang'];
        $translations = MPA_Translation_Database::get_all_translations($lang);
        
        return new WP_REST_Response([
            'success' => true,
            'language' => $lang,
            'translations' => $translations,
            'count' => count($translations),
            'last_modified' => current_time('mysql'),
            'cache_hint' => 'Store in localStorage for 1 hour'
        ], 200);
    }
    
    /**
     * GET /wp-json/mpa/v1/translations/all
     * Get all translations grouped by key (admin only)
     */
    public function get_all_translations($request) {
        $grouped = MPA_Translation_Database::get_all_grouped();
        
        return new WP_REST_Response([
            'success' => true,
            'translations' => $grouped,
            'count' => count($grouped),
            'last_modified' => current_time('mysql')
        ], 200);
    }
    
    /**
     * POST /wp-json/mpa/v1/translations
     * Update or create a single translation
     */
    public function update_translation($request) {
        $params = $request->get_json_params();
        
        // Validate required fields
        if (empty($params['key']) || empty($params['lang']) || !isset($params['value'])) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Missing required fields: key, lang, value'
            ], 400);
        }
        
        $key = sanitize_text_field($params['key']);
        $lang = sanitize_text_field($params['lang']);
        $value = sanitize_textarea_field($params['value']);
        $context = isset($params['context']) ? sanitize_text_field($params['context']) : null;
        
        // Validate language
        if (!in_array($lang, ['en', 'bm', 'cn'])) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Invalid language code. Must be en, bm, or cn'
            ], 400);
        }
        
        $result = MPA_Translation_Database::update_translation($key, $lang, $value, get_current_user_id(), $context);
        
        if ($result !== false) {
            return new WP_REST_Response([
                'success' => true,
                'message' => 'Translation updated successfully',
                'data' => [
                    'key' => $key,
                    'lang' => $lang,
                    'value' => $value,
                    'context' => $context
                ]
            ], 200);
        } else {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Failed to update translation'
            ], 500);
        }
    }
    
    /**
     * POST /wp-json/mpa/v1/translations/bulk
     * Bulk update translations
     */
    public function bulk_update($request) {
        $params = $request->get_json_params();
        
        if (empty($params['translations']) || !is_array($params['translations'])) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Invalid request. Expected "translations" array'
            ], 400);
        }
        
        $translations = [];
        foreach ($params['translations'] as $item) {
            $translations[] = [
                'key' => sanitize_text_field($item['key'] ?? ''),
                'lang' => sanitize_text_field($item['lang'] ?? ''),
                'value' => sanitize_textarea_field($item['value'] ?? ''),
                'context' => isset($item['context']) ? sanitize_text_field($item['context']) : null,
                'user_id' => get_current_user_id()
            ];
        }
        
        $result = MPA_Translation_Database::bulk_insert($translations);
        
        return new WP_REST_Response([
            'success' => true,
            'updated' => $result['success'],
            'failed' => $result['failed'],
            'errors' => $result['errors'],
            'message' => "Updated {$result['success']} translations, {$result['failed']} failed"
        ], 200);
    }
    
    /**
     * DELETE /wp-json/mpa/v1/translations/{key}
     * Delete a translation
     */
    public function delete_translation($request) {
        $key = sanitize_text_field($request['key']);
        $lang = isset($request['lang']) ? sanitize_text_field($request['lang']) : null;
        
        $result = MPA_Translation_Database::delete_translation($key, $lang);
        
        if ($result !== false && $result > 0) {
            return new WP_REST_Response([
                'success' => true,
                'message' => $lang ? "Deleted {$lang} translation for key: {$key}" : "Deleted all translations for key: {$key}",
                'deleted_count' => $result
            ], 200);
        } else {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Translation not found or failed to delete'
            ], 404);
        }
    }
    
    /**
     * GET /wp-json/mpa/v1/translations/stats
     * Get translation statistics
     */
    public function get_stats($request) {
        $stats = MPA_Translation_Database::get_stats();
        
        return new WP_REST_Response([
            'success' => true,
            'stats' => $stats
        ], 200);
    }
}

