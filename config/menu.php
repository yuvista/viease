<?php

return [

    [
        'group' => 'account',
        'label' => '公众号',
        'collection' => [
            [
                'label' => '消息',
                'uri'   => 'message',
                'icon'  => 'ion-ios-chatboxes',
                'submenus' => [
                    [
                        'label' => '实时消息',
                        'uri'   => 'message-timeline',
                    ],
                    [
                        'label' => '消息群发',
                        'uri'   => 'broadcasting',
                    ],
                    [
                        'label' => '消息资源库',
                        'uri'   => 'resource',
                    ],
                    [
                        'label' => '模板消息',
                        'uri'   => 'notice',
                    ],
                    [
                        'label' => '自动回复',
                        'uri'   => 'auto-reply',
                    ],
                ],
            ],
            [
                'label' => '用户管理',
                'uri'   => 'user',
                'icon'  => 'ion-person',
                'submenus' => [
                    [
                        'label' => '全部用户',
                        'uri'   => '',
                    ],
                ],
            ],
            [
                'label' => '素材中心',
                'uri'   => 'material',
                'icon'  => 'ion-ios-flask',
                'submenus' => [
                    [
                        'label' => '图文消息',
                        'uri'   => 'news',
                    ],
                    [
                        'label' => '素材管理',
                        'uri'   => 'material',
                    ],
                ],
            ],
            [
                'label' => '数据统计',
                'uri'   => 'data',
                'icon'  => 'ion-ios-clock',
                'submenus' => [
                    [
                        'label' => '用户',
                        'uri'   => 'user',
                    ],
                    [
                        'label' => '图文',
                        'uri'   => 'news',
                    ],
                    [
                        'label' => '消息',
                        'uri'   => 'message',
                    ],
                    [
                        'label' => '接口',
                        'uri'   => 'api',
                    ],
                ],
            ],
            [
                'label' => '账号管理',
                'uri'   => 'user',
                'icon'  => 'ion-android-people',
                'submenus' => [
                    [
                        'label' => '密码修改',
                        'uri'   => 'goods',
                    ],
                ],
            ],

            [
                'label' => '公众号',
                'uri'   => 'account',
                'icon'  => 'ion-social-whatsapp',
                'submenus' => [
                    [
                        'label' => '我的公众号',
                        'uri'   => '',
                    ],
                    [
                        'label' => '添加公众号',
                        'uri'   => 'create',
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