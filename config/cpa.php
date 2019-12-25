<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Leads Table
    |--------------------------------------------------------------------------
    |
    | This is the table used by Cpa to save lead info to the database.
    |
    */
    'user_leads_table'  => 'cpa_leads',

    /*
    |--------------------------------------------------------------------------
    | Conversion Table
    |--------------------------------------------------------------------------
    |
    | This is the table used by Cpa to save lead`s conversion to the database.
    |
    */
    'conversions_table' => 'cpa_conversions',

    /*
    |--------------------------------------------------------------------------
    | CPA cookie Table
    |--------------------------------------------------------------------------
    |
    | This is the table used by Cpa to save cookie id to the database.
    |
    */
    'cookies_table' => 'cpa_cookies',

    /*
    |--------------------------------------------------------------------------
    | Lead Model and Guard
    |--------------------------------------------------------------------------
    |
    | This is the Lead model used by Cpa to create correct relations with auth user.
    | Update the lead if it is in a different namespace.
    | e.g. User, Client, Customer models
    */
    'lead_model' => 'App\User',
    'lead_guard' => 'user',

    /*
    |--------------------------------------------------------------------------
    | Cookie life time period
    |--------------------------------------------------------------------------
    |
    | If user not sign in app store cpa source cookie for this time, minutes
    | This time you will get from CPA Network deal, usually 30 days
    |
    */
    'cookie_period' => 30 * 24 * 60,

    /*
    |--------------------------------------------------------------------------
    | Lead sources
    |--------------------------------------------------------------------------
    |
    | Enable or disable cpa networks are you using
    |
    */
    'sources' => [
        'admitad'       => true,
        'credy'         => true,
        'do_affiliate'  => true,
        'fin_line'      => true,
        'lead_gid'      => true,
        'leads_su'      => true,
        'papa_karlo'    => false,
        'sales_doubler' => true,
        'storm_digital' => false,
    ],


    /*
    |--------------------------------------------------------------------------
    | CPA events
    |--------------------------------------------------------------------------
    |
    | Specify events and additional params for concrete CPA network
    | e.g. 'lead', 'purchase', 'register', see documentations
    |
    */
    'events' => [

        'purchase' => [
            'admitad'      => [],
            'credy'        => [],
            'do_affiliate' => [
                'type' => 'CPA',
            ],
            'fin_line' => [
                'goal' => 1,
            ],
            'lead_gid' => [],
            'leads_su' => [
                'goal' => 0,
            ],
            'papa_karlo' => [
                'type'     => 'offer',
                'offer_id' => 1,
            ],
            'sales_doubler' => [],
            'storm_digital' => [
                'goal' => 1,
            ],
        ],

        'register' => [
            'papa_karlo' => [
                'type'    => 'goal',
                'goal_id' => '1',
            ],
            'storm_digital' => [
                'goal' => 3,
            ]
        ],

        'lead' => [
            'papa_karlo' => [
                'type'    => 'goal',
                'goal_id' => '2',
            ],
            'storm_digital' => [
                'goal' => 4,
            ]
        ],
    ],

];