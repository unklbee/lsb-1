<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Homepage
$routes->get('/', 'Home::index');

// Services Routes
$routes->get('/layanan', 'Services::index');
$routes->get('/layanan/(:segment)', 'Services::detail/$1');

// Blog Routes
$routes->get('/blog', 'Blog::index');
$routes->get('/blog/page/(:num)', 'Blog::page/$1');
$routes->get('/blog/category/(:segment)', 'Blog::category/$1');
$routes->get('/blog/search', 'Blog::search');
$routes->get('/blog/rss', 'Blog::rss');
$routes->get('/blog/sitemap', 'Blog::sitemap');
$routes->get('/blog/(:segment)', 'Blog::detail/$1');

// FAQ Routes
$routes->get('/faq', 'FAQ::index');
$routes->get('/faq/category/(:segment)', 'FAQ::category/$1');
$routes->get('/faq/search', 'FAQ::search');
$routes->get('/faq/popular', 'FAQ::popular');
$routes->post('/faq/increment-view/(:num)', 'FAQ::incrementView/$1');
$routes->post('/faq/submit-question', 'FAQ::submitQuestion');

// Testimonial Routes
$routes->get('/testimonial', 'Testimonial::index');

// About Routes
$routes->get('/tentang-kami', 'About::index');

// Contact Routes
$routes->get('/kontak', 'Contact::index');
$routes->post('/kontak/send', 'Contact::send');

// Admin Routes
$routes->group('admin', function($routes) {
    // Auth Routes
    $routes->get('login', 'Admin\Auth::login');
    $routes->post('auth/login','Admin\Auth::authenticate');
    $routes->get('logout', 'Admin\Auth::logout');

    // Dashboard
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // Services Management
    $routes->get('services', 'Admin\Services::index');
    $routes->get('services/create', 'Admin\Services::create');
    $routes->post('services/store', 'Admin\Services::store');
    $routes->get('services/edit/(:num)', 'Admin\Services::edit/$1');
    $routes->post('services/update/(:num)', 'Admin\Services::update/$1');
    $routes->delete('services/delete/(:num)', 'Admin\Services::delete/$1');

    // Blog Management
    $routes->group('blog', function($routes) {
        // Posts
        $routes->get('posts', 'Admin\BlogPosts::index');
        $routes->get('posts/create', 'Admin\BlogPosts::create');
        $routes->post('posts/store', 'Admin\BlogPosts::store');
        $routes->get('posts/edit/(:num)', 'Admin\BlogPosts::edit/$1');
        $routes->post('posts/update/(:num)', 'Admin\BlogPosts::update/$1');
        $routes->delete('posts/delete/(:num)', 'Admin\BlogPosts::delete/$1');

        // Categories
        $routes->get('categories', 'Admin\BlogCategories::index');
        $routes->get('categories/create', 'Admin\BlogCategories::create');
        $routes->post('categories/store', 'Admin\BlogCategories::store');
        $routes->get('categories/edit/(:num)', 'Admin\BlogCategories::edit/$1');
        $routes->post('categories/update/(:num)', 'Admin\BlogCategories::update/$1');
        $routes->delete('categories/delete/(:num)', 'Admin\BlogCategories::delete/$1');
    });

    // FAQ Management
    $routes->group('faq', function($routes) {
        // Questions
        $routes->get('questions', 'Admin\FaqQuestions::index');
        $routes->get('questions/create', 'Admin\FaqQuestions::create');
        $routes->post('questions/store', 'Admin\FaqQuestions::store');
        $routes->get('questions/edit/(:num)', 'Admin\FaqQuestions::edit/$1');
        $routes->post('questions/update/(:num)', 'Admin\FaqQuestions::update/$1');
        $routes->delete('questions/delete/(:num)', 'Admin\FaqQuestions::delete/$1');

        // Categories
        $routes->get('categories', 'Admin\FaqCategories::index');
        $routes->get('categories/create', 'Admin\FaqCategories::create');
        $routes->post('categories/store', 'Admin\FaqCategories::store');
        $routes->get('categories/edit/(:num)', 'Admin\FaqCategories::edit/$1');
        $routes->post('categories/update/(:num)', 'Admin\FaqCategories::update/$1');
        $routes->delete('categories/delete/(:num)', 'Admin\FaqCategories::delete/$1');
    });

    // Testimonials Management
    $routes->get('testimonials', 'Admin\Testimonials::index');
    $routes->get('testimonials/create', 'Admin\Testimonials::create');
    $routes->post('testimonials/store', 'Admin\Testimonials::store');
    $routes->get('testimonials/edit/(:num)', 'Admin\Testimonials::edit/$1');
    $routes->post('testimonials/update/(:num)', 'Admin\Testimonials::update/$1');
    $routes->delete('testimonials/delete/(:num)', 'Admin\Testimonials::delete/$1');

    // Contact Messages
    $routes->get('contact', 'Admin\ContactMessages::index');
    $routes->get('contact/(:num)', 'Admin\ContactMessages::show/$1');
    $routes->post('contact/update-status/(:num)', 'Admin\ContactMessages::updateStatus/$1');
    $routes->delete('contact/delete/(:num)', 'Admin\ContactMessages::delete/$1');

    // Settings
    $routes->group('settings', function($routes) {
        $routes->get('/', 'Admin\Settings::index');
        $routes->get('general', 'Admin\Settings::general');
        $routes->get('seo', 'Admin\Settings::seo');
        $routes->get('email', 'Admin\Settings::email');
        $routes->post('update', 'Admin\Settings::update');
    });

    // Pages Management
    $routes->get('pages', 'Admin\Pages::index');
    $routes->get('pages/create', 'Admin\Pages::create');
    $routes->post('pages/store', 'Admin\Pages::store');
    $routes->get('pages/edit/(:num)', 'Admin\Pages::edit/$1');
    $routes->post('pages/update/(:num)', 'Admin\Pages::update/$1');
    $routes->delete('pages/delete/(:num)', 'Admin\Pages::delete/$1');

    // Users Management
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->delete('users/delete/(:num)', 'Admin\Users::delete/$1');

    // Media Management
    $routes->group('media', function($routes) {
        $routes->get('images', 'Admin\Media::images');
        $routes->get('upload', 'Admin\Media::upload');
        $routes->post('upload', 'Admin\Media::doUpload');
        $routes->delete('delete/(:segment)', 'Admin\Media::delete/$1');
    });
});

// API Routes untuk structured data dan AJAX
$routes->group('api/v1', function($routes) {
    // Services API
    $routes->get('services', 'Services::getServicesJson');
    $routes->get('services/(:segment)', 'Services::getServiceJson/$1');

    // Testimonials API
    $routes->get('testimonials', 'Api\Testimonials::index');
    $routes->get('testimonials/featured', 'Api\Testimonials::featured');

    // FAQs API
    $routes->get('faqs', 'FAQ::getFaqsJson');
    $routes->get('faqs/categories', 'FAQ::getCategoriesJson');
    $routes->get('faqs/category/(:segment)', 'FAQ::getFaqsJson/$1');

    // Contact API
    $routes->post('contact', 'Api\Contact::send');

    // Schema API
    $routes->get('schema/organization', 'Api\Schema::organization');
    $routes->get('schema/services', 'Api\Schema::services');
    $routes->get('schema/reviews', 'Api\Schema::reviews');
});

// SEO dan Utility Routes
$routes->get('sitemap.xml', 'Sitemap::index');
$routes->get('robots.txt', 'Robots::index');

// Catch-all untuk dynamic pages (harus di paling bawah)
//$routes->get('(:segment)', 'Pages::show/$1');