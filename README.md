Shaghalni - Advanced Job Board Platform
Shaghalni is a comprehensive Job Board and Back-office management system built with Laravel. It connects employers with job seekers while providing a robust administrative interface to manage companies, job vacancies, and applications efficiently.

🚀 Features
For Administrators & Companies
Company Management: Complete CRUD operations for companies, including an Archiving System for inactive profiles.

Job Vacancy Control: Create, edit, and track job postings with status management (Active/Archived).

Job Categories: Categorize roles to help candidates find the right opportunities.

Application Tracking: Manage incoming job applications effectively.

User Experience (UI/UX)
Modern Design: Minimalist and sleek interface using Laravel Blade Components.

Interactive Feedback: Integrated Toast Notifications (toast-nav) for real-time user feedback on actions like saving or deleting.

Responsive Layouts: Separate layouts for authenticated users (AppLayout) and guests (GuestLayout).

🛠️ Technical Stack
Backend: PHP 8.x (Laravel Framework)

Database: SQLite (Optimized for local development and performance)

Frontend: Blade Templating, Tailwind CSS (via Vite)

Tools: Git for version control, JSON-based configurations.

📁 Project Structure Highlights
app/View/Components/: Custom logic for reusable UI components.

resources/views/company/: Views for managing company profiles and archives.

resources/views/job-vacancies/: Dedicated modules for posting and viewing jobs.

database/seeders/: Includes DummyJobApplicationSeeder for rapid testing with mock data.