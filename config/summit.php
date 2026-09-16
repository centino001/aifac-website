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
            'price' => 80000,
            'day_label' => 'October 21–22, 2026',
            'includes' => [
                'Two-day Summit experience',
                'Lunch',
                'Snacks and refreshments',
                'Cultural tour of Ibadan',
                'Theatrical performance',
                'Access to the full programme',
            ],
        ],
        'day_2' => [
            'name' => 'Summit Day Pass',
            'price' => 35000,
            'day_label' => 'October 22, 2026 (Day 2)',
            'includes' => [
                'Full-day Summit experience',
                'Lunch',
                'Snacks and refreshments',
                'Conversation Circles',
                'Artistic and cultural encounters',
            ],
        ],
    ],

];
