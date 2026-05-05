<?php
include("../includes/db-connect.php");
session_start();

// Get search parameters
$search = $_GET['search'] ?? '';
$date = $_GET['date'] ?? '';
$travelers = $_GET['travelers'] ?? '';

// Simple search query
$query = "SELECT * FROM packages WHERE 1=1";
if (!empty($search)) {
    $search = mysqli_real_escape_string($db, $search);
    $query .= " AND (title LIKE '%$search%' OR description LIKE '%$search%')";
}

// Execute query
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Premium Packages | OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .hover-lift { transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.4s ease; }
        .hover-lift:hover { transform: translateY(-12px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); }
        .text-gradient {
            background: linear-gradient(135deg, #d97706, #b45309);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">
    <?php include("../includes/header.php"); ?>

    <div class="container mx-auto px-4 py-20 relative">
        <!-- Decorative blob -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-amber-200 rounded-full blur-3xl opacity-30 -z-10"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-200 rounded-full blur-3xl opacity-30 -z-10"></div>

        <div class="text-center mb-16">
            <span class="text-amber-600 font-bold tracking-wider uppercase text-sm mb-3 block">Discover Your Next Adventure</span>
            <h1 class="text-5xl lg:text-6xl font-extrabold mb-6 text-gray-900">Explore <span class="text-gradient">Premium</span> Packages</h1>
            <p class="text-gray-600 text-xl max-w-2xl mx-auto">Curated experiences designed to leave you breathless. Find the perfect journey tailored to your desires.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 max-w-7xl mx-auto">
            <?php while($package = mysqli_fetch_assoc($result)): ?>
                <div class="glass-card rounded-[2rem] overflow-hidden hover-lift group relative shadow-lg">
                    <div class="absolute top-6 right-6 bg-white/90 backdrop-blur text-gray-900 text-xs font-extrabold px-4 py-2 rounded-full z-10 shadow-sm flex items-center">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                        Available
                    </div>
                    <div class="relative overflow-hidden h-72">
                        <img src="<?php echo $package['image_url']; ?>" 
                             alt="<?php echo $package['title']; ?>"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/20 to-transparent"></div>
                        <h2 class="absolute bottom-6 left-6 right-6 text-2xl font-bold text-white drop-shadow-md leading-tight"><?php echo $package['title']; ?></h2>
                    </div>
                    <div class="p-8 relative">
                        <p class="text-gray-600 mb-6 line-clamp-3 leading-relaxed"><?php echo $package['description']; ?></p>
                        
                        <div class="flex justify-between items-end mb-8 border-b border-gray-100 pb-6">
                            <div>
                                <p class="text-xs font-bold text-gray-400 mb-1 uppercase tracking-wider">Starting from</p>
                                <span class="text-3xl font-extrabold text-amber-600">ETB <?php echo number_format($package['price']); ?></span>
                            </div>
                            <div class="flex items-center text-gray-500 text-sm font-medium bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                                <svg class="w-4 h-4 mr-1.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <?php echo $package['duration']; ?>
                            </div>
                        </div>
                        
                        <button onclick="openModal('<?php echo $package['id']; ?>')"
                                class="w-full bg-gray-900 text-white font-bold text-lg py-4 px-6 rounded-xl hover:bg-amber-500 transition-colors duration-300 shadow-md hover:shadow-xl flex justify-center items-center group/btn">
                            <span>Book Experience</span>
                            <svg class="w-5 h-5 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>
    <script src="../assets/js/script.js"></script>
</body>
</html>

<?php
mysqli_close($db);
?>