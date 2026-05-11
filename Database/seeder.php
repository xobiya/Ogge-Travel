<?php
/**
 * OGGE Travel - Extended Database Seeder
 * Populates 30+ Packages and Destinations covering all of Ethiopia.
 */

require_once __DIR__ . '/../includes/db-connect.php';

echo "Starting extended database seeding...\n";

// 1. Clear existing data
$db->query("SET FOREIGN_KEY_CHECKS = 0");
$db->query("TRUNCATE TABLE packages");
$db->query("TRUNCATE TABLE destinations");
$db->query("SET FOREIGN_KEY_CHECKS = 1");

echo "Tables cleared.\n";

// 2. Define Destinations (covering all of Ethiopia)
$dest_data = [
    ['Lalibela', 'The Eighth Wonder of the World.', '../assets/images/lalibela.jpg'],
    ['Gondar', 'The Camelot of Africa.', '../assets/images/gonder.jpg'],
    ['Aksum', 'Home of the Ark of the Covenant.', '../assets/images/aksum.jpg'],
    ['Simien Mountains', 'Roof of Africa.', '../assets/images/Simien.jpg'],
    ['Danakil Depression', 'The Hottest Place on Earth.', '../assets/images/danakil.jpg'],
    ['Omo Valley', 'Living Museum of Humanity.', '../assets/images/omo-cultural.jpg'],
    ['Bale Mountains', 'Sanctuary of the Ethiopian Wolf.', '../assets/images/fox.jfif'],
    ['Harar', 'The Fourth Holiest City of Islam.', '../assets/images/harer.jpg'],
    ['Arba Minch', 'Gate to the Southern Tribes.', '../assets/images/arbaminch.jpg'],
    ['Hawassa', 'Lakeside Serenity.', '../assets/images/Hawassa.jpg'],
    ['Bahir Dar', 'Source of the Blue Nile.', '../assets/images/bahirdar.jpg'],
    ['Addis Ababa', 'The Capital of Africa.', '../assets/images/Addis ababa.jpg'],
    ['Jimma', 'The Birthplace of Coffee.', '../assets/images/jimma.jpg'],
    ['Dire Dawa', 'French-Styled Hub of the East.', '../assets/images/dire.jpg'],
    ['Mekelle', 'Gateway to the Salt Desert.', '../assets/images/mekelle.jpg'],
    ['Gambela', 'Untouched Savannah and Wildlife.', '../assets/images/monkey.jfif'],
    ['Tiya', 'UNESCO Megalithic Stelae Field.', '../assets/images/tiya.jpg'],
    ['Langano', 'The Red Lake Retreat.', '../assets/images/rift-valley.jpg'],
    ['Debre Damo', 'Mountaintop Monastery accessible by rope.', '../assets/images/Axum simien.jpg'],
    ['Sof Omar', 'One of the world\'s most spectacular caves.', 'https://images.unsplash.com/photo-1590001155093-a3c66ab0c3ff?auto=format&fit=crop&q=80&w=1200']
];

