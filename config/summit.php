<?php

return [

    /*
    |--------------------------------------------------------------------------
    | GBS2026 Summit Tickets
    |--------------------------------------------------------------------------
    |
    | Server-side source of truth for ticket types and prices. Clients must
    | never set the amount — only ticket_type.
    |
    */

    'tickets' => [
        'full' => [
            'name' => 'Full Summit Pass',
            'price' => 30000,
            'day_label' => '21–22 October 2026',
            'includes' => [
                'Guided tour of New Culture Studios',
                'The Beginning stage play',
                'All three Conversation Circles',
                'Light Refreshment (Day One)',
                'Lunch and snacks on Day Two',
            ],
        ],
        'day_2' => [
            'name' => 'Summit Day Pass',
            'price' => 20000,
            'day_label' => '22 October 2026',
            'includes' => [
                'All three Conversation Circles',
                'Lunch and snacks',
            ],
        ],
        'student' => [
            'name' => 'Student Pass',
            'price' => 15000,
            'day_label' => '21–22 October 2026',
            'includes' => [
                'Guided tour of New Culture Studios',
                'The Beginning stage play',
                'All three Conversation Circles',
                'Lunch and snacks on Day Two',
                'Student identification is required',
            ],
        ],
        'stage_play' => [
            'name' => 'Stage Play Only',
            'price' => 5000,
            'day_label' => '21 October 2026',
            'includes' => [
                'Admission for those who only want to see The Beginning, a stage play adapted and directed by Rufus Nwoko',
            ],
        ],
    ],

];
