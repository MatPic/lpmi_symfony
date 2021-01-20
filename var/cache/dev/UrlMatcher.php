<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/(fr|en)?(*:178)'
                .'|/(fr|en)/(?'
                    .'|c(?'
                        .'|ontact(*:208)'
                        .'|ategory(?'
                            .'|/([^/]++)(*:235)'
                            .'|(*:243)'
                        .')'
                    .')'
                    .'|boutique(*:261)'
                    .'|panier(?'
                        .'|(*:278)'
                        .'|/([^/]++)(?'
                            .'|(*:298)'
                        .')'
                    .')'
                .')'
            .')/?$}sD',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        178 => [[['_route' => 'index', '_locale' => 'fr', '_controller' => 'App\\Controller\\DefaultController::index'], ['_locale'], null, null, false, true, null]],
        208 => [[['_route' => 'contact', '_locale' => 'fr', '_controller' => 'App\\Controller\\DefaultController::contact'], ['_locale'], null, null, false, false, null]],
        235 => [[['_route' => 'category', '_locale' => 'fr', '_controller' => 'App\\Controller\\CategoryController:detail'], ['_locale', 'id'], null, null, false, true, null]],
        243 => [[['_route' => 'category.search', '_locale' => 'fr', '_controller' => 'App\\Controller\\CategoryController:search'], ['_locale'], null, null, false, false, null]],
        261 => [[['_route' => 'boutique', '_locale' => 'fr', '_controller' => 'App\\Controller\\BoutiqueController::findAll'], ['_locale'], null, null, false, false, null]],
        278 => [[['_route' => 'panier.index', '_locale' => 'fr', '_controller' => 'App\\Controller\\PanierController:index'], ['_locale'], null, null, false, false, null]],
        298 => [
            [['_route' => 'panier.add', '_locale' => 'fr', '_controller' => 'App\\Controller\\PanierController:add'], ['_locale', 'idProduit'], null, null, false, true, null],
            [['_route' => 'panier.remove', '_locale' => 'fr', '_controller' => 'App\\Controller\\PanierController:remove'], ['_locale', 'idProduit'], null, null, false, true, null],
            [['_route' => 'panier.delete', '_locale' => 'fr', '_controller' => 'App\\Controller\\PanierController:delete'], ['_locale', 'idProduit'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
