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


function getCurrency(){
    return 'LE';
}


function getMoneyModelType($type){
    if($type == 1)
        $name='يومية';
    if($type == 5)
        $name='فواتير';

    return $name;
}

/**
 * @return array
 */
function getMoneyModelTypes(){
    return [
      [
          'يومية',
          1
      ],
        [
            'عملاء',
            2
        ],
        [
            'موردون',
            3
        ],
        [
            'موظفين',
            4
        ],
        [
            'فواتير',
            5
        ],
        [
            'بنوك',
            7
        ],
    ];
}


