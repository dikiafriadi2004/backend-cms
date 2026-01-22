# Panduan Instalasi KonterCMS

## Persiapan Server

### Requirements Minimum
- PHP 8.2+
- MySQL 5.7+ atau MariaDB 10.3+
- Composer 2.0+
- Node.js 16+ & NPM
- Web Server (Apache/Nginx)

### Extensions PHP yang Diperlukan
```
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- GD PHP Extension
- Imagick PHP Extension (optional)
```

## Langkah Instalasi

### 1. Download & Extract
```bash
# Clone repository
git clone <repository-url> kontercms
cd kontercms

# Atau download ZIP dan extract
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node.js dependencies
npm install --production
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
Edit file `.env` dengan konfigurasi database Anda:
```env
APP_NAME=KonterCMS
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kontercms
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Migration
```bash
# Run migrations
php artisan migrate --force

# Seed initial data
php artisan db:seed --force
```

### 6. Storage & Permissions
```bash
# Create storage link
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### 7. Build Assets
```bash
# Build production assets
npm run build
```

### 8. Cache Optimization
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

## Konfigurasi Web Server

### Apache (.htaccess)
File `.htaccess` sudah disediakan di folder `public/`. Pastikan mod_rewrite aktif.

### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/kontercms/public;

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

## Konfigurasi SSL (HTTPS)

### Menggunakan Let's Encrypt
```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Generate SSL certificate
sudo certbot --nginx -d yourdomain.com

# Auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

## Konfigurasi Email

Edit `.env` untuk konfigurasi email:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Konfigurasi File Manager

### Storage Disk
Pastikan konfigurasi storage di `config/filesystems.php`:
```php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
],
```

### File Manager Config
Edit `config/lfm.php` sesuai kebutuhan:
```php
'use_package_routes' => true,
'middlewares' => ['web', 'auth'],
'allow_multi_user' => true,
'allow_share_folder' => false,
```

## Backup & Maintenance

### Database Backup
```bash
# Manual backup
mysqldump -u username -p kontercms > backup_$(date +%Y%m%d).sql

# Automated backup (crontab)
0 2 * * * mysqldump -u username -p kontercms > /backups/kontercms_$(date +\%Y\%m\%d).sql
```

### File Backup
```bash
# Backup files
tar -czf kontercms_files_$(date +%Y%m%d).tar.gz /path/to/kontercms

# Backup storage only
tar -czf kontercms_storage_$(date +%Y%m%d).tar.gz /path/to/kontercms/storage
```

### Maintenance Mode
```bash
# Enable maintenance mode
php artisan down --message="System maintenance in progress"

# Disable maintenance mode
php artisan up
```

## Troubleshooting

### Common Issues

1. **Permission Denied**
   ```bash
   sudo chown -R www-data:www-data /path/to/kontercms
   sudo chmod -R 755 /path/to/kontercms
   ```

2. **Storage Link Error**
   ```bash
   rm public/storage
   php artisan storage:link
   ```

3. **Cache Issues**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   php artisan route:clear
   ```

4. **Database Connection Error**
   - Check database credentials in `.env`
   - Ensure MySQL service is running
   - Verify database exists

5. **File Upload Issues**
   - Check `upload_max_filesize` in php.ini
   - Check `post_max_size` in php.ini
   - Verify storage permissions

### Log Files
- Application logs: `storage/logs/laravel.log`
- Web server logs: `/var/log/nginx/error.log` atau `/var/log/apache2/error.log`

## Performance Optimization

### OPcache Configuration
Add to php.ini:
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

### Database Optimization
```sql
-- Add indexes for better performance
ALTER TABLE posts ADD INDEX idx_status_published (status, published_at);
ALTER TABLE posts ADD INDEX idx_featured (featured);
ALTER TABLE categories ADD INDEX idx_slug (slug);
ALTER TABLE tags ADD INDEX idx_slug (slug);
```

### Caching
```bash
# Enable all caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

## Security Checklist

- [ ] Update `.env` dengan kredensial yang kuat
- [ ] Set `APP_DEBUG=false` di production
- [ ] Konfigurasi HTTPS/SSL
- [ ] Set proper file permissions
- [ ] Enable firewall
- [ ] Regular security updates
- [ ] Backup database dan files
- [ ] Monitor error logs

## Support

Jika mengalami masalah instalasi:
1. Check log files
2. Verify requirements
3. Check documentation
4. Contact support: admin@kontercms.com