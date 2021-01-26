<?php
/**
 * @return string
 */
function getLogo(){
    return '/Admin/logo.png';
}

/**
 * @return mixed|string
 */
function getAdminImage(){
    if(Auth::guard('Admin')->user()->phone)
        return get_user_lang('Admin',Auth::guard('Admin')->user()->phone);
    return defaultImages(2);
}