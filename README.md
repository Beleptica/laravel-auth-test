# Laravel Auth Demo

A minimal Laravel app where an **administrator can impersonate a user by username**.  

## Tech Stack

- PHP 8.4, Laravel (latest)
- Laravel Breeze (Blade) for auth scaffolding
- Web guard (session + cookie)
- MySQL 8 (Docker) or SQLite (local)
- Docker Compose (nginx + php-fpm + mysql)
- Vite build for assets

## Authentication & Authorization

- **Login/Registration**: Provided by Laravel Breeze (email + password).
- **Users**: `users` table includes:
  - `username` (unique) — used for admin impersonation
  - `is_admin` (boolean)
- **Authorization**:
  - Admin-only pages protected by `EnsureAdmin` middleware.
  - Dashboard requires `auth` (+ `verified` if email verification is enabled).
- **CSRF & Rate Limiting**:
  - CSRF protection enabled for all POST requests.
  - Impersonation start is rate-limited (`throttle:10,1`).

## Impersonation Mechanism (DIY)

- **Start**: Admin submits a username on `/admin/impersonate`.
  - Validates username.
  - Rejects if target not found, is admin, or equals current user.
  - Saves `impersonator_id` in session.
  - Switches identity with `Auth::loginUsingId($targetId)` and regenerates session.
- **Stop**: POST `/impersonate/stop`.
  - Reads `impersonator_id`, logs admin back in via `Auth::loginUsingId`, removes the session key, regenerates session.
- **UI Indicator**: A top banner shows “You are impersonating: {username}” with a “Return to admin” button.
- **Constraints**:
  - Single-level impersonation.
  - Admin accounts cannot be impersonated.
  - Session is regenerated on start/stop.

## Default Accounts

- **Administrator**
  - Email: `admin@example.com`
  - Username: `admin`
  - Password: `password`
- **Users**
  - `alice` / password `password`
  - `bob` / password `password`

## Routes

- Auth: `/login`, `/register`, `/logout`, `/forgot-password`, etc. (Breeze)
- App:
  - `/` → redirects to `/login` if guest, or `/dashboard` if authenticated
  - `/dashboard` (auth)
- Impersonation:
  - `GET /admin/impersonate` (admin) — form
  - `POST /admin/impersonate` (admin) — start
  - `POST /impersonate/stop` (auth + active impersonation) — stop
- Profile (Breeze): `/profile` (optional; included for completeness)

## UI Notes

- Guest pages show a top-right switcher: **Log in / Register**.
- Minimal Blade views only.

## Quick Start (Docker + MySQL)

1. Copy environment:
`cp .env.docker .env`
2. Start containers:
`docker compose up -d --build`
3. Install and bootstrap:
`docker compose exec php composer install`
`docker compose exec php php artisan key:generate`
`docker compose exec php php artisan migrate --force`
`docker compose exec php php artisan db:seed --force`
4. Build assets (on host):
`npm install`
`npm run build`
5. Open: `http://localhost:8080`

## Security Considerations

- Session regeneration on impersonation start/stop.
- No impersonation of administrators.
- Single-level impersonation only.
- Throttled start endpoint to limit abuse.

## Repository Contents

- Laravel sources
- `docker-compose.yml`, `docker/php/Dockerfile`, `docker/php/entrypoint.sh`, `docker/nginx/default.conf`
- Migrations and seeders (`AdminUserSeeder`, `DemoUsersSeeder`)
- Breeze auth scaffolding with added `username`
- Minimal Blade views including the impersonation form and banner
- This README