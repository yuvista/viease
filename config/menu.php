<?php

return [
    
    [
        'group' => 'account',
        'label' => '公众号',
        'collection' => [
            [
                'label' => '公众号',
                'uri'   => 'account',
                'icon'  => 'ion-social-whatsapp',
                'submenus' => [
                    [
                        'label' => '添加公众号',
                        'uri'   => 'add',
                    ],
                ],
            ],
            [
                'label' => '用户设置',
                'uri'   => 'user',
                'icon'  => 'ion-android-people',
                'submenus' => [
                    [
                        'label' => '密码修改',
                        'uri'   => 'goods',
                    ],
                    [
                        'label' => '票务订单',
                        'uri'   => 'tickets',
                    ],
                ],
            ],
        ],
    ],
    [
        'group' => 'center',
        'label' => '应用中心',
        'collection' => [
            [
                'label' => '系统设置',
                'uri'   => 'orders',
                'icon'  => 'ion-ios-crop-strong',
                'submenus' => [
                    [
                        'label' => '商品订单',
                        'uri'   => 'goods',
                    ],
                    [
                        'label' => '票务订单',
                        'uri'   => 'tickets',
                    ],
                ],
            ],
        ],
    ],
];