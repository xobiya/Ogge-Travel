<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Heritage | OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/luxury.css">
</head>
<body class="bg-[#faf8f5]" style="font-family:'Inter',sans-serif;">
    <?php include('../includes/header.php'); ?>

    <!-- Page Header -->
    <section class="relative h-[45vh] flex items-end overflow-hidden bg-[#0a0f1e]">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0f1e]/60 to-[#0a0f1e]"></div>
        <div class="container mx-auto px-6 max-w-7xl relative z-10 pb-16">
            <span class="section-eyebrow">Discover Our Story</span>
            <h1 class="text-5xl md:text-7xl text-white" style="font-family:'Playfair Display',serif; font-weight:800;">Our <span class="text-champagne-gradient">Heritage</span></h1>
            <p class="text-gray-400 mt-4 text-lg max-w-xl">We don't sell destinations — we unlock legacies.</p>
        </div>
    </section>

    <!-- Narrative Block -->
    <section class="py-24">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="reveal">
                <div class="champagne-line mb-8"></div>
                <p class="text-gray-600 text-xl leading-[1.9] mb-10">
                    At OGGE Travel, we believe that Ethiopia is not just a destination — it is a <em style="font-family:'Cormorant Garamond',serif; font-size:1.15em;">revelation</em>. Founded in 2017, our agency was born from a simple truth: the world's oldest civilization deserves to be experienced with reverence, depth, and beauty.
                </p>
                <p class="text-gray-600 text-xl leading-[1.9] mb-10">
                    We are not a mass-market tour operator. We are curators of legacy. Every itinerary we craft is a narrative — designed to connect you not only with Ethiopia's landscapes, but with its soul: the incense-scented corridors of Lalibela's rock churches, the crimson glow of Erta Ale's lava lake under the Milky Way, the quiet dignity of an Afar salt miner beginning his ancient work at dawn.
                </p>
            </div>
            
            <div class="pull-quote reveal">
                "We don't sell flights and hotels. We sell the moment your understanding of time, faith, and humanity shifts forever."
            </div>
            
            <p class="text-gray-600 text-xl leading-[1.9] mt-10 reveal">
                Our team comprises Ethiopia's finest local guides, historians, and cultural interpreters — people who don't just know the facts, but who carry the stories in their blood. When you travel with OGGE, you're not a tourist. You're an honored guest of a 3,000-year-old civilization.
            </p>
        </div>
    </section>

    <!-- The OGGE Difference -->
    <section class="bg-[#0a0f1e] grain-overlay relative" style="padding: clamp(4rem, 7vw, 7rem) 0;">
        <div class="container mx-auto px-6 max-w-6xl relative z-10">
            <div class="text-center mb-16 reveal">
                <span class="section-eyebrow">What Sets Us Apart</span>
                <h2 class="text-3xl md:text-5xl text-white" style="font-family:'Playfair Display',serif; font-weight:800;">The OGGE <span class="text-champagne-gradient">Difference</span></h2>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8" data-stagger>
                <div class="bg-white/5 border border-white/10 rounded-2xl p-10 text-center hover:border-[#c9a96e]/30 transition-all reveal">
                    <div class="w-16 h-16 bg-[#c9a96e]/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-[#c9a96e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-xl text-white mb-4" style="font-family:'Playfair Display',serif; font-weight:700;">Local Mastery</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Our guides aren't just knowledgeable — they're storytellers who carry Ethiopia's oral traditions in their blood.</p>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-2xl p-10 text-center hover:border-[#c9a96e]/30 transition-all reveal">
                    <div class="w-16 h-16 bg-[#c9a96e]/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-[#c9a96e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl text-white mb-4" style="font-family:'Playfair Display',serif; font-weight:700;">Bespoke Itineraries</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Every journey is handcrafted to your interests — history, wildlife, spirituality, or adventure. No two trips are alike.</p>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-2xl p-10 text-center hover:border-[#c9a96e]/30 transition-all reveal">
                    <div class="w-16 h-16 bg-[#c9a96e]/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-[#c9a96e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl text-white mb-4" style="font-family:'Playfair Display',serif; font-weight:700;">Sustainable Legacy</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">We invest directly in the communities you visit — ensuring Ethiopia's heritage endures for the next three thousand years.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-[#faf8f5]">
        <div class="container mx-auto px-6 max-w-3xl text-center reveal">
            <div class="champagne-line-center"></div>
            <h2 class="text-3xl md:text-5xl mt-8 mb-6 text-[#0a0f1e]" style="font-family:'Playfair Display',serif; font-weight:800;">Begin Your <span class="text-champagne-gradient">Story</span> With Us</h2>
            <p class="text-gray-500 text-lg mb-10">The next chapter of your life is waiting in the highlands and valleys of Ethiopia.</p>
            <a href="packages.php" class="btn-champagne">
                Explore Curated Journeys
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </section>

    <?php include('../includes/footer.php'); ?>
</body>
</html>