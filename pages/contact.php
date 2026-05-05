<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Premium OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { font-family: 'Outfit', sans-serif; overflow-x: hidden; }
        .text-gradient {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .form-input {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.15);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <?php include('../includes/header.php'); ?>

    <!-- Contact Section -->
    <section class="py-24 relative overflow-hidden">
        <!-- Decorative bg -->
        <div class="absolute top-0 right-0 -mr-40 -mt-40 w-[600px] h-[600px] bg-amber-200 rounded-full blur-[120px] opacity-40 z-0"></div>
        <div class="absolute bottom-0 left-0 -ml-40 -mb-40 w-[600px] h-[600px] bg-blue-200 rounded-full blur-[120px] opacity-40 z-0"></div>

        <div class="container mx-auto px-4 relative z-10 max-w-7xl">
            <!-- Section Header -->
            <div class="text-center mb-20">
                <span class="text-amber-600 font-bold tracking-wider uppercase text-sm mb-3 block">Get in Touch</span>
                <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 mb-6">
                    Contact <span class="text-gradient">Us</span>
                </h1>
                <p class="text-gray-600 max-w-3xl mx-auto text-xl leading-relaxed">
                    Have questions or need assistance crafting your perfect journey? We're here to help! Reach out to us via the form below or visit our premium office.
                </p>
            </div>

            <!-- Contact Content -->
            <div class="grid lg:grid-cols-5 gap-12">
                <!-- Contact Form -->
                <div class="lg:col-span-3 bg-white/80 backdrop-blur-xl rounded-[3rem] shadow-2xl p-10 lg:p-14 border border-gray-100">
                    <h2 class="text-4xl font-bold text-gray-900 mb-10 flex items-center">
                        Send a Message
                        <span class="ml-4 inline-block bg-amber-100 text-amber-600 p-3 rounded-2xl shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </span>
                    </h2>
                    <form id="contactForm" action="../includes/contact-submit.php" method="POST">
                        <div class="space-y-8">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Full Name</label>
                                <input type="text" name="name" id="name" 
                                       class="form-input w-full px-6 py-5 bg-gray-50 border-0 rounded-2xl focus:ring-2 focus:ring-amber-500 text-gray-900 text-lg font-medium shadow-inner"
                                       placeholder="John Doe" required>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Email Address</label>
                                <input type="email" name="email" id="email" 
                                       class="form-input w-full px-6 py-5 bg-gray-50 border-0 rounded-2xl focus:ring-2 focus:ring-amber-500 text-gray-900 text-lg font-medium shadow-inner"
                                       placeholder="john@example.com" required>
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Message</label>
                                <textarea name="message" id="message" rows="5"
                                          class="form-input w-full px-6 py-5 bg-gray-50 border-0 rounded-2xl focus:ring-2 focus:ring-amber-500 text-gray-900 text-lg font-medium resize-none shadow-inner"
                                          placeholder="How can we craft your dream experience?" required></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full bg-gray-900 text-white font-bold text-xl py-5 px-6 rounded-2xl hover:bg-amber-500 transition-colors duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 mt-4">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="lg:col-span-2 flex flex-col space-y-8">
                    <div class="bg-gray-900 rounded-[3rem] shadow-2xl p-12 text-white flex-grow relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-5">
                            <svg class="w-64 h-64 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path></svg>
                        </div>
                        
                        <h2 class="text-4xl font-bold mb-12 relative z-10">Reach Out</h2>
                        
                        <div class="space-y-10 relative z-10">
                            <!-- Address -->
                            <div class="flex items-start group">
                                <div class="bg-white/10 p-4 rounded-2xl mr-5 shrink-0 group-hover:bg-amber-500 transition-colors duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm text-gray-400 font-semibold mb-2 uppercase tracking-wider">Our Address</h3>
                                    <p class="text-xl font-medium leading-relaxed">
                                        OGGE Travel Agency<br>
                                        Secha, Arba Minch<br>
                                        Ethiopia (P.O. Box 12345)
                                    </p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-start group">
                                <div class="bg-white/10 p-4 rounded-2xl mr-5 shrink-0 group-hover:bg-amber-500 transition-colors duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm text-gray-400 font-semibold mb-2 uppercase tracking-wider">Phone</h3>
                                    <p class="text-xl font-medium leading-relaxed">
                                        +251 911 234 567<br>
                                        +251 912 345 678
                                    </p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-start group">
                                <div class="bg-white/10 p-4 rounded-2xl mr-5 shrink-0 group-hover:bg-amber-500 transition-colors duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm text-gray-400 font-semibold mb-2 uppercase tracking-wider">Email</h3>
                                    <p class="text-xl font-medium text-amber-400 leading-relaxed">
                                        info@oggetravel.com<br>
                                        support@oggetravel.com
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Full Width -->
            <div class="mt-16 bg-white p-5 rounded-[3rem] shadow-2xl border border-gray-100">
                <div class="overflow-hidden rounded-[2.5rem] h-[400px]">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.755681924928!2d37.56395031532617!3d6.022330193548352!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b85f5a9e5e5b7%3A0x1f1b9b9b9b9b9b9b!2sArba%20Minch%2C%20Ethiopia!5e0!3m2!1sen!2sus!4v1633021234567!5m2!1sen!2sus" 
                        width="100%" 
                        height="100%" 
                        style="border:0; filter: grayscale(10%);" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <?php include('../includes/footer.php'); ?>

    <!-- JavaScript for Form Validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const contactForm = document.getElementById('contactForm');

            contactForm.addEventListener('submit', function (e) {
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const message = document.getElementById('message').value.trim();

                if (!name || !email || !message) {
                    e.preventDefault();
                    alert('Please fill out all fields.');
                }
            });
        });
    </script>
</body>
</html>