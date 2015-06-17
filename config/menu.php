<?php

$card = [

    'group' => 'card',
    'label' => '卡券',
    'collection' => [
        [
            'label' => '卡券管理',
            'uri'   => 'card',
            'icon'  => 'ion-ios-photos',
            'submenus' => [
                [
                    'label' => '全部卡券',
                    'uri'   => 'lists',
                ],
                [
                    'label' => '应用中心',
                    'uri'   => 'shop',
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
            'uri'   => 'card',
            'icon'  => 'ion-ios-list',
            'submenus' => [
                [
                    'label' => '全部订单',
                    'uri'   => 'lists',
                ],
            ],
        ],
        [
            'label' => '商品管理',
            'uri'   => 'goods',
            'icon'  => 'ion-ios-football',
            'submenus' => [
                [
                    'label' => '全部商品',
                    'uri'   => 'lists',
                ],
                [
                    'label' => '货架管理',
                    'uri'   => 'shelf',
                ],
                [
                    'label' => '商品分组',
                    'uri'   => 'group',
                ],
                [
                    'label' => '邮费模板',
                    'uri'   => 'postage-template',
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
            'uri'   => 'apps',
            'icon'  => 'ion-ios-game-controller-b',
            'submenus' => [
                [
                    'label' => '我的应用',
                    'uri'   => 'mine',
                ],
                [
                    'label' => '应用中心',
                    'uri'   => 'shop',
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
                    'uri'   => 'account',
                    'icon'  => 'ion-social-whatsapp',
                    'submenus' => [
                        [
                            'label' => '公众号管理',
                            'uri'   => '',
                        ],
                        [
                            'label' => '新增公众号',
                            'uri'   => 'create',
                        ],
                    ],
                ],
                [
                    'label' => '管理员',
                    'uri'   => 'user',
                    'icon'  => 'ion-android-people',
                    'submenus' => [
                        [
                            'label' => '密码修改',
                            'uri'   => 'password',
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

                    ],
                ],
                [
                    'label' => '粉丝管理',
                    'uri'   => 'fan',
                    'icon'  => 'ion-ios-people',
                    'submenus' => [
                        [
                            'label' => '全部粉丝',
                            'uri'   => '',
                        ],
                        [
                            'label' => '粉丝标签',
                            'uri'   => 'tags',
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
                            'uri'   => 'article',
                        ],
                        [
                            'label' => '素材管理',
                            'uri'   => 'material',
                        ],
                    ],
                ],
                [
                    'label' => '工具',
                    'uri'   => 'tools',
                    'icon'  => 'ion-ios-color-wand',
                    'submenus' => [
                        [
                            'label' => '短链接',
                            'uri'   => 'short-url',
                        ],
                        [
                            'label' => '二维码',
                            'uri'   => 'qrcode',
                        ],
                    ],
                ],
                [
                    'label' => '客服',
                    'uri'   => 'staff',
                    'icon'  => 'ion-ios-cog',
                    'submenus' => [
                        [
                            'label' => '客服管理',
                            'uri'   => 'lists',
                        ],
                        [
                            'label' => '绩效查询',
                            'uri'   => 'staff',
                        ],
                    ],
                ],
                [
                    'label' => '账号与服务',
                    'uri'   => 'services',
                    'icon'  => 'ion-ios-cog',
                    'submenus' => [
                         [
                            'label' => '自定义菜单',
                            'uri'   => 'menu',
                        ],
                        [
                            'label' => '自动回复',
                            'uri'   => 'auto-reply',
                        ],
                        [
                            'label' => '摇一摇周边',
                            'uri'   => 'shake',
                        ],
                    ],
                ],
                [
                    'label' => '数据统计',
                    'uri'   => 'data',
                    'icon'  => 'ion-ios-pulse-strong',
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
            ],
        ],

        $card,

        $store,
    ],
];