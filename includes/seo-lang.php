<?php
/**
 * OGGE Travel — Language & SEO Manager
 */
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Language Switching Logic
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'am' ? 'am' : 'en';
}
$lang = $_SESSION['lang'] ?? 'en';

$translations = [
    'en' => [
        'home' => 'Home',
        'destinations' => 'Destinations',
        'packages' => 'Packages',
        'contact' => 'Contact',
        'journal' => 'Journal',
        'book_now' => 'Book Your Escape',
        'explore' => 'Explore the Heritage',
        'recent_posts' => 'Recent Stories',
        'cta_title' => 'Ready for a Curated Escape?',
        'cta_sub' => 'Join us for an unforgettable journey through Ethiopia.',
        'footer_about' => 'Crafting luxury experiences in the heart of Ethiopia.'
    ],
    'am' => [
        'home' => 'መነሻ',
        'destinations' => 'መዳረሻዎች',
        'packages' => 'ጥቅሎች',
        'contact' => 'እኛን ያግኙ',
        'journal' => 'መጽሔት',
        'book_now' => 'አሁኑኑ ይያዙ',
        'explore' => 'ቅርሶችን ያስሱ',
        'recent_posts' => 'የቅርብ ጊዜ ታሪኮች',
        'cta_title' => 'ለተመረጠ ጉዞ ዝግጁ ነዎት?',
        'cta_sub' => 'በኢትዮጵያ ውስጥ የማይረሳ ጉዞ ለማድረግ ይቀላቀሉን።',
        'footer_about' => 'በኢትዮጵያ ልብ ውስጥ የቅንጦት ልምዶችን መፍጠር።'
    ]
];

function __t($key) {
    global $translations, $lang;
    return $translations[$lang][$key] ?? $key;
}

/**
 * SEO Generator
 */
function generateSEO($title, $desc, $image = null) {
    $site_name = "OGGE Travel";
    $image = $image ?? "http://localhost:8000/assets/images/hero-luxury.png";
    return '
    <title>' . $title . ' | ' . $site_name . '</title>
    <meta name="description" content="' . $desc . '">
    <meta property="og:title" content="' . $title . '">
    <meta property="og:description" content="' . $desc . '">
    <meta property="og:image" content="' . $image . '">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="keywords" content="Travel Ethiopia, Luxury Tour, Lalibela, Aksum, Omo Valley, Heritage Travel">';
}
?>
