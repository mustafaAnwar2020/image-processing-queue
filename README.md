# Image Upload & Processing Application

A modern Laravel application for uploading and processing images with real-time status updates. Built with Laravel 12, featuring queue-based image processing, authentication, and a beautiful UI with Tailwind CSS.

## Features

-  **User Authentication** - Secure login and registration system
-  **Image Upload** - Upload images (JPEG, PNG, JPG, GIF, WEBP) up to 2MB
-  **Queue Processing** - Background job processing for image resizing
-  **Real-time Status Updates** - Live status updates without page refresh
-  **Image Variants** - Automatic generation of thumbnails, medium, and large sizes
-  **Modern UI** - Beautiful interface with Tailwind CSS and dark mode support
-  **Responsive Design** - Works seamlessly on desktop and mobile devices

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Blade Templates, Tailwind CSS 4, Vite
- **Image Processing**: Intervention Image v3
- **Database**: MySQL/PostgreSQL
- **Queue**: Laravel Queue System

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js 20.19+ or 22.12+ (for Vite)
- NPM or Yarn
- MySQL/PostgreSQL

## Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd queuesApp
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Database setup

For SQLite (default):
```bash
touch database/database.sqlite
```

Or configure MySQL/PostgreSQL in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=queuesapp
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run migrations

```bash
php artisan migrate
```

### 7. Create storage link

```bash
php artisan storage:link
```

### 8. Build assets

```bash
npm run build
```

## Running the Application

### Development Mode

For development with hot reload and queue processing:

```bash
composer run dev
```

This command runs:
- Laravel development server
- Queue worker
- Log viewer (Pail)
- Vite dev server

### Production Mode

1. **Start the server:**
```bash
php artisan serve
```

2. **Start the queue worker** (in a separate terminal):
```bash
php artisan queue:work
```

3. **Build assets:**
```bash
npm run build
```

## Usage

### 1. Register/Login

- Visit `/register` to create a new account
- Or visit `/login` to sign in with existing credentials

### 2. Upload Images

- Navigate to `/dashboard`
- Click "Choose Image" and select an image file
- Click "Upload Image"
- The image will be queued for processing

### 3. View Status

- Images appear in the gallery with real-time status updates
- Status badges show: **Pending** => **Processing** => **Done**
- Status updates automatically every 2 seconds

### 4. Image Variants

Once processing is complete, the system generates:
- **Thumbnail**: 150px width
- **Medium**: 600px width
- **Large**: 1200px width

## Project Structure

```
queuesApp/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   └── RegisterController.php
│   │   └── DashboardController.php
│   ├── Jobs/
│   │   └── ProcessImage.php      # Image processing job
│   └── Models/
│       ├── Image.php
│       └── User.php
├── database/
│   └── migrations/
│       └── 2025_12_07_052430_create_images_table.php
├── resources/
│   └── views/
│       ├── assets/
│       │   ├── upload.blade.php
│       │   └── preview.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       └── dashboard.blade.php
└── routes/
    └── web.php
```

## API Endpoints

### Authentication
- `GET /login` - Show login form
- `POST /login` - Authenticate user
- `GET /register` - Show registration form
- `POST /register` - Create new user
- `POST /logout` - Logout user

### Dashboard
- `GET /dashboard` - User dashboard
- `POST /dashboard/upload` - Upload image
- `POST /dashboard/image-status` - Get image status (JSON API)

## Queue Configuration

The application uses Laravel's queue system for background image processing. Configure your queue driver in `.env`:

```env
QUEUE_CONNECTION=database
```

For production, consider using Redis:
```env
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## Image Processing

Images are processed asynchronously using the `ProcessImage` job:

1. Image uploaded → Status: `pending`
2. Job dispatched to queue
3. Job processes → Status: `processing`
4. Variants generated → Status: `done`
5. If error occurs → Status: `failed`

## Real-time Updates

The application uses JavaScript polling to update image status in real-time:
- Polls every 2 seconds
- Only checks images with `pending` or `processing` status
- Automatically stops polling for `done` or `failed` images

## Troubleshooting

### Images not displaying

1. Ensure storage link exists:
```bash
php artisan storage:link
```

2. Check file permissions:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Queue not processing

1. Start the queue worker:
```bash
php artisan queue:work
```

2. Check queue configuration in `.env`

### Vite manifest error

Build the assets:
```bash
npm run build
```

Or run dev server:
```bash
npm run dev
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues and questions, please open an issue on the repository.
