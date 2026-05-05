# OGGE Travel | The Curated Escape 🌍✨

![Ogge Website](image.png)

**The Curated Escape** is a premium, editorial-style luxury concierge web application built to showcase the rich cultural heritage and breathtaking landscapes of Ethiopia. Transitioning from a standard booking engine into an immersive storytelling platform, this application provides users with an elevated, high-touch travel booking experience.

---

## 🌟 Key Features

*   **Cinematic Design System:** Built with a sophisticated `Deep Navy` and `Champagne Gold` color palette, featuring glassmorphism elements, staggered scroll-reveal animations, and Ken Burns hero effects.
*   **The Heritage Suite (Dynamic Content Engine):** A custom PHP-driven architecture (`heritage-data.php`) that acts as a "Living Encyclopedia," dynamically rendering deep destination lore, "Insider's Edit" tips, and Sensory Profiles without bloating the database.
*   **Traveler Journals:** A fully integrated community blogging platform allowing members to upload images and share stories of their Ethiopian adventures.
*   **High-Touch Concierge:** Transitioned from transactional "Book Now" flows to aspirational "Seal Your Journey" requests, complete with a persistent WhatsApp floating widget for 24/7 concierge access.
*   **Private Member Dashboard:** An ultra-premium, dark-themed portal where authenticated users can view their journey folios, calculate travel investments in real-time, and edit their profiles.

---

## 🛠️ Tech Stack

*   **Frontend:** HTML5, Tailwind CSS, Vanilla JavaScript (Intersection Observers, Parallax)
*   **Typography:** Playfair Display (Headings), Inter (UI), Cormorant Garamond (Narrative)
*   **Backend:** Core PHP (Session Management, Routing, Dynamic Rendering)
*   **Database:** MySQL (Relational Schema for Users, Packages, Bookings, and Journals)
*   **Deployment:** InfinityFree (FTP), GitHub Actions (CI/CD)

---

## 🚀 Local Development Setup

To run this project locally, you will need a local server environment like XAMPP, WAMP, or MAMP.

1.  **Clone the Repository**
    Clone or download this repository into your local server's root directory (e.g., `C:\xampp\htdocs\Ogge-Travel`).

2.  **Database Setup**
    *   Open your local phpMyAdmin (usually `http://localhost/phpmyadmin`).
    *   Create a new database named `travel_agency`.
    *   Import the provided SQL file: `Database/travel_agency.sql` into the new database.

3.  **Configure Database Connection**
    *   Open `includes/db-connect.php`.
    *   Ensure the credentials match your local setup (usually `localhost`, `root`, with no password).

4.  **Run the Application**
    *   Start Apache and MySQL in your XAMPP/MAMP control panel.
    *   Navigate to `http://localhost/Ogge-Travel/pages/index.php` in your browser.

---