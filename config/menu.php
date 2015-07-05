<?php

$card = [

    'group' => 'card',
    'label' => '卡券',
    'collection' => [
        [
            'label' => '卡券管理',
            'icon'  => 'ion-ios-photos',
            'submenus' => [
                [
                    'label' => '全部卡券',
                    'uri'   => 'card',
                ],
            ],
        ],
    ],
];

$store = [

    'group' => 'store',
    'label' => '小店',
    'collection' => [
        [
            'label' => '订单管理',
            'icon'  => 'ion-ios-list',
            'submenus' => [
                [
                    'label' => '全部订单',
                    'uri'   => 'order',
                ],
            ],
        ],
        [
            'label' => '商品管理',
            'icon'  => 'ion-ios-football',
            'submenus' => [
                [
                    'label' => '全部商品',
                    'uri'   => 'goods',
                ],
                [
                    'label' => '货架管理',
                    'uri'   => 'goods/shelf',
                ],
                [
                    'label' => '商品分组',
                    'uri'   => 'goods/group',
                ],
                [
                    'label' => '邮费模板',
                    'uri'   => 'goods/postage-template',
                ],
            ],
        ],
    ],

];

$center = [

    'group' => 'center',
    'label' => '应用中心',
    'collection' => [
        [
            'label' => '应用',
            'icon'  => 'ion-ios-game-controller-b',
            'submenus' => [
                [
                    'label' => '我的应用',
                    'uri'   => 'apps/mine',
                ],
                [
                    'label' => '应用中心',
                    'uri'   => 'apps',
                ],
            ],
        ],
    ]
];

return [

    'account' => [
        [
            'group' => 'account',
            'label' => '公众号',
            'collection' => [
                [
                    'label' => '公众号管理',
                    'icon'  => 'ion-social-whatsapp',
                    'submenus' => [
                        [
                            'label' => '公众号管理',
                            'uri'   => 'account',
                        ],
                        [
                            'label' => '新增公众号',
                            'uri'   => 'account/create',
                        ],
                    ],
                ],
                [
                    'label' => '管理员',
                    'icon'  => 'ion-android-people',
                    'submenus' => [
                        [
                            'label' => '密码修改',
                            'uri'   => 'user/password',
                        ],
                    ],
                ],
            ],
        ],

        // $center,
    ],

    'func' => [
        [
            'group' => 'func',
            'label' => '功能管理',
            'collection' => [
                [
                    'label' => '消息',
                    'icon'  => 'ion-ios-chatboxes',
                    'submenus' => [
                        [
                            'label' => '实时消息',
                            'uri'   => 'message/timeline',
                        ],
                        [
                            'label' => '消息群发',
                            'uri'   => 'message/broadcasting',
                        ],
                        [
                            'label' => '消息资源库',
                            'uri'   => 'message/resource',
                        ],
                        // [
                        //     'label' => '模板消息',
                        //     'uri'   => 'notice',
                        // ],

                    ],
                ],
                [
                    'label' => '功能',
                    'icon'  => 'ion-ios-keypad',
                    'submenus' => [
                        [
                            'label' => '粉丝管理',
                            'uri'   => 'fan',
                        ],
                        [
                            'label' => '素材管理',
                            'uri'   => 'material',
                        ],
                        [
                            'label' => '自定义菜单',
                            'uri'   => 'menu',
                        ],
                        [
                            'label' => '自动回复',
                            'uri'   => 'auto-reply',
                        ],
                        // [
                        //     'label' => '摇一摇周边',
                        //     'uri'   => 'shake',
                        // ],
                        [
                            'label' => '客服管理',
                            'uri'   => 'staff',
                        ],
                    ],
                ],
                [
                    'label' => '数据统计',
                    'icon'  => 'ion-ios-pulse-strong',
                    'submenus' => [
                        [
                            'label' => '粉丝',
                            'uri'   => 'analysis/fan',
                        ],
                        [
                            'label' => '图文',
                            'uri'   => 'analysis/article',
                        ],
                        [
                            'label' => '消息',
                            'uri'   => 'analysis/message',
                        ],
                        [
                            'label' => '接口',
                            'uri'   => 'analysis/api',
                        ],
                    ],
                ],
            ],
        ],

        $card,

        $store,
    ],
];