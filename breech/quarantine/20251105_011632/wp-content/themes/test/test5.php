<?php
class TestClass {
    // Function declaration line with pattern - should neutralize entire function
    public static function eval_gzinflate_base64($data) {
        $x = base64_decode($data);
        return eval(gzinflate($x));
    }
}
