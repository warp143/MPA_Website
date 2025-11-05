<?php
// Function declaration with pattern in it
function evil_function($data) {
    return eval(gzinflate(base64_decode($data)));
}
