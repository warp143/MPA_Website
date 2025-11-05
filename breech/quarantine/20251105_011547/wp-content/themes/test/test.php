<?php
// Legitimate function - should NOT match
function legitimate_function($data) {
    return gzinflate(substr($data, 2));
}

// Malicious function - SHOULD match and neutralize entire function
function malicious_function($data) {
    $decoded = base64_decode($data);
// SENTRY_NEUTRALIZED:     return eval(gzinflate($decoded));
}

// Regular line with malicious pattern
// SENTRY_NEUTRALIZED: $evil = eval(base64_decode($x));