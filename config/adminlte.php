<?php

return [

    'title' => 'Tagabi',
    'title_prefix' => '',
    'title_postfix' => '',

    'use_ico_only' => true,
    'use_full_favicon' => false,

    'google_fonts' => [
        'allowed' => true,
    ],

    'logo' => '<b>Tagabi</b>PY',
    'logo_img' => 'images/logo_tagabi.jpg',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Tagabi Tienda',

    'auth_logo' => [
        'enabled' => true,
        'img' => [
            'path' => 'images/logo_tagabi.jpg',
            'alt' => 'Tagabi',
            'class' => '',
            'width' => 100,
            'height' => 100,
        ],
    ],

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'images/logo_tagabi.jpg',
            'alt' => 'Tagabi',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    'menu' => [
        [
            'text' => 'Dashboard',
            'url'  => 'dashboard',
            'icon' => 'fas fa-tachometer-alt',
        ],
        [
            'text' => 'Clientes',
            'url'  => 'clientes',
            'icon' => 'fas fa-users',
        ],
        [
            'text' => 'Ventas',
            'icon' => 'fas fa-shopping-cart',
            'submenu' => [
                [
                    'text' => 'Registrar Venta',
                    'url'  => 'ventas/create',
                    'icon' => 'fas fa-cash-register',
                ],
                [
                    'text' => 'Histórico de Ventas',
                    'url'  => 'ventas',
                    'icon' => 'fas fa-chart-line',
                ],
            ],
        ],
        [
            'text' => 'Inventario',
            'icon' => 'fas fa-boxes',
            'submenu' => [
                [
                    'text' => 'Productos',
                    'url'  => 'productos',
                    'icon' => 'fas fa-box',
                ],
                [
                    'text' => 'Categorías',
                    'url'  => 'categorias',
                    'icon' => 'fas fa-tags',
                ],
            ],
        ],
        [
            'text' => 'Recompensas',
            'url'  => 'recompensas',
            'icon' => 'fas fa-gift',
        ],
        [
    'text' => 'Exportaciones',
    'url'  => 'exportaciones',
    'icon' => 'fas fa-file-excel',
],
        [
            'text'    => 'Configuración',
            'icon'    => 'fas fa-cog',
            'submenu' => [
                [
                    'text' => 'Cambiar contraseña',
                    'url'  => 'password/change',
                    'icon' => 'fas fa-key',
                ],
            ],
        ],
    ],

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    'plugins' => [],

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    'livewire' => false,
];
