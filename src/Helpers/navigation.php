<?php
use Illuminate\Support\Facades\Route;

function navigation()
{
    $admin = auth('admin')->user();

    if ($admin && str(request()->path())->startsWith('backend')) {
        $navigatorCms = [
            'title' => env('APP_NAME'),
            'logo' => '/images/logo.svg',
            'link' => '/',
            'sections' => [
                [
                    'title' => 'Dashboard',
                    'href' => route('dashboard.index'),
                    'icon' => 'fa-table-columns',
                    'type' => 'menu',
                    'permission' => 'View Dashboard',
                    'menus' => [],
                ],
                [
                    'title' => 'Static Pages',
                    'href' => route('page.index'),
                    'icon' => 'fa-file',
                    'type' => 'menu',
                    'permission' => 'View Page',
                    'menus' => [],
                ],
            ],
        ];

        if (Route::has('product.index')) {
            $menus = [
                [
                    'title' => 'Product Catalog',
                    'href' => route('product.index'),
                    'icon' => 'fa-box-archive',
                    'type' => 'menu',
                    'permission' => 'View Product',
                    'menus' => [],
                ]
            ];

            if (Route::has('product-category.index')) {
                $menus[] = [
                    'title' => 'Product Category',
                    'href' => route('product-category.index'),
                    'icon' => 'fa-puzzle-piece',
                    'type' => 'menu',
                    'permission' => 'View Product Category',
                    'menus' => [],
                ];
            }

            $navigatorCms['sections'][] = [
                'title' => 'Product',
                'icon' => 'fa-box-archive',
                'type' => 'header',
                'permission' => 'View Product',
                'menus' => $menus,
            ];
        }

        if (Route::has('article.index')) {
            $menus = [
                [
                    'title' => 'Article',
                    'href' => route('article.index'),
                    'icon' => 'fa-newspaper',
                    'type' => 'menu',
                    'permission' => 'View Article',
                    'menus' => [],
                ]
            ];

            if (Route::has('tag.index')) {
                $menus[] = [
                    'title' => 'Tag',
                    'href' => route('tag.index'),
                    'icon' => 'fa-tag',
                    'type' => 'menu',
                    'permission' => 'View Tag',
                    'menus' => [],
                ];
            }

            $navigatorCms['sections'][] = [
                'title' => 'Article',
                'type' => 'header',
                'icon' => 'fa-newspaper',
                'permission' => 'View Article',
                'menus' => $menus,
            ];
        }

        if (Route::has('contact-submission.index')) {
            $navigatorCms['sections'][] = [
                'title' => 'Contact Submission',
                'href' => route('contact-submission.index'),
                'icon' => 'fa-envelope',
                'type' => 'menu',
                'permission' => 'View Contact Submission',
                'menus' => [],
            ];
        }

        // Settings Header
        $navigatorCms['sections'][] = [
            'icon' => 'fa-cog',
            'title' => 'Settings',
            'type' => 'header',
            'permission' => null, // biar tetap muncul
            'menus' => [],
        ];

        if (Route::has('menu.index')) {
            $navigatorCms['sections'][] = [
                'title' => 'Menu',
                'href' => route('menu.index'),
                'icon' => 'fa-bars',
                'type' => 'menu',
                'permission' => 'View Menu',
                'menus' => [],
            ];
        }

        if (Route::has('administrator.index')) {
            $navigatorCms['sections'][] = [
                'title' => 'Administrator',
                'href' => route('administrator.index'),
                'icon' => 'fa-user-secret',
                'type' => 'menu',
                'permission' => 'View User',
                'menus' => [],
            ];
            $navigatorCms['sections'][] = [
                'title' => 'Member',
                'href' => route('user.index'),
                'icon' => 'fa-user',
                'type' => 'menu',
                'permission' => 'View User',
                'menus' => [],
            ];
        }

        /**
         * Filter sections and their menus recursively.
         */
        $filterSections = function ($sections) use (&$filterSections, $admin) {
            return collect($sections)->filter(function ($section) use ($admin, $filterSections) {
                $hasPermission = true;

                if (isset($section['permission']) && $section['permission']) {
                    $hasPermission = false;
                    $checks = explode('|', $section['permission']);

                    $role = $admin->roles->first(); // You can adapt for multi-role
                    foreach ($checks as $check) {
                        try {
                            if ($role && $role->hasPermissionTo(trim($check))) {
                                $hasPermission = true;
                                break;
                            }
                        } catch (\Spatie\Permission\Exceptions\PermissionDoesNotExist $e) {
                            continue;
                        }
                    }
                }

                // Jika tidak punya permission, skip
                if (! $hasPermission) return false;

                // Filter nested menus
                if (!empty($section['menus'])) {
                    $section['menus'] = $filterSections($section['menus']);
                }

                // Jika ada 'menus' dan kosong setelah difilter, dan type header, bisa tetap ditampilkan
                return true;
            })->values()->all();
        };

        // Apply filter
        $navigatorCms['sections'] = $filterSections($navigatorCms['sections']);

        return $navigatorCms;
    }
}
