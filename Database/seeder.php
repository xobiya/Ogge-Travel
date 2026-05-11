<?php
/**
 * OGGE Travel - Extended Database Seeder
 * Populates 30+ Packages and Destinations covering all of Ethiopia with detailed descriptions.
 */

require_once __DIR__ . '/../includes/db-connect.php';

echo "Starting extended database seeding with rich content...\n";

// 1. Clear existing data
$db->query("SET FOREIGN_KEY_CHECKS = 0");
$db->query("TRUNCATE TABLE packages");
$db->query("TRUNCATE TABLE destinations");
$db->query("SET FOREIGN_KEY_CHECKS = 1");

echo "Tables cleared.\n";

// 2. Define Destinations with Rich Paragraph Descriptions
$dest_data = [
    [
        'Lalibela', 
        'Lalibela is a masterpiece of human ingenuity and spiritual devotion, world-renowned for its eleven monolithic churches carved entirely from living rock in the 12th century. Often referred to as the "Eighth Wonder of the World," this UNESCO World Heritage site was intended by King Lalibela to be a "New Jerusalem" for pilgrims. Today, it remains a vibrant center of Ethiopian Orthodox Christianity, where the scent of incense and the sound of ancient chants fill the air, offering a profound journey into the heart of faith and architectural brilliance.', 
        '../assets/images/lalibela.jpg'
    ],
    [
        'Gondar', 
        'Often called the "Camelot of Africa," Gondar served as the imperial capital of Ethiopia for over two centuries. The city is famous for its Royal Enclosure, or Fasil Ghebbi, a massive complex of fairytale-like stone castles, banquet halls, and libraries built by successive emperors starting with Fasilides in the 17th century. With its unique blend of Portuguese, Axumite, and Indian architectural influences, Gondar stands as a testament to the power and sophistication of the Solomonic dynasty, surrounded by the rolling hills of the Amhara region.', 
        '../assets/images/gonder.jpg'
    ],
    [
        'Aksum', 
        'Aksum is the cradle of Ethiopian civilization, an ancient city that was once the seat of one of the world\'s most powerful empires. It is famously home to massive granite obelisks, or stelae, that stand as silent guardians of the royal tombs below, dating back nearly 2,000 years. As the reputed home of the Ark of the Covenant, kept in the Chapel of the Tablet at St. Mary of Zion Church, Aksum is a sacred destination that bridges the gap between history, legend, and the foundational identity of the Ethiopian people.', 
        '../assets/images/aksum.jpg'
    ],
    [
        'Simien Mountains', 
        'The Simien Mountains National Park is a dramatic landscape of jagged peaks, deep valleys, and sheer precipices that drop nearly 1,500 meters. Often called the "Roof of Africa," this UNESCO World Heritage site offers some of the most spectacular mountain scenery on the continent. It is a sanctuary for endemic wildlife found nowhere else on Earth, including the majestic Walia ibex, the elusive Ethiopian wolf, and the sociable Gelada baboons, known as the "bleeding-heart monkeys" for the distinctive red patch on their chests.', 
        '../assets/images/Simien.jpg'
    ],
    [
        'Danakil Depression', 
        'The Danakil Depression is an alien landscape of otherworldly beauty and extreme conditions, located at the junction of three tectonic plates. Known as one of the hottest and lowest places on Earth, it features the bubbling lava lake of Erta Ale, the kaleidoscopic sulfur springs of Dallol, and vast, blindingly white salt flats. This is the traditional territory of the Afar people, who have for centuries harvested "white gold" (salt) and transported it by camel caravan across the harsh desert, creating a scene of raw, primal majesty.', 
        '../assets/images/danakil.jpg'
    ],
    [
        'Omo Valley', 
        'The Lower Omo Valley is a living museum of humanity, home to a diverse array of ethnic groups whose traditions have remained largely unchanged for millennia. From the famous lip-plated Mursi and the body-painting Karo to the bull-jumping Hamer, the valley offers a rare and respectful window into some of Africa\'s most distinct cultural heritages. Set against the backdrop of the Omo River and semi-arid plains, a journey here is a profound exploration of human diversity and the enduring strength of ancestral customs.', 
        '../assets/images/omo-cultural.jpg'
    ],
    [
        'Bale Mountains', 
        'The Bale Mountains National Park is a pristine wilderness of alpine plateaus, ancient heather forests, and dramatic mountain peaks. It is home to the Sanetti Plateau, the largest afro-alpine habitat in Africa, where the world\'s rarest canid—the Ethiopian wolf—can be seen hunting giant mole-rats in the thin air. The park also encompasses the Harenna Forest, a lush cloud forest that provides a stark contrast to the high-altitude tundra, making it a haven for hikers, birdwatchers, and those seeking absolute tranquility.', 
        '../assets/images/fox.jfif'
    ],
    [
        'Harar', 
        'The ancient walled city of Harar is a vibrant tapestry of color, history, and spiritual significance, long considered the fourth holiest city of Islam. Its maze-like alleyways within the "Jugol" (the old city walls) are home to 82 mosques and countless traditional Harari houses. Harar is world-famous for its "Hyena Men," who feed wild hyenas by hand every night outside the city walls, and its unique cultural atmosphere that blends Ethiopian, Islamic, and Arab influences in a city that seems frozen in a more graceful era.', 
        '../assets/images/harer.jpg'
    ],
    [
        'Arba Minch', 
        'Arba Minch, meaning "Forty Springs" in Amharic, is the gateway to the incredible cultural and natural diversity of Southern Ethiopia. Nestled between the two Great Rift Valley lakes of Abaya and Chamo, the city offers spectacular views and boat safaris where massive crocodiles and hippos roam. It serves as the base for visiting the Dorze people in the nearby Chencha mountains, famous for their tall, bamboo beehive-shaped houses and expert weaving, providing a perfect introduction to the rich traditions of the South.', 
        '../assets/images/arbaminch.jpg'
    ],
    [
        'Hawassa', 
        'Hawassa is a serene lakeside city that offers a refreshing escape with its wide boulevards, vibrant fish market, and the gentle waters of Lake Hawassa. At dawn, the fish market at Amora Gedel comes alive as fishermen bring in their catch, surrounded by marabou storks and local residents enjoying fresh tilapia. The city is a perfect blend of modern Ethiopian urban life and natural beauty, where one can enjoy a sunset boat ride or a walk along the shore, watching the abundant birdlife in the lush, lakeside vegetation.', 
        '../assets/images/Hawassa.jpg'
    ],
    [
        'Bahir Dar', 
        'Bahir Dar is a beautiful, palm-lined city located on the southern shore of Lake Tana, the source of the Blue Nile. The city is the starting point for exploring the ancient island monasteries of Lake Tana, some dating back to the 14th century and housing priceless religious relics. A short distance away, the Blue Nile Falls—known locally as "Tis Abay" or "Smoking Water"—provide a thunderous spectacle of nature, especially after the rains, as the river plunges into a deep gorge on its long journey towards the Mediterranean.', 
        '../assets/images/bahirdar.jpg'
    ],
    [
        'Addis Ababa', 
        'Addis Ababa, the "New Flower" and the capital of Africa, is a bustling, high-altitude metropolis where tradition and modernity collide in a vibrant urban dance. As the seat of the African Union and the UN Economic Commission for Africa, it is a diplomatic powerhouse. Visitors can explore the National Museum, home to the 3.2-million-year-old fossil "Lucy," wander through the Merkato—Africa\'s largest open-air market—or enjoy the burgeoning jazz and culinary scene, all while surrounded by the aromatic scent of roasting coffee and Eucalyptus-clad hills.', 
        '../assets/images/Addis ababa.jpg'
    ],
    [
        'Jimma', 
        'Jimma is the historic heart of the Kaffa region, the ancestral birthplace of Arabica coffee and a place of lush, green landscapes. The city was once the capital of the powerful Jimma Abba Jifar kingdom, and the restored palace of the last sultan stands as a fine example of 19th-century architecture. Surrounded by deep forests where wild coffee still grows, Jimma offers a true "bean-to-cup" experience and a window into the rich history and hospitable culture of Western Ethiopia.', 
        '../assets/images/jimma.jpg'
    ],
    [
        'Dire Dawa', 
        'Dire Dawa is a unique Ethiopian city with a distinctively cosmopolitan feel, shaped by the construction of the Ethio-Djibouti railway in the early 20th century. The city is divided into the French-designed new town (Kezira), with its wide avenues and railway station, and the more traditional old town (Megala), with its bustling markets and narrow streets. Its warm climate and diverse population of Amhara, Oromo, Somali, and European influences make it a fascinating hub of trade and culture in the eastern lowlands.', 
        '../assets/images/dire.jpg'
    ],
    [
        'Mekelle', 
        'Mekelle is the modern and fast-growing capital of the Tigray region, serving as the primary gateway to the Tigray rock-hewn churches and the Danakil Depression. The city is dominated by the Emperor Yohannes IV Palace, now a museum, and the impressive Martyrs\' Memorial monument. With its bustling markets and university atmosphere, Mekelle is a place where the deep historical roots of the North meet a dynamic vision for the future, offering a comfortable and welcoming base for explorers of Ethiopia\'s northern highlands.', 
        '../assets/images/mekelle.jpg'
    ],
    [
        'Gambela', 
        'Gambela is a remote and untamed frontier in Western Ethiopia, where the Baro River flows through vast savannahs and wetlands that stretch towards the Sudanese border. This region is home to the Gambela National Park, which hosts Africa\'s second-largest mammal migration—the movement of hundreds of thousands of white-eared kob. With its unique Nuer and Anuak cultures and a landscape teeming with wildlife and birds, Gambela offers one of the most authentic and untouched wilderness experiences remaining on the continent.', 
        '../assets/images/monkey.jfif'
    ],
    [
        'Tiya', 
        'Tiya is an archaeological treasure house, home to a UNESCO World Heritage site featuring 36 ancient megalithic stelae that date back to the 12th and 14th centuries. These carved stone pillars, many decorated with enigmatic symbols of swords and human figures, are the remains of an ancient Ethiopian culture whose exact origins remain a mystery. Located in the Soddo region south of Addis Ababa, the site provides a fascinating glimpse into the prehistoric burial customs and artistic expressions of the region\'s early inhabitants.', 
        '../assets/images/tiya.jpg'
    ],
    [
        'Langano', 
        'Lake Langano is a popular retreat in the Great Rift Valley, unique for being one of the few swimmable lakes in Ethiopia due to its copper-colored, bilharzia-free waters. Surrounded by acacia forests and set against the backdrop of the Arsi Mountains, the lake is a haven for water sports, birdwatching, and relaxation. The nearby Abijatta-Shalla National Park offers the chance to see massive colonies of flamingos and explore deep volcanic craters, making Langano a perfect blend of leisure and Rift Valley adventure.', 
        '../assets/images/rift-valley.jpg'
    ],
    [
        'Debre Damo', 
        'Debre Damo is an ancient and isolated mountaintop monastery that can only be reached by climbing a 15-meter leather rope up a sheer cliff face. Dating back to the 6th century, it is home to Ethiopia\'s oldest standing church and a community of monks who live in complete seclusion atop the "Amba" (flat-topped mountain). While the monastery is traditionally only accessible to men, the dramatic location and the centuries-old religious traditions preserved there make it one of the most remarkable and challenging spiritual sites in the world.', 
        '../assets/images/Axum simien.jpg'
    ],
    [
        'Sof Omar', 
        'The Sof Omar Caves are one of the most spectacular and extensive subterranean systems in the world, carved over millennia by the Weyb River. This sacred Islamic site features nearly 15 kilometers of limestone passages, including the majestic "Chamber of Columns," where massive pillars of stone rise to vaulted ceilings. For the local people, the caves have deep spiritual significance, and for visitors, the experience of walking through these echoing, cathedral-like halls is a journey into a hidden, natural underworld of breathtaking scale.', 
        'https://images.unsplash.com/photo-1590001155093-a3c66ab0c3ff?auto=format&fit=crop&q=80&w=1200'
    ]
];

