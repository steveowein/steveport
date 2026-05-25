# Steve Portfolio 🚀

A premium, database-driven personal portfolio and administrative web application built with vanilla PHP, MySQL, and Bootstrap 5. Designed to showcase projects, skills, and professional experience with a sleek, modern dark-mode aesthetic.

## ✨ Features

### Public Frontend
- **Dynamic Routing:** Clean, extensionless URLs (`/about`, `/portfolio`, `/skills`) handled via a centralized PHP front controller and `.htaccess`.
- **Premium Dark UI:** High-contrast, modern aesthetic using CSS variables, custom hover effects, and responsive Bootstrap grids.
- **Interactive Galleries:** Full-screen SweetAlert2 lightbox viewers for certificates and project images.
- **Automated Contact System:** Fully functional contact form integrated with the Brevo (Sendinblue) API for instant email notifications and auto-responses.
- **Dynamic Content:** All text, images, and resume downloads are driven dynamically from the MySQL database.

### Secure Admin Dashboard
- **Authentication:** Secure session-based admin login system.
- **Comprehensive CRUD Operations:** Full control to Create, Read, Update, and Delete data for:
  - Portfolio Projects (with tech stacks, clients, and multiple images)
  - Skills (with progress bars and icons)
  - Services (with dynamic icons)
  - Certificates (with month/year tracking)
  - Personal Profile details (Hero text, contact info, LinkedIn)
- **Modern Interactions:** Native browser alerts replaced with sleek, global SweetAlert2 toast notifications and confirmation dialogs.
- **Analytics:** Integrated Chart.js dashboard for visualizing messages and content metrics.

## 🛠 Tech Stack
- **Backend:** PHP 8+ (Vanilla)
- **Database:** MySQL (Environment-aware configuration)
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5.3
- **Libraries:** SweetAlert2 (Alerts), Chart.js (Analytics), FontAwesome (Icons)
- **APIs:** Brevo (Email Delivery)

## 🚀 Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/honeyjhanrex03/steveport.git
   cd steveport
   ```

2. **Database Setup (Local):**
   - Ensure you are running a local server (like XAMPP or MAMP).
   - The application is **environment-aware**. If running on `localhost`, it will automatically attempt to create the `portfolio_steve` database and necessary tables.
   - Alternatively, you can manually import the `database/portfolio_steve.sql` file via phpMyAdmin.

3. **API Configuration:**
   - Create a file named `key.php` inside the `core/` directory.
   - Add your Brevo API key:
     ```php
     <?php
     $brevo_api_key = 'your_api_key_here';
     ?>
     ```
   - *Note: `core/key.php` is ignored by Git for security.*

4. **Access the Application:**
   - Public Site: `http://localhost/steveport`
   - Admin Panel: `http://localhost/steveport/admin`
   - Default Admin Credentials:
     - **Username:** `admin`
     - **Password:** `admin123`

## 🔒 Security Notes
- The database connection script (`core/config.php`) automatically suppresses `CREATE DATABASE` queries when deployed to production environments (like InfinityFree) to comply with shared hosting restrictions.
- Sensitive files (like API keys) are strictly ignored via `.gitignore`.
- Admin routes are protected by robust PHP session checks.

---
*Developed by Steve Owein Presidente - Information Systems Student & UI Designer.*
