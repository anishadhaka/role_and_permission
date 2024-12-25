<?php

if (!function_exists('format_date')) {
    function format_date($date, $format = 'Y-m-d') {
        return \Carbon\Carbon::parse($date)->format($format);
    }
}
// if (!function_exists('renderBladeView')) {
//     function renderBladeView($viewName, $data = [])
//     {
//         return view($viewName, $data)->render();
//     }
// }