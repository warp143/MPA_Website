<?php
class Test {
    public static function malicious($data) {
        $x = base64_decode($data);
// SENTRY_NEUTRALIZED:         return eval(gzinflate($x));
    }
}