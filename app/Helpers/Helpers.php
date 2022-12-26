<?php


if ( !function_exists('getUserRoles') ) {
    function getUserRoles(): array
    {
        return [
            'admin', 'user', 'worker'
        ];
    }
}




