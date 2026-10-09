<?php

    if(!function_exists('admin_data')) {
        function admin_data() {
            if(session('admin')) {
                return session('admin');
            }
            return [];
        }
    }
