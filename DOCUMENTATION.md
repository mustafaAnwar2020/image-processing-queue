# Documentation

## Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [Authentication System](#authentication-system)
3. [Image Upload & Processing](#image-upload--processing)
4. [Queue System](#queue-system)
5. [Real-time Status Updates](#real-time-status-updates)
6. [Database Schema](#database-schema)
7. [API Reference](#api-reference)
8. [Frontend Architecture](#frontend-architecture)
9. [Configuration](#configuration)
10. [Deployment](#deployment)

---

## Architecture Overview

The application follows the MVC (Model-View-Controller) pattern with Laravel's queue system for asynchronous processing.

### Key Components

- **Controllers**: Handle HTTP requests and responses
- **Models**: Eloquent models for database interactions
- **Jobs**: Background processing tasks
- **Views**: Blade templates for UI rendering
- **Routes**: Define application endpoints

### Request Flow

1. User uploads image → `DashboardController@uploadImage`
2. Image saved to storage → `Image` model created
3. Job dispatched → `ProcessImage` job queued
4. Queue worker processes → Image variants generated
5. Status updated → Real-time UI update via polling

---

## Authentication System

### Controllers

#### `LoginController`
- `showLoginForm()` - Display login page
- `login()` - Authenticate user credentials
- `logout()` - End user session

#### `RegisterController`
- `showRegistrationForm()` - Display registration page
- `register()` - Create new user account

### Routes

All authentication routes are protected by the `guest` middleware, ensuring only non-authenticated users can access them.

### User Model

The `User` model extends Laravel's `Authenticatable` class with:
- `name` - User's full name
- `email` - Unique email address
- `password` - Hashed password

---

## Image Upload & Processing

### Upload Flow

1. **Validation**: File type, size, and format validation
2. **Storage**: File saved to `storage/app/public/images/`
3. **Database**: `Image` record created with status `pending`
4. **Queue**: `ProcessImage` job dispatched

### Image Model

```php
protected $fillable = [
    'user_id',
    'original_path',
    'variants',
    'status',
    'error'
];
```

**Status Values:**
- `pending` - Image uploaded, waiting for processing
- `processing` - Currently being processed
- `done` - Processing complete
- `failed` - Processing failed

**Variants Structure:**
```json
{
    "thumb": "images/thumb_filename.jpg",
    "medium": "images/medium_filename.jpg",
    "large": "images/large_filename.jpg"
}
```

### ProcessImage Job

The `ProcessImage` job handles image resizing:

1. Reads original image from storage
2. Generates three variants:
   - **Thumbnail**: 150px width
   - **Medium**: 600px width
   - **Large**: 1200px width
3. Saves variants to storage
4. Updates image status and variants in database

**Error Handling:**
- Catches exceptions during processing
- Updates status to `failed`
- Stores error message in database

---

## Queue System

### Configuration

The application uses Laravel's database queue driver by default. Configure in `.env`:

```env
QUEUE_CONNECTION=database
```

### Queue Worker

Start the queue worker to process jobs:

```bash
php artisan queue:work
```

**Options:**
- `--tries=3` - Maximum retry attempts
- `--timeout=60` - Job timeout in seconds
- `--queue=default` - Process specific queue

### Job Retry Logic

The `ProcessImage` job has:
- `$tries = 3` - Will retry up to 3 times on failure
- Automatic retry with exponential backoff

---

## Real-time Status Updates

### Implementation

The application uses JavaScript polling to update image status:

1. **Polling Interval**: Every 2 seconds
2. **API Endpoint**: `POST /dashboard/image-status`
3. **Request**: Sends array of image IDs
4. **Response**: Returns current status for each image

### JavaScript Flow

```javascript
1. Collect all image IDs with pending/processing status
2. Send POST request to status endpoint
3. Update DOM elements with new status
4. Stop polling for done/failed images
```

### Status Badge Updates

Status badges automatically update with:
- Color changes (yellow → blue → green)
- Text updates (Pending → Processing → Done)
- CSS class changes for styling

---

## Database Schema

### Users Table

```sql
id              BIGINT PRIMARY KEY
name            VARCHAR(255)
email           VARCHAR(255) UNIQUE
password        VARCHAR(255)
remember_token  VARCHAR(100)
email_verified_at TIMESTAMP
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### Images Table

```sql
id              BIGINT PRIMARY KEY
user_id         BIGINT FOREIGN KEY
original_path   VARCHAR(255)
variants        JSON
status          ENUM('pending', 'processing', 'done', 'failed')
error           TEXT NULLABLE
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### Jobs Table

Laravel's queue jobs table (auto-created):

```sql
id              BIGINT PRIMARY KEY
queue           VARCHAR(255)
payload         LONGTEXT
attempts        TINYINT
reserved_at     INTEGER NULLABLE
available_at    INTEGER
created_at      INTEGER
```

---

## API Reference

### POST /dashboard/image-status

Get status for multiple images.

**Request:**
```json
{
    "ids": [1, 2, 3]
}
```

**Response:**
```json
{
    "1": {
        "id": 1,
        "status": "processing",
        "variants": null
    },
    "2": {
        "id": 2,
        "status": "done",
        "variants": {
            "thumb": "images/thumb_abc123.jpg",
            "medium": "images/medium_abc123.jpg",
            "large": "images/large_abc123.jpg"
        }
    }
}
```

**Authentication:** Required (auth middleware)

---

## Frontend Architecture

### Views Structure

```
resources/views/
├── layouts/
│   └── app.blade.php          # Main layout
├── auth/
│   ├── login.blade.php        # Login page
│   └── register.blade.php      # Registration page
├── assets/
│   ├── upload.blade.php       # Upload form component
│   └── preview.blade.php      # Image gallery component
└── dashboard.blade.php        # Dashboard page
```

### Styling

- **Framework**: Tailwind CSS 4
- **Build Tool**: Vite
- **Dark Mode**: Automatic based on system preference

### JavaScript

- **Polling**: Vanilla JavaScript (no framework required)
- **CSRF Protection**: Uses meta tag token
- **Status Updates**: DOM manipulation for real-time changes

---

## Configuration

### Environment Variables

Key configuration in `.env`:

```env
APP_NAME="Image Upload App"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

QUEUE_CONNECTION=database

FILESYSTEM_DISK=local
```

### Storage Configuration

Files are stored in:
- **Public Storage**: `storage/app/public/images/`
- **Symlink**: `public/storage` → `storage/app/public`

### Queue Configuration

Configure queue driver in `config/queue.php` or `.env`:

- `database` - Uses database table (default)
- `redis` - Uses Redis (recommended for production)
- `sync` - Synchronous (for testing)

---

## Deployment

### Production Checklist

1. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

2. **Database Migration**
   ```bash
   php artisan migrate --force
   ```

3. **Storage Link**
   ```bash
   php artisan storage:link
   ```

4. **Asset Building**
   ```bash
   npm run build
   ```

5. **Queue Worker**
   ```bash
   php artisan queue:work --daemon
   ```
   Or use a process manager like Supervisor

6. **Optimization**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### Supervisor Configuration

For production queue workers, use Supervisor:

```ini
[program:queuesapp-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/worker.log
```

### Web Server Configuration

#### Nginx

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### Apache

Ensure `.htaccess` is enabled and `mod_rewrite` is active.

---

## Security Considerations

1. **File Upload Validation**
   - File type validation
   - File size limits (2MB)
   - MIME type checking

2. **Authentication**
   - Password hashing (bcrypt)
   - CSRF protection
   - Session security

3. **Storage**
   - Files stored outside web root
   - Public access via symlink only
   - User-specific file access

4. **Queue Security**
   - Jobs serialized securely
   - Failed job handling
   - Retry limits

---

## Performance Optimization

1. **Image Processing**
   - Queue-based for non-blocking
   - Variant caching
   - Optimized image sizes

2. **Database**
   - Indexed columns (user_id, status)
   - Efficient queries
   - Connection pooling

3. **Frontend**
   - Asset minification
   - Lazy loading images
   - Efficient polling (only active images)

---

## Troubleshooting

### Common Issues

**Issue**: Images not displaying
- **Solution**: Run `php artisan storage:link`

**Issue**: Queue not processing
- **Solution**: Start queue worker with `php artisan queue:work`

**Issue**: Status not updating
- **Solution**: Check browser console for JavaScript errors

**Issue**: Permission errors
- **Solution**: Set correct permissions on `storage/` and `bootstrap/cache/`

---

## Future Enhancements

- [ ] Image deletion functionality
- [ ] Image editing capabilities
- [ ] Batch upload support
- [ ] WebSocket for real-time updates (instead of polling)
- [ ] Image compression optimization
- [ ] User profile management
- [ ] Image sharing features
- [ ] Admin dashboard

---

## Support

For issues, questions, or contributions, please refer to the main README.md file.

