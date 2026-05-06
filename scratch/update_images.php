<?php
include("includes/db-connect.php");

$updates = [
    'Arba Minch' => '../assets/images/arbaminch.jpg',
    'Hawassa' => '../assets/images/hawassa.jpg',
    'Gonder' => '../assets/images/gonder.jpg',
    'Bahirdar' => '../assets/images/bahirdar.jpg',
    'Mekelle' => '../assets/images/mekelle.jpg',
    'Aksum' => '../assets/images/aksum.jpg',
    'Harer' => '../assets/images/harer.jpg',
    'Lalibela' => '../assets/images/lalibela.jpg',
    'Jimma' => '../assets/images/jimma.jpg',
    'Simien Mountains' => '../assets/images/simien.jpg',
    'Danakil Depression' => '../assets/images/danakil.jpg',
    'Omo Valley' => '../assets/images/omo.jpg',
    'Addis Ababa' => '../assets/images/Addis ababa.jpg',
    'Blue Nile Falls' => '../assets/images/abay.jpg',
    'Harar' => '../assets/images/harer.jpg',
];

foreach ($updates as $name => $url) {
    $stmt = $db->prepare("UPDATE destinations SET image_url = ? WHERE name = ?");
    $stmt->bind_param("ss", $url, $name);
    $stmt->execute();
    echo "Updated $name with $url\n";
}

// Update packages too
foreach ($updates as $name => $url) {
    $stmt = $db->prepare("UPDATE packages SET image_url = ? WHERE title LIKE ?");
    $search = "%$name%";
    $stmt->bind_param("ss", $url, $search);
    $stmt->execute();
    echo "Updated packages for $name\n";
}

$db->close();
echo "Database update complete.";
?>