$dest_ids = [];
foreach ($dest_data as $d) {
    $stmt = $db->prepare("INSERT INTO destinations (name, description, image_url) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $d[0], $d[1], $d[2]);
    $stmt->execute();
    $dest_ids[$d[0]] = $db->insert_id;
    $stmt->close();
}

echo "Inserted " . count($dest_ids) . " destinations with rich content.\n";

// 3. Define 30+ Packages
$packages_data = [
    // LALIBELA
    ['Lalibela Eternal Spirit', 'Lalibela', 'A spiritual odyssey through the 11 rock-hewn churches, including a private sunrise service at Biete Giyorgis and traditional coffee ceremonies with local elders.', 125000, '3 Days', '../assets/images/lalibela-3.jpg'],
    ['Churches of the Sky', 'Lalibela', 'A cinematic helicopter exploration of the high-altitude monasteries in the Abune Yosef mountains, followed by luxury lodge stays overlooking the valley.', 185000, '2 Days', '../assets/images/laibela.jfif'],
    
    // GONDAR
    ['Royal Castles Odyssey', 'Gondar', 'A deep dive into the 17th-century imperial history with private evening tours of Fasil Ghebbi and a candlelit dinner in the shadow of Empress Mentewab\'s castle.', 95000, '3 Days', '../assets/images/fasil.jpg'],
    ['Gondar Timkat Festival', 'Gondar', 'The ultimate cultural experience: join the massive procession of the Ark replicas during the Epiphany celebration, with exclusive balcony viewing access.', 145000, '4 Days', '../assets/images/gonder-fa.jfif'],

    // AKSUM
    ['Ancient Empires Tour', 'Aksum', 'Trace the roots of the Axumite Empire from the massive stelae fields to the underground tombs of King Kaleb, guided by Ethiopia\'s top archaeologists.', 85000, '3 Days', '../assets/images/aksum.jpg'],
    ['Ark of the Covenant Quest', 'Aksum', 'A spiritual journey to the holy city, including private access to the museum of church treasures and vespers at the historic St. Mary of Zion.', 110000, '3 Days', '../assets/images/Axum simien.jpg'],

    // SIMIEN
    ['Simien Highland Trek', 'Simien Mountains', 'An immersive trekking experience through the jagged peaks of the Simiens, camping under the stars and walking among thousands of Gelada baboons.', 135000, '5 Days', '../assets/images/simien-trek.jpg'],
    ['Roof of Africa Summit', 'Simien Mountains', 'A challenging but rewarding expedition to the summit of Ras Dashen (4550m), supported by a team of elite porters and private chefs.', 175000, '7 Days', '../assets/images/simein.jpg'],

    // DANAKIL
    ['Danakil Expedition', 'Danakil Depression', 'A journey to the most extreme landscape on Earth. Witness the bubbling lava lake of Erta Ale and the colorful hydrothermal fields of Dallol.', 215000, '4 Days', '../assets/images/danakil.jpg'],
    ['Afar Desert Caravan', 'Danakil Depression', 'A rare opportunity to travel alongside the traditional Afar salt caravans, learning the ancient art of desert survival and salt mining.', 195000, '5 Days', '../assets/images/afar.jfif'],

    // OMO
    ['Tribes of the South', 'Omo Valley', 'A respectful and deep cultural immersion with the Mursi, Karo, and Hamer peoples, focused on photography and understanding ancestral traditions.', 185000, '6 Days', '../assets/images/omo-cultural.jpg'],
    ['Omo River Safari', 'Omo Valley', 'A luxury boat expedition along the Omo River, visiting remote riverside villages and observing the diverse wildlife of the riverine forests.', 245000, '5 Days', '../assets/images/omo-1.jpg'],

    // BALE
    ['Wolf Sanctuary Trek', 'Bale Mountains', 'Track the world\'s rarest canid on the high Sanetti Plateau, followed by explorations of the endemic birdlife and dramatic mountain scenery.', 125000, '4 Days', '../assets/images/fox.jfif'],
    ['Harenna Forest Escape', 'Bale Mountains', 'Retreat to a luxury eco-lodge in the heart of the Harenna cloud forest, searching for lions, wild coffee, and the rare Bale monkey.', 155000, '3 Days', 'https://images.unsplash.com/photo-1547234935-80c7145ec969?auto=format&fit=crop&q=80&w=1200'],

    // HARAR
    ['Harar Walled City', 'Harar', 'A journey into the maze of the old city, including hyena feeding rituals, traditional Harari house visits, and spice market explorations.', 75000, '3 Days', '../assets/images/harer.jpg'],
    ['Islamic Heritage Path', 'Harar', 'A spiritual and historical tour of the 82 mosques of Jugol, focusing on the city\'s unique role as a center of Islamic learning and peace.', 85000, '3 Days', '../assets/images/harer2.jpg'],

    // ARBA MINCH
    ['Lake Chamo Boat Safari', 'Arba Minch', 'Private boat tours to the "Crocodile Market," observing the largest Nile crocodiles in Africa and the diverse birdlife of the Rift Valley.', 65000, '2 Days', '../assets/images/arbaminch3.jpg'],
    ['Dorze Village Life', 'Arba Minch', 'A stay in the high mountains with the Dorze people, learning about their bamboo architecture, enset (false banana) food culture, and weaving.', 55000, '2 Days', '../assets/images/banana.jpg'],

    // HAWASSA
    ['Lakeside Sunset Retreat', 'Hawassa', 'A relaxing luxury stay by Lake Hawassa, with private boat tours at sunset and dawn visits to the legendary local fish market.', 45000, '2 Days', '../assets/images/Hawassa.jpg'],
    ['Hawassa Fish Market Tour', 'Hawassa', 'An early morning immersion into the vibrant heart of the city, followed by a culinary tour of the region\'s freshest lake-side delicacies.', 35000, '1 Day', '../assets/images/hawwasa.jpg'],

    // BAHIR DAR
    ['Blue Nile Falls Journey', 'Bahir Dar', 'A scenic trek to the majestic falls, combined with a visit to the historic Portuguese bridge and the surrounding Amhara villages.', 55000, '2 Days', '../assets/images/abay.jpg'],
    ['Lake Tana Monasteries', 'Bahir Dar', 'Private boat exploration of the lake\'s island monasteries, visiting Ura Kidane Mehret and Azwa Maryam to see ancient manuscripts.', 75000, '3 Days', '../assets/images/barir.jpg'],

    // ADDIS ABABA
    ['Addis City Spotlight', 'Addis Ababa', 'A curated urban tour including the National Museum, panoramic views from Mount Entoto, and a private jazz evening in the Kazanchis district.', 45000, '2 Days', '../assets/images/Addis ababa.jpg'],
    ['African Diplomatic Hub', 'Addis Ababa', 'An exclusive look at the headquarters of the African Union and the historic ECA building, followed by a luxury spa retreat at the Sheraton.', 95000, '3 Days', '../assets/images/addis ababa 13.jpg'],

    // JIMMA
    ['Kaffa Coffee Origins', 'Jimma', 'The ultimate pilgrimage for coffee lovers: explore the wild coffee forests of Bonga and Jimma, staying in traditional forest lodges.', 65000, '4 Days', '../assets/images/jimma.jpg'],
    ['Abba Jifar Palace Tour', 'Jimma', 'Explore the unique 19th-century architecture of the Abba Jifar palace and learn the fascinating history of the western kingdoms of Ethiopia.', 55000, '2 Days', '../assets/images/bete Abba.jpg'],

    // MEKELLE
    ['Salt Desert Gateway', 'Mekelle', 'A comfortable transition into the northern wilderness, including luxury stays and historical tours of the Emperor Yohannes IV palace.', 45000, '2 Days', '../assets/images/mekelle.jpg'],
    ['Tigray Rock Churches', 'Mekelle', 'A high-adventure exploration of the rock-hewn churches of Gheralta, including the vertical climb to Abuna Yemata Guh for breathtaking views.', 115000, '4 Days', '../assets/images/mekelle-1.jfif'],

    // THEMATIC
    ['The Great Rift Explorer', 'Langano', 'A multi-day adventure across the Rift Valley lakes, from the flamingos of Abijatta to the copper waters of Langano.', 125000, '5 Days', '../assets/images/rift-valley.jpg'],
    ['Ancient Kingdoms Odyssey', 'Tiya', 'A historical circuit south of the capital, visiting the Tiya stelae and the prehistoric caves of Melka Kunture.', 155000, '6 Days', '../assets/images/ancient-kingdoms.jpg'],
    ['Gambela Wilderness', 'Gambela', 'A remote expedition to witness the kob migration, combined with boat tours on the Baro River and Nuer cultural visits.', 265000, '7 Days', '../assets/images/monkey.jfif'],
    ['The Coffee Pilgrimage', 'Jimma', 'An epic cross-country journey through the coffee highlands, from the forests of Jimma to the markets of Addis Ababa.', 135000, '10 Days', '../assets/images/coffee.jfif']
];

foreach ($packages_data as $p) {
    if (!isset($dest_ids[$p[1]])) continue;
    $stmt = $db->prepare("INSERT INTO packages (title, destination_id, description, price, duration, image_url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisdss", $p[0], $dest_ids[$p[1]], $p[2], $p[3], $p[4], $p[5]);
    $stmt->execute();
    $stmt->close();
}

echo "Inserted " . count($packages_data) . " luxury packages with detailed itineraries.\n";
echo "Seeding completed successfully!\n";
?>
