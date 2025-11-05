<?php
// Test: Function declaration that matches pattern
public static function backdoor_function($data) {
    return eval(gzinflate(base64_decode($data)));
}
