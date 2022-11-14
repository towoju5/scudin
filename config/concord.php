<?php

return [
    'modules' => [
        Vanilo\Stripe\Providers\ModuleServiceProvider::class,
        Vanilo\Paypal\Providers\ModuleServiceProvider::class,
        Vanilo\Payment\Providers\ModuleServiceProvider::class,
        Vanilo\Shipment\Providers\ModuleServiceProvider::class,
        Vanilo\Adjustments\Providers\ModuleServiceProvider::class,
        Vanilo\Adjustments\Providers\ModuleServiceProvider::class,
        Vanilo\Foundation\Providers\ModuleServiceProvider::class => [
            'image' => [
                'variants' => [
                    'thumbnail' => [
                        'width'  => 250,
                        'height' => 188,
                        'fit' => 'fill'
                    ],
                    'medium' => [
                        'width'  => 540,
                        'height' => 406,
                        'fit' => 'fill'
                    ]
                ]
            ],
        ]
    ],
    'register_route_models' => true
];
