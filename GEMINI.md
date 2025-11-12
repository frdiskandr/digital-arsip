# Project: Digital Archive

## Project Overview

This is a web application for digital archiving built with the Laravel framework (version 10). It utilizes the Filament admin panel (version 3) for the user interface, providing a rich and reactive experience for managing archives. The application allows users to upload, categorize, and manage digital files. It also includes role-based access control, powered by `bezhansalleh/filament-shield`.

The frontend is built using Vite, with Tailwind CSS for styling.

## Key Technologies

*   **Backend:** PHP 8.1, Laravel 10
*   **Admin Panel:** Filament 3 (which includes Livewire 3, Alpine.js, and Tailwind CSS)
*   **Frontend (Landing Page):** Blade with Tailwind CSS
*   **Database:** (Not specified, but likely MySQL/PostgreSQL as is common with Laravel)
*   **Key Packages:**
    *   `filament/filament`: The admin panel framework.
    *   `spatie/laravel-permission` & `bezhansalleh/filament-shield`: For roles and permissions.
    *   `spatie/laravel-activitylog`: For auditing and activity logging.
    *   `barryvdh/laravel-dompdf`: For PDF generation from HTML.
    *   `emmanpbarrameda/FilamentTakePictureField`: For the "Picture to PDF" feature.

## Core Features

### 1. Archive Management
*   **CRUD Operations:** Full capabilities to create, read, update, and delete archives. The system handles any file type and tracks metadata like title, description, category, subject, and the uploading user.
*   **Advanced File Preview:** An in-browser viewer for various file types, including PDFs, images (JPG, PNG, GIF), and videos (MP4). It also includes experimental support for rendering `.xlsx` and `.txt` files directly.
*   **Trash System (Soft Deletes):** Deleted archives are moved to a "Trash" section, allowing for recovery or permanent deletion, preventing accidental data loss.

### 2. "Picture to PDF" Conversion
*   An innovative feature allowing users to take multiple pictures using their device's camera directly from the web interface.
*   These pictures are then automatically compiled into a single PDF document, which is saved as a new archive record in the system.

### 3. Organization and Classification
*   **Categories & Subjects:** A two-level taxonomy system (Kategori and Subjek) for organizing archives.
*   **Color-Coded Tagging:** Both categories and subjects have a customizable color attribute, which is used to display visually distinct badges in the UI for quick identification.

### 4. Dashboard & Analytics
*   A comprehensive dashboard featuring:
    *   **Stats Overview:** Key metrics like total archives, categories, and unique uploaders, with trend indicators comparing data to the previous month.
    *   **Charts:** Bar charts for monthly archive creation, and doughnut charts for archive distribution by category and by document type (file extension).
    *   **Activity Feed:** A widget showing the most recent upload activities by users.
    *   **Company Profile:** A widget to display the company's logo, name, and slogan.

### 5. User and System Management
*   **User & Role Management:** A complete system for managing users and their roles, integrated with `spatie/laravel-permission`.
*   **Custom User Profile:** A dedicated page for users to update their own profile information and password.
*   **System Settings:** A settings page to manage global application information like the company name, slogan, and logo.

### 6. Auditing and History
*   **Comprehensive Audit Trail:** A system-wide log of all `created`, `updated`, and `deleted` events for major models, allowing administrators to track all activities.
*   **Record-Specific History:** The detail view for archives and other resources includes a timeline of changes specific to that record.

## Development Conventions & Future Development

*   The application follows the standard Laravel project structure.
*   Filament is used for all admin-facing UI. New resources should be created using the appropriate `php artisan make:filament-resource` commands.
*   Custom views and components for Filament are located in `resources/views/filament`.
*   File uploads are stored in the `storage/app/public/arsip` directory. A symbolic link should be created from `public/storage` to `storage/app/public` using `php artisan storage:link`.

For future feature development, the existing stack is robust. Since the admin panel is built on **Filament**, which uses **Livewire**, creating new interactive components without full page reloads is the standard approach. Therefore, for new features within the admin panel, creating new **Livewire components** is the recommended and idiomatic method. All these technologies are fully compatible with the project's **PHP 8.1** environment.