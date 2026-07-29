<?php

/**
 * Custom Helper for Ujian Online
 */

if (!function_exists('is_active')) {
    /**
     * Set active class for menu
     */
    function is_active($path, $class = 'bg-blue-600')
    {
        $uri = service('uri');
        return $uri->getSegment(1) == $path ? $class : '';
    }
}

if (!function_exists('alert')) {
    /**
     * SweetAlert2 helper
     */
    function alert($title, $text, $type)
    {
        session()->setFlashdata('alert', [
            'title' => $title,
            'text'  => $text,
            'type'  => $type
        ]);
    }
}