<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Ethiopia - Premium Auth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/custome.css">
    <style>
        body { font-family: 'Outfit', sans-serif; overflow-x: hidden; }
        .auth-bg {
            background-image: url('../assets/images/AdobeStock_272970842_Preview.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .auth-overlay {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.6) 100%);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 40px 60px -15px rgba(0, 0, 0, 0.6);
        }
        .input-modern {
            background: rgba(241, 245, 249, 0.8);
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }
        .input-modern:focus {
            background: #ffffff;
            border-color: #f59e0b;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.15);
            transform: translateY(-2px);
        }
        .text-gradient {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-800">
    <!-- Login Page -->
    <section class="min-h-screen flex items-center justify-center auth-bg relative py-12" id="loginPage">
        <div class="absolute inset-0 auth-overlay"></div>
        
        <!-- Back to home -->
        <a href="index.php" class="absolute top-8 left-8 text-white flex items-center hover:text-amber-400 transition-colors z-20 font-bold text-lg bg-white/10 px-6 py-3 rounded-full backdrop-blur-md border border-white/20 hover:bg-white/20">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Home
        </a>

        <div class="max-w-lg w-full mx-4 glass-panel rounded-[2.5rem] p-10 md:p-12 z-10 relative overflow-hidden transform transition-all">
            <div class="absolute top-0 left-0 w-full h-3 bg-gradient-to-r from-amber-400 via-orange-500 to-amber-600"></div>
            
            <div class="text-center mb-10">
                <div class="w-20 h-20 mx-auto bg-gray-900 rounded-2xl flex items-center justify-center mb-6 shadow-xl transform rotate-3">
                    <img src="../assets/images/image.png" alt="logo" class="w-14 h-14 drop-shadow-md -rotate-3">
                </div>
                <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">Welcome <span class="text-gradient">Back</span></h2>
                <p class="text-gray-500 mt-3 font-medium text-lg">Sign in to your premium travel account</p>
            </div>

            <form class="space-y-6" id="loginForm" action="../includes/login.php" method="post">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl mb-6 shadow-sm flex items-center">
                        <svg class="h-6 w-6 text-red-400 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        <span class="text-sm font-bold"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></span>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-xl mb-6 shadow-sm flex items-center">
                        <svg class="h-6 w-6 text-emerald-400 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="text-sm font-bold"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></span>
                    </div>
                <?php endif; ?>
                <div>
                    <label class="block text-sm font-extrabold text-gray-700 mb-2 uppercase tracking-wide">Email Address</label>
                    <input type="email" name="email"
                           class="w-full px-6 py-4 rounded-2xl input-modern focus:outline-none text-gray-900 placeholder-gray-400 font-semibold text-lg"
                           placeholder="you@example.com"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-extrabold text-gray-700 mb-2 uppercase tracking-wide">Password</label>
                    <input type="password" name="password"
                           class="w-full px-6 py-4 rounded-2xl input-modern focus:outline-none text-gray-900 placeholder-gray-400 font-semibold text-lg"
                           placeholder="••••••••"
                           required>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center group">
                        <input type="checkbox" id="remember" class="h-5 w-5 text-amber-500 focus:ring-amber-500 border-gray-300 rounded cursor-pointer transition-all">
                        <label for="remember" class="ml-3 text-base text-gray-600 cursor-pointer font-bold group-hover:text-gray-900 transition-colors">Remember me</label>
                    </div>
                    <a href="#" class="text-base font-extrabold text-amber-600 hover:text-amber-700 transition-colors">Forgot password?</a>
                </div>

                <button type="submit" 
                        class="w-full bg-gray-900 text-white font-extrabold text-xl py-5 rounded-2xl hover:bg-amber-500 transition-colors duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 active:scale-95 flex justify-center items-center mt-4 group">
                    Sign In to Portal
                    <svg class="w-6 h-6 ml-3 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>

                <div class="relative mt-10 mb-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-bold uppercase tracking-wider">New to OGGE?</span>
                    </div>
                </div>

                <button type="button" onclick="showRegister(); return false;"
                        class="w-full bg-white text-gray-900 font-extrabold text-lg py-4 rounded-2xl border-2 border-gray-200 hover:border-gray-900 transition-all">
                    Create an Account
                </button>
            </form>
        </div>
    </section>

    <!-- Register Page (Hidden by default) -->
    <section class="min-h-screen hidden items-center justify-center auth-bg relative py-12" id="registerPage">
        <div class="absolute inset-0 auth-overlay"></div>
        
        <!-- Back to home -->
        <a href="index.php" class="absolute top-8 left-8 text-white flex items-center hover:text-amber-400 transition-colors z-20 font-bold text-lg bg-white/10 px-6 py-3 rounded-full backdrop-blur-md border border-white/20 hover:bg-white/20">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Home
        </a>

        <div class="max-w-lg w-full mx-4 glass-panel rounded-[2.5rem] p-10 md:p-12 z-10 relative overflow-hidden transform transition-all">
            <div class="absolute top-0 left-0 w-full h-3 bg-gradient-to-r from-emerald-400 via-teal-500 to-emerald-600"></div>
            
            <div class="text-center mb-8">
                <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">Create <span class="text-gradient">Account</span></h2>
                <p class="text-gray-500 mt-3 font-medium text-lg">Join the ultimate Ethiopian travel experience</p>
            </div>

            <form class="space-y-5" id="registerForm" action="../includes/register.php" method="post">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl shadow-sm">
                        <span class="text-sm font-bold"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-xl shadow-sm">
                        <span class="text-sm font-bold"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
                    </div>
                <?php endif; ?>

                <div>
                    <label class="block text-sm font-extrabold text-gray-700 mb-2 uppercase tracking-wide">Full Name</label>
                    <input type="text" name="name"
                           class="w-full px-6 py-3.5 rounded-2xl input-modern focus:outline-none text-gray-900 placeholder-gray-400 font-semibold"
                           placeholder="John Doe"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-extrabold text-gray-700 mb-2 uppercase tracking-wide">Email Address</label>
                    <input type="email" name="email"
                           class="w-full px-6 py-3.5 rounded-2xl input-modern focus:outline-none text-gray-900 placeholder-gray-400 font-semibold"
                           placeholder="you@example.com"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-extrabold text-gray-700 mb-2 uppercase tracking-wide">Phone Number</label>
                    <input type="tel" name="phone"
                           class="w-full px-6 py-3.5 rounded-2xl input-modern focus:outline-none text-gray-900 placeholder-gray-400 font-semibold"
                           pattern="[+]{0,1}[0-9]{10,13}"
                           placeholder="+251 911 234 567"
                           required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-extrabold text-gray-700 mb-2 uppercase tracking-wide">Password</label>
                        <input type="password" name="password"
                               class="w-full px-6 py-3.5 rounded-2xl input-modern focus:outline-none text-gray-900 font-semibold"
                               placeholder="••••••••"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm font-extrabold text-gray-700 mb-2 uppercase tracking-wide">Confirm</label>
                        <input type="password" name="confirmPassword"
                               class="w-full px-6 py-3.5 rounded-2xl input-modern focus:outline-none text-gray-900 font-semibold"
                               placeholder="••••••••"
                               required>
                    </div>
                </div>

                <div class="flex items-start pt-3 pb-2">
                    <input type="checkbox" id="terms" class="h-5 w-5 text-emerald-500 focus:ring-emerald-500 border-gray-300 rounded cursor-pointer mt-0.5 transition-all" required>
                    <label for="terms" class="ml-3 text-base text-gray-600 font-semibold">
                        I agree to the 
                        <a href="#" class="text-emerald-600 hover:text-emerald-700 font-bold underline">Terms & Conditions</a>
                    </label>
                </div>

                <button type="submit" 
                        class="w-full bg-gray-900 text-white font-extrabold text-xl py-5 rounded-2xl hover:bg-emerald-500 transition-colors duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 active:scale-95">
                    Create Account
                </button>

                <div class="relative mt-8 mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-bold uppercase tracking-wider">Already a Member?</span>
                    </div>
                </div>

                <button type="button" onclick="showLogin(); return false;"
                        class="w-full bg-white text-gray-900 font-extrabold text-lg py-4 rounded-2xl border-2 border-gray-200 hover:border-gray-900 transition-all">
                    Sign in to Portal
                </button>
            </form>
        </div>
    </section>

    <script src="../assets/js/auth.js"></script>
    <script>
        function showRegister() {
            document.getElementById('loginPage').classList.add('hidden');
            document.getElementById('registerPage').classList.remove('hidden');
            document.getElementById('registerPage').classList.add('flex');
        }
        function showLogin() {
            document.getElementById('registerPage').classList.add('hidden');
            document.getElementById('registerPage').classList.remove('flex');
            document.getElementById('loginPage').classList.remove('hidden');
        }
    </script>
</body>
</html>