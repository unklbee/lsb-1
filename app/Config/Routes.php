<?php

// app/Config/Routes.php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/layanan', 'Services::index');
$routes->get('/layanan/(:segment)', 'Services::detail/$1');
$routes->get('/blog', 'Blog::index');
$routes->get('/blog/page/(:num)', 'Blog::page/$1');
$routes->get('/blog/category/(:segment)', 'Blog::category/$1');
$routes->get('/blog/search', 'Blog::search');
$routes->get('/blog/rss', 'Blog::rss');
$routes->get('/blog/sitemap', 'Blog::sitemap');
$routes->get('/blog/(:segment)', 'Blog::detail/$1');
$routes->get('/faq', 'Faq::index');
$routes->get('/testimonial', 'Testimonial::index');
$routes->get('/tentang-kami', 'About::index');
$routes->get('/kontak', 'Contact::index');
$routes->post('/kontak/send', 'Contact::send');

// API Routes untuk structured data
$routes->group('api', function($routes) {
    $routes->get('schema/organization', 'Api\Schema::organization');
    $routes->get('schema/services', 'Api\Schema::services');
    $routes->get('schema/reviews', 'Api\Schema::reviews');
});

// Sitemap
$routes->get('sitemap.xml', 'Sitemap::index');
$routes->get('robots.txt', 'Robots::index');