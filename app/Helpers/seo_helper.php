<?php

// app/Helpers/seo_helper.php

if (!function_exists('generate_meta_title')) {
    /**
     * Generate SEO optimized meta title
     */
    function generate_meta_title($title, $siteName = 'LaptopService Bandung')
    {
        if (strlen($title) > 60) {
            $title = substr($title, 0, 57) . '...';
        }
        return $title . ' | ' . $siteName;
    }
}

if (!function_exists('generate_meta_description')) {
    /**
     * Generate SEO optimized meta description
     */
    function generate_meta_description($description)
    {
        if (strlen($description) > 160) {
            $description = substr($description, 0, 157) . '...';
        }
        return $description;
    }
}

if (!function_exists('generate_canonical_url')) {
    /**
     * Generate canonical URL
     */
    function generate_canonical_url($path = '')
    {
        return rtrim(base_url($path), '/');
    }
}

if (!function_exists('generate_breadcrumb_schema')) {
    /**
     * Generate breadcrumb structured data
     */
    function generate_breadcrumb_schema($breadcrumbs)
    {
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => []
        ];

        foreach ($breadcrumbs as $index => $breadcrumb) {
            $schema['itemListElement'][] = [
                "@type" => "ListItem",
                "position" => $index + 1,
                "name" => $breadcrumb['name'],
                "item" => $breadcrumb['url']
            ];
        }

        return json_encode($schema, JSON_UNESCAPED_SLASHES);
    }
}

if (!function_exists('generate_article_schema')) {
    /**
     * Generate article structured data
     */
    function generate_article_schema($article)
    {
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "Article",
            "headline" => $article['title'],
            "description" => $article['description'],
            "image" => $article['image'],
            "author" => [
                "@type" => "Person",
                "name" => $article['author']
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => "LaptopService Bandung",
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => base_url('assets/images/logo.png')
                ]
            ],
            "datePublished" => $article['published_date'],
            "dateModified" => $article['modified_date']
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES);
    }
}

if (!function_exists('optimize_image_alt')) {
    /**
     * Generate SEO friendly alt text for images
     */
    function optimize_image_alt($filename, $context = 'service laptop bandung')
    {
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $name = str_replace(['-', '_'], ' ', $name);
        return ucwords($name) . ' - ' . ucwords($context);
    }
}

if (!function_exists('generate_local_business_hours')) {
    /**
     * Generate business hours structured data
     */
    function generate_local_business_hours($hours)
    {
        $daysMapping = [
            'senin' => 'Monday',
            'selasa' => 'Tuesday',
            'rabu' => 'Wednesday',
            'kamis' => 'Thursday',
            'jumat' => 'Friday',
            'sabtu' => 'Saturday',
            'minggu' => 'Sunday'
        ];

        $openingHours = [];
        foreach ($hours as $day => $time) {
            if (isset($daysMapping[$day])) {
                $times = explode(' - ', $time);
                $openingHours[] = [
                    "@type" => "OpeningHoursSpecification",
                    "dayOfWeek" => $daysMapping[$day],
                    "opens" => $times[0],
                    "closes" => $times[1]
                ];
            }
        }

        return $openingHours;
    }
}

if (!function_exists('generate_service_schema')) {
    /**
     * Generate service structured data
     */
    function generate_service_schema($service)
    {
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "Service",
            "name" => $service['name'],
            "description" => $service['description'],
            "provider" => [
                "@type" => "LocalBusiness",
                "name" => "CV. Teknologi Solusi Digital",
                "address" => [
                    "@type" => "PostalAddress",
                    "streetAddress" => "Jl. Soekarno Hatta No. 123",
                    "addressLocality" => "Bandung",
                    "addressRegion" => "Jawa Barat",
                    "postalCode" => "40132",
                    "addressCountry" => "ID"
                ]
            ],
            "areaServed" => [
                "@type" => "City",
                "name" => "Bandung"
            ],
            "serviceType" => $service['type'] ?? "Computer Repair",
            "offers" => [
                "@type" => "Offer",
                "priceRange" => $service['price_range'] ?? "$$"
            ]
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES);
    }
}

if (!function_exists('sanitize_for_schema')) {
    /**
     * Sanitize text for structured data
     */
    function sanitize_for_schema($text)
    {
        // Remove HTML tags
        $text = strip_tags($text);
        // Escape quotes
        $text = str_replace('"', '\"', $text);
        // Remove extra whitespace
        $text = preg_replace('/\s+/', ' ', trim($text));

        return $text;
    }
}

if (!function_exists('generate_keywords')) {
    /**
     * Generate relevant keywords for SEO
     */
    function generate_keywords($primary, $location = 'bandung', $additional = [])
    {
        $keywords = [$primary];

        // Add location variations
        $keywords[] = $primary . ' ' . $location;
        $keywords[] = $primary . ' di ' . $location;
        $keywords[] = $primary . ' ' . $location . ' terpercaya';
        $keywords[] = $primary . ' ' . $location . ' murah';
        $keywords[] = $primary . ' ' . $location . ' berkualitas';

        // Add additional keywords
        $keywords = array_merge($keywords, $additional);

        return implode(', ', array_unique($keywords));
    }
}

if (!function_exists('create_slug')) {
    /**
     * Create SEO friendly URL slug
     */
    function create_slug($text)
    {
        // Convert to lowercase
        $text = strtolower($text);

        // Replace Indonesian characters
        $text = str_replace(
            ['á', 'à', 'ä', 'â', 'ã', 'å', 'ā', 'é', 'è', 'ë', 'ê', 'ē', 'í', 'ì', 'ï', 'î', 'ī', 'ó', 'ò', 'ö', 'ô', 'õ', 'ø', 'ō', 'ú', 'ù', 'ü', 'û', 'ū'],
            ['a', 'a', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'u'],
            $text
        );

        // Remove special characters
        $text = preg_replace('/[^a-z0-9\s\-]/', '', $text);

        // Replace spaces and multiple hyphens with single hyphen
        $text = preg_replace('/[\s\-]+/', '-', $text);

        // Trim hyphens from beginning and end
        return trim($text, '-');
    }
}