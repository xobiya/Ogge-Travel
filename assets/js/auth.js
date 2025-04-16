// Show Register Page
function showRegister() {
    document.getElementById('loginPage').classList.add('hidden');
    document.getElementById('registerPage').classList.remove('hidden');
    document.getElementById('registerPage').classList.add('flex');
}

// Show Login Page
function showLogin() {
    document.getElementById('registerPage').classList.add('hidden');
    document.getElementById('loginPage').classList.remove('hidden');
    document.getElementById('loginPage').classList.add('flex');
}

// Handle Login Form Submission
// document.getElementById('loginForm').addEventListener('submit', function(e) {
//     e.preventDefault();
    
//     // Collect form data
//     const formData = new FormData(this);
    
//     fetch('.../includes/login.php', {
//         method: 'POST',
//         body: formData
//     })
//     .then(response => response.text()) 
//     .then(data => {
//         console.log(data); // Debugging output
//         if (data.includes("success")) {
//             window.location.href = '../pages/index.php'; // Redirect on success
//         } else {
//             alert("Login failed. Check your email and password.");
//         }
//     })
//     .catch(error => console.error('Error:', error));
// });

// // Handle Register Form Submission
// document.getElementById('registerForm').addEventListener('submit', function(e) {
//     e.preventDefault();

//     // Collect form data
//     const formData = new FormData(this);
    
//     fetch('.../includes/register.php', {
//         method: 'POST',
//         body: formData
//     })
//     .then(response => response.text()) 
//     .then(data => {
//         console.log(data); // Debugging output
//         if (data.includes("success")) {
//             window.location.href = '../pages/index.php'; // Redirect on success
//         } else {
//             alert("Registration failed. Try again.");
//         }
//     })
//     .catch(error => console.error('Error:', error));
// });

// Mobile Menu Toggle
document.getElementById('menuBtn').addEventListener('click', function () {
    const mobileMenu = document.getElementById('mobileMenu');
    const isOpen = mobileMenu.getAttribute('data-open') === 'true';
    mobileMenu.classList.toggle('hidden', isOpen);
    mobileMenu.setAttribute('data-open', isOpen ? 'false' : 'true');
});
