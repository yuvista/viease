<?php

return [
    
    [
        'group' => 'public',
        'label' => '公众号',
        'collection' => [
            [
                'label' => '订单管理',
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
            [
                'label' => '订单管理',
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
    [
        'group' => 'setting',
        'label' => '设置',
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