$dest_ids = [];
foreach ($dest_data as $d) {
    $stmt = $db->prepare("INSERT INTO destinations (name, description, image_url) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $d[0], $d[1], $d[2]);
    $stmt->execute();
    $dest_ids[$d[0]] = $db->insert_id;
    $stmt->close();
}

echo "Inserted " . count($dest_ids) . " destinations.\n";

// 3. Define 30+ Packages
$packages_data = [
    // LALIBELA
    ['Lalibela Eternal Spirit', 'Lalibela', 'Sunrise pilgrimage to the rock-hewn churches.', 125000, '3 Days', '../assets/images/lalibela-3.jpg'],
    ['Churches of the Sky', 'Lalibela', 'Helicopter tour over the Abune Yosef mountains.', 185000, '2 Days', '../assets/images/laibela.jfif'],
    
    // GONDAR
    ['Royal Castles Odyssey', 'Gondar', 'Private dinner in the Fasil Ghebbi enclosure.', 95000, '3 Days', '../assets/images/fasil.jpg'],
    ['Gondar Timkat Festival', 'Gondar', 'Experience the world\'s most vibrant epiphany celebration.', 145000, '4 Days', '../assets/images/gonder-fa.jfif'],

    // AKSUM
    ['Ancient Empires Tour', 'Aksum', 'Trace the roots of the Queen of Sheba.', 85000, '3 Days', '../assets/images/aksum.jpg'],
    ['Ark of the Covenant Quest', 'Aksum', 'Spiritual exploration of St. Mary of Zion.', 110000, '3 Days', '../assets/images/Axum simien.jpg'],

    // SIMIEN
    ['Simien Highland Trek', 'Simien Mountains', 'Trek with Gelada Baboons at 4000m.', 135000, '5 Days', '../assets/images/simien-trek.jpg'],
    ['Roof of Africa Summit', 'Simien Mountains', 'Summiting Ras Dashen with elite guides.', 175000, '7 Days', '../assets/images/simein.jpg'],

    // DANAKIL
    ['Danakil Expedition', 'Danakil Depression', 'Lava lake at Erta Ale and Dallol salt fields.', 215000, '4 Days', '../assets/images/danakil.jpg'],
    ['Afar Desert Caravan', 'Danakil Depression', 'Traditional salt caravan journey.', 195000, '5 Days', '../assets/images/afar.jfif'],

    // OMO
    ['Tribes of the South', 'Omo Valley', 'Photography workshop with the Mursi and Karo.', 185000, '6 Days', '../assets/images/omo-cultural.jpg'],
    ['Omo River Safari', 'Omo Valley', 'Luxury boat expedition through the valley.', 245000, '5 Days', '../assets/images/omo-1.jpg'],

    // BALE
    ['Wolf Sanctuary Trek', 'Bale Mountains', 'Track the world\'s rarest canid.', 125000, '4 Days', '../assets/images/fox.jfif'],
    ['Harenna Forest Escape', 'Bale Mountains', 'Luxury lodge stay in the cloud forest.', 155000, '3 Days', 'https://images.unsplash.com/photo-1547234935-80c7145ec969?auto=format&fit=crop&q=80&w=1200'],

    // HARAR
    ['Harar Walled City', 'Harar', 'Nightly hyena feeding and colorful market tour.', 75000, '3 Days', '../assets/images/harer.jpg'],
    ['Islamic Heritage Path', 'Harar', 'Tour of the 82 mosques of Jugol.', 85000, '3 Days', '../assets/images/harer2.jpg'],

    // ARBA MINCH
    ['Lake Chamo Boat Safari', 'Arba Minch', 'Crocodiles and hippos in the Great Rift Valley.', 65000, '2 Days', '../assets/images/arbaminch3.jpg'],
    ['Dorze Village Life', 'Arba Minch', 'Stay in traditional bamboo beehive huts.', 55000, '2 Days', '../assets/images/banana.jpg'],

    // HAWASSA
    ['Lakeside Sunset Retreat', 'Hawassa', 'Kayaking and birdwatching at Lake Hawassa.', 45000, '2 Days', '../assets/images/Hawassa.jpg'],
    ['Hawassa Fish Market Tour', 'Hawassa', 'Cultural immersion at the legendary market.', 35000, '1 Day', '../assets/images/hawwasa.jpg'],

    // BAHIR DAR
    ['Blue Nile Falls Journey', 'Bahir Dar', 'Hike to the "Tis Abay" smoking water.', 55000, '2 Days', '../assets/images/abay.jpg'],
    ['Lake Tana Monasteries', 'Bahir Dar', 'Island hopping across the sacred lake.', 75000, '3 Days', '../assets/images/barir.jpg'],

    // ADDIS ABABA
    ['Addis City Spotlight', 'Addis Ababa', 'Entoto mountain views and National Museum.', 45000, '2 Days', '../assets/images/Addis ababa.jpg'],
    ['African Diplomatic Hub', 'Addis Ababa', 'Luxury stay with AU and ECA tours.', 95000, '3 Days', '../assets/images/addis ababa 13.jpg'],

    // JIMMA
    ['Kaffa Coffee Origins', 'Jimma', 'The ultimate bean-to-cup forest experience.', 65000, '4 Days', '../assets/images/jimma.jpg'],
    ['Abba Jifar Palace Tour', 'Jimma', 'Imperial history of the western kingdoms.', 55000, '2 Days', '../assets/images/bete Abba.jpg'],

    // MEKELLE
    ['Salt Desert Gateway', 'Mekelle', 'Prepare for the Danakil adventure.', 45000, '2 Days', '../assets/images/mekelle.jpg'],
    ['Tigray Rock Churches', 'Mekelle', 'Climbing the sandstone spires of Gheralta.', 115000, '4 Days', '../assets/images/mekelle-1.jfif'],

    // THEMATIC
    ['The Great Rift Explorer', 'Langano', 'Volcanic lakes and flamingo colonies.', 125000, '5 Days', '../assets/images/rift-valley.jpg'],
    ['Ancient Kingdoms Odyssey', 'Tiya', 'Prehistoric stelae and megalithic history.', 155000, '6 Days', '../assets/images/ancient-kingdoms.jpg'],
    ['Gambela Wilderness', 'Gambela', 'Witness the second largest mammal migration.', 265000, '7 Days', '../assets/images/monkey.jfif'],
    ['The Coffee Pilgrimage', 'Jimma', 'Across the highlands of coffee forests.', 135000, '10 Days', '../assets/images/coffee.jfif']
];

foreach ($packages_data as $p) {
    if (!isset($dest_ids[$p[1]])) continue;
    $stmt = $db->prepare("INSERT INTO packages (title, destination_id, description, price, duration, image_url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisdss", $p[0], $dest_ids[$p[1]], $p[2], $p[3], $p[4], $p[5]);
    $stmt->execute();
    $stmt->close();
}

echo "Inserted " . count($packages_data) . " luxury packages.\n";
echo "Seeding completed successfully!\n";
?>
