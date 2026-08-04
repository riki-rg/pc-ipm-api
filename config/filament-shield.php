<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Shield Resource
    |--------------------------------------------------------------------------
    */
    'shield_resource' => [
        'should_register_navigation' => true,
        'slug' => 'shield/roles',
        'navigation_sort' => -1,
        'navigation_badge' => true,
        'navigation_group' => 'Pengaturan Akses',
        'sub_navigation_position' => null,
        'is_globally_searchable' => false,
        'show_model_path' => false,
        'is_scoped_to_tenant' => false,
        'cluster' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Model Pengguna (Auth Provider)
    |--------------------------------------------------------------------------
    */
    'auth_provider_model' => [
        'fqcn' => App\Models\User::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Panel Aktif Shield
    |--------------------------------------------------------------------------
    */
    'panel' => 'admin', // <- tambahkan ini biar Shield tau panel aktif lo

    /*
    |--------------------------------------------------------------------------
    | Role Super Admin
    |--------------------------------------------------------------------------
    */
    'super_admin' => [
        'enabled' => true,
        'name' => 'super_admin',
        'define_via_gate' => false,
        'intercept_gate' => 'before',
    ],

    /*
    |--------------------------------------------------------------------------
    | Role Default untuk Semua Pengguna Filament
    |--------------------------------------------------------------------------
    */
    'panel_user' => [
        'enabled' => true,
        'name' => 'panel_user',
    ],

    /*
    |--------------------------------------------------------------------------
    | Prefix Permission
    |--------------------------------------------------------------------------
    */
    'permission_prefixes' => [
        'resource' => [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
        ],
        'page' => 'page',
        'widget' => 'widget',
    ],

    /*
    |--------------------------------------------------------------------------
    | Entitas Yang Akan Digenerate
    |--------------------------------------------------------------------------
    */
    'entities' => [
        'pages' => true,
        'widgets' => true,
        'resources' => true,
        'custom_permissions' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Generator Policy & Permission
    |--------------------------------------------------------------------------
    */
    'generator' => [
        'option' => 'policies_and_permissions',
        'policy_directory' => 'Policies',
        'policy_namespace' => 'Policies',
    ],

    /*
    |--------------------------------------------------------------------------
    | Exclude / Skip Permission Untuk Halaman atau Widget Tertentu
    |--------------------------------------------------------------------------
    */
    'exclude' => [
        'enabled' => true,
        'pages' => [
            'Dashboard',
        ],
        'widgets' => [
            'AccountWidget', 'FilamentInfoWidget',
        ],
        'resources' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto Discovery
    |--------------------------------------------------------------------------
    */
    'discovery' => [
        'discover_all_resources' => true, // true biar Shield scan semua Resource lo
        'discover_all_widgets' => false,
        'discover_all_pages' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Role Policy Registration
    |--------------------------------------------------------------------------
    */
    'register_role_policy' => [
        'enabled' => true,
    ],
];
