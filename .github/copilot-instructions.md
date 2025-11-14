## Purpose

Short, actionable guidance for an AI coding agent to be productive in the Digital Arsip repository (Laravel 10 + Filament 3).

## Quick setup & common commands

- Install PHP deps: `composer install`
- Install frontend deps: `npm install`
- Start Laravel dev server: `php artisan serve`
- Start Vite dev server: `npm run dev`
- Run migrations: `php artisan migrate`
- Create storage symlink: `php artisan storage:link`
- Run tests: `./vendor/bin/phpunit` (or `php artisan test`)
- Docker compose (local): uses `environtment-compose.yml` (services: php, node, mariadb)

If you need to run with the provided compose file, the repository uses `environtment-compose.yml` (note spelling) to bring up PHP-FPM, Node and MariaDB.

## Big-picture architecture (what to know first)

- This is a Laravel 10 application (PHP ^8.1) with a Filament 3 admin panel.
- Primary domain object: `Arsip` (app/Models/Arsip.php). It stores uploaded files (file_path) and keeps historical versions in `ArsipVersion` via `versions()`.
- Admin UI is implemented using Filament resources under `app/Filament/Resources/*` (e.g. `ArsipResource.php` and its Pages/RelationManagers).
- Routes used for public actions (view/download) are in `routes/web.php` and are protected by `auth` middleware.
- Activity logging uses `spatie/laravel-activitylog` (see model trait `LogsActivity` in `App\\Models\\Arsip`).

## Project-specific patterns and conventions

- File storage and naming:
  - Uploads are stored under the `local` disk in a `arsip` directory. Filament's `FileUpload` in `ArsipResource` sets a custom filename using `getUploadedFileNameForStorageUsing(...)`. Look at `app/Filament/Resources/ArsipResource.php` for the exact behaviour: filenames are `YYYY-MM-DD-HHMMSS_<md5>_<original-filename>`.
  - The `Arsip` model `setFilePathAttribute` extracts and populates `original_file_name` from that stored filename when needed.

- Versioning:
  - `App\\Models\\Arsip` contains a `booted()` saving listener which snapshots the previous state into `versions()` and increments `version` on updates. When editing archive logic, preserve that behaviour.

- Filament conventions:
  - Resources live in `app/Filament/Resources/<ResourceName>`, pages in `Pages/`, and relation managers in `RelationManagers/`.
  - UI actions (view/download/edit/delete) often call routes and controllers in `app/Http/Controllers` or use Filament page routes defined in the resource's `getPages()`.

- Authorization:
  - Filament Shield (`bezhansalleh/filament-shield`) is used for role/permission management. Super admin tooling is used for bootstrapping (`php artisan shield:super-admin`).

## Typical edit areas and where to look

- To change how files are named or stored: `app/Filament/Resources/ArsipResource.php` (the `FileUpload::make(...)->getUploadedFileNameForStorageUsing(...)` closure) and `config/filesystems.php` if disk behavior needs changing.
- To change versioning or metadata behavior: `app/Models/Arsip.php` (booted saving hook, accessors/mutators such as `setFilePathAttribute` and `getOriginalFileNameAttribute`).
- To change list/display logic in admin: `app/Filament/Resources/ArsipResource.php` (table columns and badges).
- To add a public route for file access, see `routes/web.php` and the controllers in `app/Http/Controllers` (e.g., `ArsipViewController`, `ArsipDownloadController`).

## Tests & CI hints

- PHPUnit config is `phpunit.xml`. Tests assume a non-persistent in-memory or array drivers for many services; DB env vars are commented for sqlite in phpunit.xml — tests may set up a test DB.
- Use `php artisan test` or `./vendor/bin/phpunit` to run unit/feature tests.

## Notable caveats & gotchas

- The repo includes an `environtment-compose.yml` (note the typo). If you automate compose-based tasks, use that filename or ask the maintainers before renaming.
- Filament resources rely on database seeders/data (users/roles/categories) for useful UI; seeding workflows might be present in `database/seeders`.
- File uploads use the `local` disk and `storage/app/arsip`; ensure `php artisan storage:link` is run in dev so `url('storage/...')` works.

## Where to find things (quick map)

- Models: `app/Models/`
- Filament admin: `app/Filament/Resources/`
- Controllers (view/download): `app/Http/Controllers/`
- Routes: `routes/web.php` and `routes/api.php`
- Config: `config/*.php` (notably `filesystems.php`, `app.php`, `permission.php`)
- Tests: `tests/Unit`, `tests/Feature`

## Example actionable tasks (how to implement safely)

- If asked to change upload naming: update closure in `ArsipResource` and ensure `Arsip::setFilePathAttribute()` remains compatible to extract original filename.
- If asked to add a new Filament page/table column: add a Column in `ArsipResource::table()` and follow existing patterns for `formatStateUsing`/`extraCellAttributes`.

---
If anything above is unclear or you need more examples (specific files, tests to run, or local dev notes), tell me which area to expand and I'll update this file accordingly.
