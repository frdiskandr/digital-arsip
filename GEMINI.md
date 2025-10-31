# Project: Digital Archive

## Project Overview

This is a web application for digital archiving built with the Laravel framework (version 10). It utilizes the Filament admin panel (version 3) for the user interface, providing a rich and reactive experience for managing archives. The application allows users to upload, categorize, and manage digital files. It also includes role-based access control, powered by `bezhansalleh/filament-shield`.

The frontend is built using Vite, with Tailwind CSS for styling.

## Key Technologies

*   **Backend:** PHP 8.1, Laravel 10
*   **Admin Panel:** Filament 3
*   **Frontend:** Vite, Tailwind CSS
*   **Database:** (Not specified, but likely MySQL/PostgreSQL as is common with Laravel)

## Building and Running

1.  **Install Dependencies:**
    *   Run `composer install` to install PHP dependencies.
    *   Run `npm install` to install frontend dependencies.

2.  **Environment Setup:**
    *   Copy the `.env.example` file to `.env`: `cp .env.example .env`
    *   Generate an application key: `php artisan key:generate`
    *   Configure your database connection in the `.env` file.

3.  **Database Migration:**
    *   Run the database migrations to create the necessary tables: `php artisan migrate`

4.  **Running the Application:**
    *   Start the development server: `php artisan serve`
    *   Run the Vite development server for frontend assets: `npm run dev`

5.  **Building for Production:**
    *   Build the frontend assets for production: `npm run build`

## Development Conventions

*   The application follows the standard Laravel project structure.
*   Filament is used for all admin-facing UI. New resources should be created using the appropriate `php artisan make:filament-resource` commands.
*   File uploads are stored in the `storage/app/public/arsip` directory. A symbolic link should be created from `public/storage` to `storage/app/public` using `php artisan storage:link`.
*   The `bezhansalleh/filament-shield` package is used for managing roles and permissions.
