<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Ethiopia - Auth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/custome.css">
    <style>
        .auth-bg {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                            url('../assets/images/AdobeStock_272970842_Preview.jpeg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-100">
   <?php include('../includes/header.php'); ?>

    <!-- Login Page -->
    <section class="min-h-screen flex items-center justify-center auth-bg" id="loginPage">
        <div class="max-w-md w-full mx-4 bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Welcome Back</h2>
                <p class="text-gray-600">Sign in to your Ethiopian Travel account</p>
            </div>

            <form class="space-y-6" id="loginForm" action="../includes/login.php" method="post">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                <div>
                    <label class="block text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                           required>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" class="h-4 w-4 text-amber-500 focus:ring-amber-500 border-gray-300 rounded">
                        <label class="ml-2 text-gray-600">Remember me</label>
                    </div>
                    <a href="#" class="text-amber-600 hover:text-amber-700">Forgot password?</a>
                </div>

                <button type="submit" 
                        class="w-full bg-amber-500 text-white py-3 rounded-lg hover:bg-amber-600 transition-colors">
                    Sign In
                </button>

                <p class="text-center text-gray-600">
                    Don't have an account? 
                    <a href="#" class="text-amber-600 hover:text-amber-700" onclick="showRegister()">Create one</a>
                </p>
            </form>
        </div>
    </section>

    <!-- Register Page (Hidden by default) -->
    <section class="min-h-screen hidden items-center justify-center auth-bg" id="registerPage">
        <div class="max-w-md w-full mx-4 bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Create Account</h2>
                <p class="text-gray-600">Join Ethiopian Travel Adventures</p>
            </div>

            <form class="space-y-6" id="registerForm" action="../includes/register.php" method="post">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <!-- Rest of your form fields -->
                <div>
                    <label class="block text-gray-700 mb-2" for="name">Full Name</label>
                    <input type="text" name="name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="email" >Email Address</label>
                    <input type="email" name="email"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="phone" >Phone Number</label>
                    <input type="tel" name="phone"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                           pattern="[+]{0,1}[0-9]{10,13}"
                           placeholder="+251 XXX XXX XXX"
                           required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-2" for="password">Password</label>
                        <input type="password" name="password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                               required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2" for="confirmPassword">Confirm Password</label>
                        <input type="password" name="confirmPassword"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                               required>
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" class="h-4 w-4 text-amber-500 focus:ring-amber-500 border-gray-300 rounded" required>
                    <label class="ml-2 text-gray-600">
                        I agree to the 
                        <a href="#" class="text-amber-600 hover:text-amber-700">Terms & Conditions</a>
                    </label>
                </div>

                <button type="submit" 
        class="w-full bg-amber-500 text-white py-3 rounded-lg hover:bg-amber-600 transition-colors">
    Create Account
</button>

                <p class="text-center text-gray-600">
                    Already have an account? 
                    <a href="#" class="text-amber-600 hover:text-amber-700" onclick="showLogin()">Sign in</a>
                </p>
            </form>
        </div>
    </section>

 <?php include('../includes/footer.php'); ?>

    <script src="../assets/js/auth.js">
    </script>
</body>
</html>