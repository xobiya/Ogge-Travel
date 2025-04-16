// document.addEventListener('DOMContentLoaded', () => {
//     // Set minimum date for travel_date input
//     document.querySelector('input[name="travel_date"]').min = new Date().toISOString().split('T')[0];

//     // Handle form submission
//     document.getElementById('bookingForm').addEventListener('submit', async (e) => {
//         e.preventDefault();

//         // Basic validation
//         const travelers = document.querySelector('select[name="travelers"]');
//         const terms = document.getElementById('terms');

//         if (!travelers.value) {
//             alert('Please select number of travelers');
//             return;
//         }

//         if (!terms.checked) {
//             alert('You must agree to terms and conditions');
//             return;
//         }

//         // Submit form
//         try {
//             const formData = new FormData(e.target);
            
//             const response = await fetch('../includes/booking.php', {
//                 method: 'POST',
//                 body: formData
//             });
            
//             if (response.ok) {
//                 window.location.href = 'booking_success.php';
//             } else {
//                 alert('Booking failed - please try again');
//             }
//         } catch (error) {
//             alert('Network error - please check your connection');
//         }
//     });
// });

document.addEventListener('DOMContentLoaded', () => {
    // Set minimum date for travel date input
    document.querySelector('input[name="travel_date"]').min = new Date().toISOString().split('T')[0];
    
    // Basic form validation
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        const travelers = document.querySelector('select[name="travelers"]');
        const terms = document.getElementById('terms');

        if (!travelers.value) {
            alert('Please select number of travelers');
            e.preventDefault();
            return;
        }

        if (!terms.checked) {
            alert('You must agree to terms and conditions');
            e.preventDefault();
            return;
        }
    });
});