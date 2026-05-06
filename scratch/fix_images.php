<?php
include(__DIR__ . '/../includes/db-connect.php');

$fixes = [
    'Awash National Park' => '../assets/images/denakil-1.jpg', // Scenic replacement
    'Axum' => '../assets/images/aksum.jpg',
    'Bale Mountains' => '../assets/images/Axum simien.jpg',
    'Debre Damo' => '../assets/images/ancient-kingdoms.jpg',
    'Debre Libanos' => '../assets/images/bete Abba.jpg',
    'Dire Dawa' => '../assets/images/dire.jpg',
    'Gheralta Mountains' => '../assets/images/historical-route.jpg',
    'Konso' => '../assets/images/omo-cultural.jpg',
    'Lake Tana' => '../assets/images/bahirdar.jpg',
    'Sof Omar Caves' => '../assets/images/historical (2).jpg'
];

foreach ($fixes as $name => $img) {
    $stmt = $db->prepare("UPDATE destinations SET image_url = ? WHERE name = ?");
    $stmt->bind_param("ss", $img, $name);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo "Fixed: $name -> $img\n";
    }
}

// Also check packages
$db->query("UPDATE packages p JOIN destinations d ON p.destination_id = d.id SET p.image_url = d.image_url WHERE p.image_url LIKE '%broken%' OR p.image_url NOT LIKE '../assets/images/%'");

echo "Image fix completed.\n";
$db->close();
