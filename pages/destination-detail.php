<?php
session_start();
include("../includes/db-connect.php");

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: Destination.php");
    exit();
}

$stmt = $db->prepare("SELECT * FROM destinations WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$destination = $result->fetch_assoc();
$stmt->close();

if (!$destination) {
    header("Location: Destination.php");
    exit();
}

// Fetch packages that might be related to this destination
$pkg_stmt = $db->prepare("SELECT * FROM packages WHERE title LIKE ? OR description LIKE ? LIMIT 3");
$search_term = '%' . $destination['name'] . '%';
$pkg_stmt->bind_param("ss", $search_term, $search_term);
$pkg_stmt->execute();
$packages = $pkg_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$pkg_stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($destination['name']) ?> | OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { font-family: 'Outfit', sans-serif; overflow-x: hidden; }
        .glass-nav { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50 min-h-screen relative">
    <!-- Abstract Blobs -->
    <div class="fixed top-20 right-0 w-[600px] h-[600px] bg-amber-200/30 rounded-full blur-[100px] -z-10 pointer-events-none"></div>
    <div class="fixed bottom-0 left-0 w-[500px] h-[500px] bg-blue-200/30 rounded-full blur-[100px] -z-10 pointer-events-none"></div>

    <!-- Header -->
    <div class="absolute top-0 w-full z-50 glass-nav border-b border-gray-100 shadow-sm">
        <?php include('../includes/header.php'); ?>
    </div>

    <!-- Hero Section -->
    <div class="relative h-[65vh] w-full mt-20">
        <img src="<?= htmlspecialchars($destination['image_url']) ?>" alt="<?= htmlspecialchars($destination['name']) ?>" class="w-full h-full object-cover" onerror="this.src='../assets/images/default-dest.jpg'">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-full pb-20">
            <div class="container mx-auto px-4 max-w-5xl">
                <span class="bg-white/20 backdrop-blur-md border border-white/30 text-white px-5 py-2 rounded-full text-xs font-bold mb-6 inline-block uppercase tracking-widest shadow-lg">Discover Ethiopia</span>
                <h1 class="text-5xl md:text-8xl font-black text-white drop-shadow-2xl"><?= htmlspecialchars($destination['name']) ?></h1>
            </div>
        </div>
    </div>

    <!-- Detail Content -->
    <div class="container mx-auto px-4 py-20 max-w-5xl">
        <div class="bg-white/90 backdrop-blur-xl border border-white/60 rounded-[2rem] p-10 md:p-16 shadow-2xl -mt-32 relative z-10">
            <div class="flex items-center mb-10 pb-10 border-b border-gray-100">
                <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center mr-6 shadow-inner border border-amber-100">
                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">About The Destination</h2>
                    <p class="text-gray-500 font-medium mt-1 text-lg">A brief history and overview.</p>
                </div>
            </div>
            
            <div class="text-gray-600 leading-relaxed text-xl font-medium space-y-6">
                <p><?= nl2br(htmlspecialchars($destination['description'])) ?></p>
            </div>
        </div>
        
        <?php if(count($packages) > 0): ?>
        <div class="mt-24">
            <h3 class="text-3xl font-extrabold text-gray-900 mb-10 flex items-center justify-center">
                <span class="bg-amber-100 p-2 rounded-xl mr-3"><svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg></span>
                Available Tours
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach($packages as $pkg): ?>
                    <a href="book.php?package_id=<?= $pkg['id'] ?>" class="bg-white rounded-[2rem] overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group block relative">
                        <div class="h-60 overflow-hidden relative">
                            <img src="<?= htmlspecialchars($pkg['image_url']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                            <div class="absolute bottom-6 left-6 text-white font-extrabold text-2xl drop-shadow-lg"><?= htmlspecialchars($pkg['title']) ?></div>
                        </div>
                        <div class="p-8">
                            <div class="text-amber-500 font-black text-2xl mb-2">ETB <?= number_format($pkg['price']) ?></div>
                            <div class="text-gray-500 text-sm font-bold uppercase tracking-wider flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <?= htmlspecialchars($pkg['duration']) ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="mt-20 text-center mb-10">
            <a href="Destination.php" class="inline-flex items-center justify-center px-8 py-4 bg-gray-900 text-white font-extrabold rounded-xl hover:bg-amber-500 transition-colors shadow-lg shadow-gray-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Destinations List
            </a>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
