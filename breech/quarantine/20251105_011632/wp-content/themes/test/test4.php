<?php
// Test: Function declaration that matches pattern
public static function backdoor_function($data) {
// SENTRY_NEUTRALIZED:     return eval(gzinflate(base64_decode($data)));
}