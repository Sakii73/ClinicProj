# CliniCare

A simple PHP-based clinic appointment and consultation system with user registration, login, and ticket generation flows.

## Overview

This project provides a front-end user experience for patients and doctors to interact with a clinic application.

## Features

- User registration and login with role selection for `Doctor` or `Patient`
- Appointment booking with validation for full name, phone number, appointment date, and reason for visit
- Walk-in consultation ticket creation with queue number display and ticket cancellation
- Scheduled appointment ticket display after booking
- Client-side validation and interactive feedback in `public/js/main.js`
- Shared layout templates for consistent header and footer navigation
- Role-based user types to support admin/doctor workflow in future enhancements

## User Features

- Login page (`views/patient/login.php`)
  - Username and password form
  - Navigation to registration
- Registration page (`views/patient/register.php`)
  - Username, age, full name, and password fields
  - Role selection: `Doctor` or `Patient`
  - Redirects back to login after account creation
- Home page (`views/patient/home.php`)
  - Welcome message and links to main actions
  - Quick access to: Online Consultation, Our Services, Book an Appointment
- Book Appointment page (`views/patient/book.php`)
  - Patient booking form with:
    - Full name
    - Phone number
    - Appointment date
    - Reason for visit
  - Form validation for required fields, valid phone number, and non-past date
  - Submission opens the schedule ticket page
- Consult Now page (`views/patient/consult.php`)
  - Walk-in consultation form with:
    - Full name
    - Phone number for SMS alert
    - Reason for visit
  - Form validation for required fields and valid phone number
  - Submission opens the walk-in ticket page
- Walk-in Ticket page (`views/patient/walk_in_ticket.php`)
  - Displays a queue number and status updates
  - Includes a cancel ticket button that returns to home
- Schedule Ticket page (`views/patient/schedule_ticket.php`)
  - Displays a scheduled appointment ticket with placeholder patient information
  - Includes a link back to home

## Client-side Behavior

- Form validation is handled in `public/js/main.js`
  - Full name must be present and at least 3 characters
  - Phone number must be 10-11 digits
  - Date cannot be in the past for appointment bookings
  - Reason selection must be completed
- Visual feedback and animations
  - Input error highlighting
  - Animated page elements on load
  - Submit button state changes during form submission
  - Dynamic walk-in ticket queue number and status simulation

## Admin Features

- Admin Dashboard implemented with separate pages and a top navigation bar (Multi-Page Application).
- **Dashboard Overview (`views/admin/dashboard.php`)**: Key metrics and quick actions.
- **Queue Management (`views/admin/queue.php`)**: Active station view to handle walk-in patients from `consult.php`.
- **Appointments Management (`views/admin/appointments.php`)**: Table view to confirm or cancel scheduled appointments coming from `book.php`.
- **Staff & Doctors (`views/admin/staff.php`)**: Grid view to monitor registered medical staff and their duty status.
- Note: Currently purely front-end with hardcoded HTML for demonstration.

## Notes

- `index.php` redirects to the login page by default.
- Shared header and footer are included from `views/patient/layouts/header.php` and `views/patient/layouts/footer.php`.
- The project appears to be a front-end prototype; backend data handling and persistent user/session management are not present in the current files.

## Run Instructions

1. Place the `CliniCare` folder in your PHP server root (for example, XAMPP `htdocs`).
2. Open `http://localhost/CliniCare/` in the browser.
3. The app redirects automatically to `views/patient/login.php`.

## File Structure

- `index.php`
- `views/`
  - `patient/`
    - `home.php`, `book.php`, `consult.php`, `login.php`, `register.php`, etc. (Patient-facing views)
    - `layouts/header.php`, `layouts/footer.php`
  - `admin/`
    - `dashboard.php`, `queue.php`, `appointments.php`, `staff.php`
    - `layouts/admin_header.php`, `layouts/admin_footer.php`
- `public/`
  - `css/`
  - `js/`
- `models/` and `controllers/` folders are present but currently contain placeholder text files.
