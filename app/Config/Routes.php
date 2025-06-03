<?php
// app/Config/Routes.php

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
$routes->post('/testimonial/submit', 'Testimonial::submit');

// About Routes
$routes->get('/tentang-kami', 'About::index');

// Contact Routes
$routes->get('/kontak', 'Contact::index');
$routes->post('/kontak/send', 'Contact::send');

// ========================================
// ADMIN ROUTES
// ========================================

// Admin Auth Routes (TANPA namespace untuk sementara)
$routes->get('admin/login', 'Admin\Auth::login');
$routes->post('admin/authenticate', 'Admin\Auth::authenticate');  // INI YANG PENTING!
$routes->get('admin/logout', 'Admin\Auth::logout');
$routes->get('admin/forgot-password', 'Admin\Auth::forgotPassword');
$routes->post('admin/send-reset', 'Admin\Auth::sendResetPassword');

// Admin Protected Routes
$routes->group('admin', function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('', 'Admin\Dashboard::index'); // /admin redirect to dashboard
    $routes->post('dashboard/refresh-stats', 'Admin\Dashboard::refreshStats');

    // Services Management
    $routes->get('services', 'Admin\Services::index');
    $routes->get('services/create', 'Admin\Services::create');
    $routes->post('services/store', 'Admin\Services::store');
    $routes->get('services/edit/(:num)', 'Admin\Services::edit/$1');
    $routes->post('services/update/(:num)', 'Admin\Services::update/$1');
    $routes->delete('services/delete/(:num)', 'Admin\Services::delete/$1');

    // Blog Management
    $routes->group('blog', function ($routes) {
        // Posts Management
        $routes->get('posts', 'Admin\BlogPosts::index');
        $routes->get('posts/create', 'Admin\BlogPosts::create');
        $routes->post('posts/store', 'Admin\BlogPosts::store');
        $routes->get('posts/edit/(:num)', 'Admin\BlogPosts::edit/$1');
        $routes->post('posts/update/(:num)', 'Admin\BlogPosts::update/$1');
        $routes->delete('posts/delete/(:num)', 'Admin\BlogPosts::delete/$1');

        // Additional Blog Posts Routes
        $routes->post('posts/bulk-action', 'Admin\BlogPosts::bulkAction');
        $routes->post('posts/toggle-publish/(:num)', 'Admin\BlogPosts::togglePublish/$1');
        $routes->post('posts/duplicate/(:num)', 'Admin\BlogPosts::duplicate/$1');
        $routes->post('posts/auto-save/(:num)', 'Admin\BlogPosts::autoSave/$1');
        $routes->get('posts/stats', 'Admin\BlogPosts::getStats');
        $routes->get('posts/search', 'Admin\BlogPosts::search');
        $routes->get('posts/export', 'Admin\BlogPosts::export');
        $routes->post('posts/import', 'Admin\BlogPosts::import');
        $routes->get('posts/backup', 'Admin\BlogPosts::backup');
        $routes->post('posts/restore', 'Admin\BlogPosts::restore');

        // Categories Management
        $routes->get('categories', 'Admin\BlogCategories::index');
        $routes->get('categories/create', 'Admin\BlogCategories::create');
        $routes->post('categories/store', 'Admin\BlogCategories::store');
        $routes->get('categories/edit/(:num)', 'Admin\BlogCategories::edit/$1');
        $routes->post('categories/update/(:num)', 'Admin\BlogCategories::update/$1');
        $routes->delete('categories/delete/(:num)', 'Admin\BlogCategories::delete/$1');

        // Additional Category Routes
        $routes->post('categories/bulk-action', 'Admin\BlogCategories::bulkAction');
        $routes->get('categories/stats', 'Admin\BlogCategories::getStats');
        $routes->get('categories/search', 'Admin\BlogCategories::search');
    });

    // FAQ Management
    $routes->group('faq', function ($routes) {
        // Questions
        $routes->get('questions', 'Admin\FaqQuestions::index');
        $routes->get('questions/create', 'Admin\FaqQuestions::create');
        $routes->post('questions/store', 'Admin\FaqQuestions::store');
        $routes->get('questions/edit/(:num)', 'Admin\FaqQuestions::edit/$1');
        $routes->post('questions/update/(:num)', 'Admin\FaqQuestions::update/$1');
        $routes->delete('questions/delete/(:num)', 'Admin\FaqQuestions::delete/$1');

        // Additional FAQ Routes
        $routes->post('questions/bulk-action', 'Admin\FaqQuestions::bulkAction');
        $routes->post('questions/toggle-active/(:num)', 'Admin\FaqQuestions::toggleActive/$1');
        $routes->get('questions/stats', 'Admin\FaqQuestions::getStats');
        $routes->get('questions/search', 'Admin\FaqQuestions::search');

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

    // Additional Testimonial Routes
    $routes->post('testimonials/bulk-action', 'Admin\Testimonials::bulkAction');
    $routes->post('testimonials/toggle-publish/(:num)', 'Admin\Testimonials::togglePublish/$1');
    $routes->post('testimonials/toggle-featured/(:num)', 'Admin\Testimonials::toggleFeatured/$1');
    $routes->get('testimonials/stats', 'Admin\Testimonials::getStats');
    $routes->get('testimonials/search', 'Admin\Testimonials::search');
    $routes->get('testimonials/export', 'Admin\Testimonials::export');

    // Contact Messages
    $routes->get('contact', 'Admin\ContactMessages::index');
    $routes->get('contact/(:num)', 'Admin\ContactMessages::show/$1');
    $routes->post('contact/update-status/(:num)', 'Admin\ContactMessages::updateStatus/$1');
    $routes->delete('contact/delete/(:num)', 'Admin\ContactMessages::delete/$1');

    // Additional Contact Routes
    $routes->post('contact/bulk-action', 'Admin\ContactMessages::bulkAction');
    $routes->post('contact/mark-read/(:num)', 'Admin\ContactMessages::markAsRead/$1');
    $routes->get('contact/stats', 'Admin\ContactMessages::getStats');
    $routes->get('contact/search', 'Admin\ContactMessages::search');
    $routes->get('contact/export', 'Admin\ContactMessages::export');

    // Settings
    $routes->group('settings', function ($routes) {
        $routes->get('/', 'Admin\Settings::index');
        $routes->get('general', 'Admin\Settings::general');
        $routes->get('seo', 'Admin\Settings::seo');
        $routes->get('email', 'Admin\Settings::email');
        $routes->get('social', 'Admin\Settings::social');
        $routes->get('backup', 'Admin\Settings::backup');
        $routes->post('update', 'Admin\Settings::update');
        $routes->post('backup-database', 'Admin\Settings::backupDatabase');
        $routes->post('restore-database', 'Admin\Settings::restoreDatabase');
        $routes->post('clear-cache', 'Admin\Settings::clearCache');
    });

    // Pages Management
    $routes->get('pages', 'Admin\Pages::index');
    $routes->get('pages/create', 'Admin\Pages::create');
    $routes->post('pages/store', 'Admin\Pages::store');
    $routes->get('pages/edit/(:num)', 'Admin\Pages::edit/$1');
    $routes->post('pages/update/(:num)', 'Admin\Pages::update/$1');
    $routes->delete('pages/delete/(:num)', 'Admin\Pages::delete/$1');

    // Additional Pages Routes
    $routes->post('pages/bulk-action', 'Admin\Pages::bulkAction');
    $routes->post('pages/toggle-publish/(:num)', 'Admin\Pages::togglePublish/$1');
    $routes->get('pages/search', 'Admin\Pages::search');

    // Users Management
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->delete('users/delete/(:num)', 'Admin\Users::delete/$1');

    // Additional Users Routes
    $routes->post('users/bulk-action', 'Admin\Users::bulkAction');
    $routes->post('users/toggle-active/(:num)', 'Admin\Users::toggleActive/$1');
    $routes->post('users/reset-password/(:num)', 'Admin\Users::resetPassword/$1');
    $routes->get('users/profile', 'Admin\Users::profile');
    $routes->post('users/update-profile', 'Admin\Users::updateProfile');

    // Media Management
    $routes->group('media', function ($routes) {
        $routes->get('images', 'Admin\Media::images');
        $routes->get('upload', 'Admin\Media::upload');
        $routes->post('upload', 'Admin\Media::doUpload');
        $routes->delete('delete/(:segment)', 'Admin\Media::delete/$1');

        // Additional Media Routes
        $routes->post('bulk-upload', 'Admin\Media::bulkUpload');
        $routes->post('bulk-delete', 'Admin\Media::bulkDelete');
        $routes->get('gallery', 'Admin\Media::gallery');
        $routes->post('organize', 'Admin\Media::organize');
        $routes->get('stats', 'Admin\Media::getStats');
    });

    // Analytics & Reports
    $routes->group('analytics', function ($routes) {
        $routes->get('/', 'Admin\Analytics::index');
        $routes->get('posts', 'Admin\Analytics::posts');
        $routes->get('visitors', 'Admin\Analytics::visitors');
        $routes->get('search-keywords', 'Admin\Analytics::searchKeywords');
        $routes->get('performance', 'Admin\Analytics::performance');
        $routes->get('export', 'Admin\Analytics::export');
    });

    // Tools & Utilities
    $routes->group('tools', function ($routes) {
        $routes->get('/', 'Admin\Tools::index');
        $routes->get('seo-checker', 'Admin\Tools::seoChecker');
        $routes->post('check-seo', 'Admin\Tools::checkSeo');
        $routes->get('link-checker', 'Admin\Tools::linkChecker');
        $routes->post('check-links', 'Admin\Tools::checkLinks');
        $routes->get('image-optimizer', 'Admin\Tools::imageOptimizer');
        $routes->post('optimize-images', 'Admin\Tools::optimizeImages');
        $routes->get('sitemap-generator', 'Admin\Tools::sitemapGenerator');
        $routes->post('generate-sitemap', 'Admin\Tools::generateSitemap');
    });

    // System Maintenance
    $routes->group('system', function ($routes) {
        $routes->get('/', 'Admin\System::index');
        $routes->get('logs', 'Admin\System::logs');
        $routes->get('logs/view/(:segment)', 'Admin\System::viewLog/$1');
        $routes->delete('logs/clear', 'Admin\System::clearLogs');
        $routes->get('cache', 'Admin\System::cache');
        $routes->post('cache/clear', 'Admin\System::clearCache');
        $routes->get('database', 'Admin\System::database');
        $routes->post('database/optimize', 'Admin\System::optimizeDatabase');
        $routes->get('info', 'Admin\System::phpInfo');
    });
});

// Debug routes (hanya untuk development)
if (ENVIRONMENT !== 'production') {
    $routes->get('admin/debug/routes', function () {
        $routes = \Config\Services::routes();
        $collection = $routes->getRoutes();
        echo '<pre>';
        foreach ($collection as $route => $handler) {
            echo $route . ' => ' . $handler . "\n";
        }
        echo '</pre>';
    });

    $routes->get('admin/debug/check-user', 'Admin\Auth::checkUser');
    $routes->get('admin/debug/create-user', 'Admin\Auth::createTestUser');
    $routes->get('admin/debug/session', 'Admin\Auth::sessionInfo');
    $routes->get('admin/debug/test-blog', 'Admin\BlogPosts::test');
}

// API Routes untuk structured data dan AJAX
$routes->group('api/v1', function ($routes) {
    // Services API
    $routes->get('services', 'Services::getServicesJson');
    $routes->get('services/(:segment)', 'Services::getServiceJson/$1');

    // Blog API
    $routes->get('blog/posts', 'Blog::getPostsJson');
    $routes->get('blog/categories', 'Blog::getCategoriesJson');
    $routes->get('blog/post/(:segment)', 'Blog::getPostJson/$1');
    $routes->post('blog/increment-view/(:num)', 'Blog::incrementView/$1');

    // Testimonials API
    $routes->get('testimonials', 'Testimonial::getTestimonialsJson');
    $routes->get('testimonials/featured', 'Testimonial::getFeaturedJson');
    $routes->get('testimonials/stats', 'Testimonial::getStats');

    // FAQs API
    $routes->get('faqs', 'FAQ::getFaqsJson');
    $routes->get('faqs/categories', 'FAQ::getCategoriesJson');
    $routes->get('faqs/category/(:segment)', 'FAQ::getFaqsJson/$1');
    $routes->get('faqs/popular', 'FAQ::getPopularJson');

    // Contact API
    $routes->post('contact', 'Contact::send');

    // Search API
    $routes->get('search', 'Api\Search::index');
    $routes->get('search/suggestions', 'Api\Search::suggestions');

    // Schema API for SEO
    $routes->get('schema/organization', 'Api\Schema::organization');
    $routes->get('schema/services', 'Api\Schema::services');
    $routes->get('schema/reviews', 'Api\Schema::reviews');
    $routes->get('schema/faqs', 'Api\Schema::faqs');
    $routes->get('schema/breadcrumbs', 'Api\Schema::breadcrumbs');
});

// Admin API Routes (protected)
$routes->group('api/admin', function ($routes) {
    // Dashboard Stats
    $routes->get('stats', 'Admin\Api::getStats');
    $routes->get('recent-activity', 'Admin\Api::getRecentActivity');

    // Quick Actions
    $routes->post('quick-publish/(:num)', 'Admin\Api::quickPublish/$1');
    $routes->post('quick-draft/(:num)', 'Admin\Api::quickDraft/$1');
    $routes->post('quick-delete/(:num)', 'Admin\Api::quickDelete/$1');

    // Search
    $routes->get('search', 'Admin\Api::search');
    $routes->get('search/posts', 'Admin\Api::searchPosts');
    $routes->get('search/pages', 'Admin\Api::searchPages');
    $routes->get('search/users', 'Admin\Api::searchUsers');

    // File Manager
    $routes->get('files', 'Admin\Api::getFiles');
    $routes->post('files/upload', 'Admin\Api::uploadFile');
    $routes->delete('files/(:segment)', 'Admin\Api::deleteFile/$1');
});

// SEO dan Utility Routes
$routes->get('sitemap.xml', 'Sitemap::index');
$routes->get('robots.txt', 'Robots::index');
$routes->get('feed.xml', 'Blog::rss'); // RSS feed alias
$routes->get('atom.xml', 'Blog::atom'); // Atom feed

// Advanced SEO Routes
$routes->get('sitemap-blog.xml', 'Blog::sitemap');
$routes->get('sitemap-services.xml', 'Services::sitemap');
$routes->get('sitemap-pages.xml', 'Pages::sitemap');

// Progressive Web App Routes
$routes->get('manifest.json', 'Pwa::manifest');
$routes->get('sw.js', 'Pwa::serviceWorker');

// Health Check & Monitoring
$routes->get('health', 'System::health');
$routes->get('status', 'System::status');

// Catch-all untuk dynamic pages (harus di paling bawah)
// $routes->get('(:segment)', 'Pages::show/$1');