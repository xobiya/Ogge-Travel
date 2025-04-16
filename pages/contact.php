<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
   
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <?php include('../includes/header.php'); ?>

    <!-- Contact Section -->
    <section class="py-16">
        <div class="container">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    Contact Us
                </h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Have questions or need assistance? We're here to help! Reach out to us via the form below or visit our office.
                </p>
            </div>

            <!-- Contact Content -->
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Send Us a Message</h2>
                    <form id="contactForm" action="../includes/contact-submit.php" method="POST">
                        <div class="space-y-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" name="name" id="name" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                       placeholder="Enter your name" required>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email" id="email" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                       placeholder="Enter your email" required>
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                <textarea name="message" id="message" rows="5"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                          placeholder="How can we help you?" required></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full bg-amber-500 text-white py-3 px-6 rounded-lg hover:bg-amber-600 transition-colors">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Our Office</h2>
                    <div class="space-y-6">
                        <!-- Address -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Address</h3>
                            <p class="text-gray-600">
                                OGGE Travel Agency<br>
                                Secha, Arba Minch, Ethiopia<br>
                                P.O. Box 12345
                            </p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Phone</h3>
                            <p class="text-gray-600">
                                +251 911 234 567<br>
                                +251 912 345 678
                            </p>
                        </div>

                        <!-- Email -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Email</h3>
                            <p class="text-gray-600">
                                info@oggetravel.com<br>
                                support@oggetravel.com
                            </p>
                        </div>

                        <!-- Map -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Location</h3>
                            <div class="overflow-hidden rounded-lg">
                                <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.755681924928!2d37.56395031532617!3d6.022330193548352!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b85f5a9e5e5b7%3A0x1f1b9b9b9b9b9b9b!2sArba%20Minch%2C%20Ethiopia!5e0!3m2!1sen!2sus!4v1633021234567!5m2!1sen!2sus" 
                                width="100%" 
                                    height="300" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                   >
                                </iframe>
                            </div>
                        </div>
                    </div>
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