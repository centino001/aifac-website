<?php

/**
 * Assignable admin sidebar permissions.
 * Super admins bypass these and always see everything.
 * "profile" is available to every admin user and is not assignable.
 */
return [
    'dashboard' => [
        'label' => 'Dashboard',
        'route' => 'admin.dashboard',
        'path' => '/admin/dashboard',
    ],
    'projects' => [
        'label' => 'Manage Projects',
        'route' => 'admin.projects',
        'path' => '/admin/projects',
    ],
    'news' => [
        'label' => 'Manage News',
        'route' => 'admin.news',
        'path' => '/admin/news',
    ],
    'people' => [
        'label' => 'Manage People',
        'route' => 'admin.people',
        'path' => '/admin/people',
    ],
    'ticket_records' => [
        'label' => 'Ticket Records',
        'route' => 'admin.ticket-records',
        'path' => '/admin/ticket-records',
    ],
    'ticket_checkin' => [
        'label' => 'Ticket Check-In',
        'route' => 'admin.tickets',
        'path' => '/admin/tickets',
    ],
    'manage_staff' => [
        'label' => 'Manage Staff',
        'route' => 'admin.staff',
        'path' => '/admin/staff',
    ],
];
