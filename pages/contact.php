<?php
require_once __DIR__ . '/../includes/auth-helpers.php';
ogge_start_secure_session();
$csrfToken = ogge_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private Enquiries | OGGE Travel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/luxury.css">
</head>
<body class="bg-[#faf8f5]" style="font-family:'Inter',sans-serif;">
    <?php include('../includes/header.php'); ?>

    <!-- Page Header -->
    <section class="relative h-[45vh] flex items-end overflow-hidden bg-[#0a0f1e]">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0f1e]/60 to-[#0a0f1e]"></div>
        <div class="container mx-auto px-6 max-w-7xl relative z-10 pb-16">
            <span class="section-eyebrow">Get In Touch</span>
            <h1 class="text-5xl md:text-7xl text-white" style="font-family:'Playfair Display',serif; font-weight:800;">Private <span class="text-champagne-gradient">Enquiries</span></h1>
            <p class="text-gray-400 mt-4 text-lg max-w-xl">Our concierge team is ready to craft your perfect Ethiopian journey.</p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-24">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="grid lg:grid-cols-5 gap-12">
                <!-- Contact Form -->
                <div class="lg:col-span-3 bg-white rounded-[2rem] shadow-xl p-10 lg:p-14 border border-gray-100 reveal">
                    <h2 class="text-3xl mb-2 text-[#0a0f1e]" style="font-family:'Playfair Display',serif; font-weight:700;">Send an Enquiry</h2>
                    <p class="text-gray-500 mb-10">We respond to all enquiries within 24 hours.</p>
                    <div class="champagne-line mb-10"></div>
                    
                    <form id="contactForm" action="../includes/contact-submit.php" method="POST" class="space-y-8" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="text" name="website" value="" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-400 mb-3 uppercase tracking-[0.15em]">Full Name</label>
                            <input type="text" name="name" maxlength="120" id="name" 
                                   class="w-full px-6 py-4 bg-[#faf8f5] border border-[#e2ddd5] rounded-xl focus:outline-none focus:border-[#c9a96e] focus:shadow-lg transition-all text-[#0a0f1e] font-medium"
                                   placeholder="Your full name" required>
                        </div>
                        <div>
                            <label for="email" class="block text-xs font-bold text-gray-400 mb-3 uppercase tracking-[0.15em]">Email Address</label>
                            <input type="email" name="email" maxlength="255" autocomplete="email" id="email" 
                                   class="w-full px-6 py-4 bg-[#faf8f5] border border-[#e2ddd5] rounded-xl focus:outline-none focus:border-[#c9a96e] focus:shadow-lg transition-all text-[#0a0f1e] font-medium"
                                   placeholder="you@example.com" required>
                        </div>
                        <div>
                            <label for="message" class="block text-xs font-bold text-gray-400 mb-3 uppercase tracking-[0.15em]">Your Message</label>
                            <textarea name="message" maxlength="3000" id="message" rows="5"
                                      class="w-full px-6 py-4 bg-[#faf8f5] border border-[#e2ddd5] rounded-xl focus:outline-none focus:border-[#c9a96e] focus:shadow-lg transition-all text-[#0a0f1e] font-medium resize-none"
                                      placeholder="Tell us about the journey you envision..." required></textarea>
                        </div>
                        <button type="submit" class="btn-dark w-full py-5 text-base">
                            Send Enquiry
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="lg:col-span-2 flex flex-col gap-8">
                    <div class="bg-[#0a0f1e] rounded-[2rem] shadow-xl p-12 text-white flex-grow relative overflow-hidden grain-overlay reveal">
                        <h2 class="text-3xl mb-10 relative z-10" style="font-family:'Playfair Display',serif; font-weight:700;">Concierge</h2>
                        <div class="space-y-8 relative z-10">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center mr-4 shrink-0">
                                    <svg class="w-5 h-5 text-[#c9a96e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Address</p>
                                    <p class="text-gray-300 font-medium">Secha, Arba Minch<br>Ethiopia</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center mr-4 shrink-0">
                                    <svg class="w-5 h-5 text-[#c9a96e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Phone</p>
                                    <p class="text-gray-300 font-medium">+251 911 234 567</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center mr-4 shrink-0">
                                    <svg class="w-5 h-5 text-[#c9a96e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Email</p>
                                    <p class="text-[#c9a96e] font-medium">concierge@oggetravel.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp CTA -->
                    <a href="https://wa.me/251911234567?text=Hello%20OGGE%20Travel" target="_blank" 
                       class="bg-[#25D366] rounded-2xl p-8 flex items-center gap-5 hover:shadow-xl transition-all group reveal">
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        </div>
                        <div>
                            <p class="text-white font-bold text-lg">Message Our Concierge</p>
                            <p class="text-white/70 text-sm">Get instant support via WhatsApp</p>
                        </div>
                        <svg class="w-5 h-5 text-white/60 ml-auto group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Map -->
            <div class="mt-16 bg-white p-4 rounded-[2rem] shadow-xl border border-gray-100 reveal">
                <div class="overflow-hidden rounded-[1.5rem] h-[350px]">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.755681924928!2d37.56395031532617!3d6.022330193548352!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b85f5a9e5e5b7%3A0x1f1b9b9b9b9b9b9b!2sArba%20Minch%2C%20Ethiopia!5e0!3m2!1sen!2sus!4v1633021234567!5m2!1sen!2sus" 
                            width="100%" height="100%" style="border:0; filter: grayscale(20%) contrast(1.1);" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

    <?php include('../includes/footer.php'); ?>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();
            if (!name || !email || !message) { e.preventDefault(); alert('Please fill out all fields.'); }
        });
    </script>
</body>
</html>