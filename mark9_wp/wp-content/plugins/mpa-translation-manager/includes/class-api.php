<?php
/**
 * REST API endpoints for MPA Translation Manager
 */

class MPA_Translation_API {
    
    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }
    
    public function register_routes() {
        // GET translations by language
        register_rest_route('mpa/v1', '/translations/(?P<lang>[a-z]{2})', [
            'methods' => 'GET',
            'callback' => [$this, 'get_translations'],
            'permission_callback' => '__return_true',
            'args' => [
                'lang' => [
                    'required' => true,
                    'validate_callback' => function($param) {
                        return in_array($param, ['en', 'bm', 'cn']);
                    }
                ]
            ]
        ]);
        
        // UPDATE single translation (admin only)
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
    }
    
    public function get_translations($request) {
        $lang = $request['lang'];
        $translations = MPA_Translation_Database::get_all_translations($lang);
        
        return new WP_REST_Response([
            'success' => true,
            'language' => $lang,
            'translations' => $translations,
            'count' => count($translations),
            'last_modified' => current_time('mysql')
        ], 200);
    }
    
    public function update_translation($request) {
        $params = $request->get_json_params();
        
        $key = sanitize_text_field($params['key']);
        $lang = sanitize_text_field($params['lang']);
        $value = sanitize_textarea_field($params['value']);
        
        $result = MPA_Translation_Database::update_translation($key, $lang, $value);
        
        if ($result !== false) {
            return new WP_REST_Response([
                'success' => true,
                'message' => 'Translation updated successfully',
                'data' => ['key' => $key, 'lang' => $lang, 'value' => $value]
            ], 200);
        } else {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'Failed to update translation'
            ], 500);
        }
    }
    
    public function bulk_update($request) {
        $params = $request->get_json_params();
        $translations = $params['translations'];
        
        $updated = 0;
        $failed = 0;
        
        foreach ($translations as $item) {
            $result = MPA_Translation_Database::update_translation(
                $item['key'],
                $item['lang'],
                $item['value']
            );
            
            if ($result !== false) {
                $updated++;
            } else {
                $failed++;
            }
        }
        
        return new WP_REST_Response([
            'success' => true,
            'updated' => $updated,
            'failed' => $failed,
            'message' => "Updated $updated translations, $failed failed"
        ], 200);
    }
}
