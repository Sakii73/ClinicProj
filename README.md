# ClinicProj

A simple PHP-based clinic appointment and consultation system with user registration, login, and ticket generation flows.

## Overview

This project provides a front-end user experience for patients and doctors to interact with a clinic application. Users can register, log in, book appointments, and request walk-in consultation tickets.

## User Features

- Login page (`views/login.php`)
  - Username and password form
  - Navigation to registration
- Registration page (`views/register.php`)
  - Username, age, full name, and password fields
  - Role selection: `Doctor` or `Patient`
  - Redirects back to login after account creation
- Home page (`views/home.php`)
  - Welcome message and links to main actions
  - Quick access to: Online Consultation, Our Services, Book an Appointment
- Book Appointment page (`views/book.php`)
  - Patient booking form with:
    - Full name
    - Phone number
    - Appointment date
    - Reason for visit
  - Form validation for required fields, valid phone number, and non-past date
  - Submission opens the schedule ticket page
- Consult Now page (`views/consult.php`)
  - Walk-in consultation form with:
    - Full name
    - Phone number for SMS alert
    - Reason for visit
  - Form validation for required fields and valid phone number
  - Submission opens the walk-in ticket page
- Walk-in Ticket page (`views/walk_in_ticket.php`)
  - Displays a queue number and status updates
  - Includes a cancel ticket button that returns to home
- Schedule Ticket page (`views/schedule_ticket.php`)
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

- The current codebase does not include a separate admin dashboard or admin-specific pages.
- The registration form does allow selecting a role (`Doctor` or `Patient`), but there is no implemented admin control panel or role-based access control in the current views.

## Notes

- `index.php` redirects to the login page by default.
- Shared header and footer are included from `views/layouts/header.php` and `views/layouts/footer.php`.
- The project appears to be a front-end prototype; backend data handling and persistent user/session management are not present in the current files.

## Run Instructions

1. Place the `ClinicProj` folder in your PHP server root (for example, XAMPP `htdocs`).
2. Open `http://localhost/ClinicProj/` in the browser.
3. The app redirects automatically to `views/login.php`.

## File Structure

- `index.php`
- `views/`
  - `login.php`
  - `register.php`
  - `home.php`
  - `book.php`
  - `consult.php`
  - `schedule_ticket.php`
  - `walk_in_ticket.php`
  - `services.php`
  - `layouts/header.php`
  - `layouts/footer.php`
- `public/js/main.js`
- `models/` and `controllers/` folders are present but currently contain placeholder text files.
