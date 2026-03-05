# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

ANRI web-dabb is an Indonesian government archival web application (ANRI = Arsip Nasional Republik Indonesia) built with Laravel 12, Tailwind CSS 3, Alpine.js, and Vite 7. It runs on PHP 8.2+ with Laragon on Windows.

## Common Commands

- **Full setup:** `composer setup` (installs deps, generates key, runs migrations, builds frontend)
- **Dev server (all services):** `composer dev` (starts Laravel server, queue worker, Pail logs, and Vite concurrently)
- **Build frontend:** `npm run build`
- **Run tests:** `composer test` (clears config cache then runs PHPUnit)
- **Single test:** `php artisan test --filter=TestClassName`
- **Lint/format PHP:** `./vendor/bin/pint`
- **Run migrations:** `php artisan migrate`
- **Seed database:** `php artisan db:seed`

## Architecture

### Role-Based Multi-Dashboard System
Users have a `role` column (added via migration) with values: `admin`, `pegawai`, `pelajar_mahasiswa`, `instansi_swasta`, `umum`. The `RoleDashboardController` redirects `/dashboard` to role-specific dashboards. Each role has:
- A dedicated dashboard view in `resources/views/dashboards/{role}.blade.php`
- Role-specific User model variants in `app/Models/` (UserAdmin, UserPegawai, UserPelajar, UserInstansi, UserUmum)

### Middleware
- `RoleMiddleware` (`role:{role_name}`) — gates routes by user role, registered as alias in `bootstrap/app.php`
- `SetLocale` — auto-detects locale from session or browser `Accept-Language` header, appended to web middleware stack

### Localization
Bilingual (Indonesian `id` / English `en`). Language files in `resources/lang/{locale}/`. Locale switching via `/lang/{locale}` route. Default locale is `id`.

### Layouts
- `layouts/app.blade.php` — main public layout
- `layouts/guest.blade.php` — auth pages
- `layouts/internal-dashboard.blade.php` — authenticated dashboard layout with sidebar

### CMS (Admin Only)
Admin-only content management under `/cms/` prefix:
- `HomeContentController` — edits homepage content
- `FeatureController` — CRUD for features with sub-features support
- Views in `resources/views/cms/`

### Auth
Uses Laravel Breeze (`laravel/breeze` dev dependency). Auth routes in `routes/auth.php`.

### Frontend
- Vite with `laravel-vite-plugin`, entry points: `resources/css/app.css` and `resources/js/app.js`
- Tailwind CSS 3 with `@tailwindcss/forms` plugin
- Alpine.js for interactivity
- Custom sidebar CSS in `public/css/sidebar.css`

### Chat Bot
`ChatController` handles AI chat bot responses via POST `/api/chat`.
