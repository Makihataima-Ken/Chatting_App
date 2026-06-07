# Chatting_App Backend

This folder contains the Laravel backend for the full-stack chat application.

The backend provides:

- User authentication and chat participant management
- Chat and message storage with Eloquent models and migrations
- Real-time event broadcasting and notifications
- API endpoints consumed by the Flutter frontend

## Requirements

- PHP 8.2+
- Composer
- Node.js / npm (for frontend tooling)
- A database supported by Laravel (SQLite, MySQL, PostgreSQL, etc.)

## Setup

From the `backend/` folder:

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database settings, then run:

```bash
php artisan migrate
```

If you need to reset and seed the database:

```bash
php artisan migrate:fresh --seed
```

## Frontend Assets (Optional)

Install frontend dependencies and run the Vite asset pipeline if needed:

```bash
npm install
npm run dev
```

## Local Development

Run the backend server locally:

```bash
php artisan serve
```

The app will be available at `http://127.0.0.1:8000` by default.

## Notes

- Configure the Flutter frontend to use the backend base URL.
- Update `.env` values for broadcast and notification services if required.

## License

This backend is part of the Chatting_App project and is licensed under the MIT License.
