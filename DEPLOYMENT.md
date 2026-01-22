# 🚀 KonterCMS - Panduan Deployment ke VPS

## 📋 Persyaratan Sistem

### Server Requirements
- **PHP**: 8.2 atau lebih tinggi
- **Database**: MySQL 8.0+ atau MariaDB 10.3+
- **Web Server**: Apache 2.4+ atau Nginx 1.18+
- **Node.js**: 18+ (untuk build assets)
- **Composer**: 2.0+

### PHP Extensions
```bash
php-cli php-fpm php-mysql php-zip php-gd php-mbstring php-curl php-xml php-bcmath php-json php-tokenizer
```

## 🛠️ Langkah-langkah Deployment

### 1. Persiapan Server

```bash
# Update sistem
sudo apt update && sudo apt upgrade -y

# Install PHP dan extensions
sudo apt install php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml php8.2-bcmath php8.2-tokenizer -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

### 2. Upload dan Setup Aplikasi

```bash
# Clone atau upload project ke server
cd /var/www/html
sudo git clone <repository-url> kontercms
cd kontercms

# Set permissions
sudo chown -R www-data:www-data /var/www/html/kontercms
sudo chmod -R 755 /var/www/html/kontercms
sudo chmod -R 775 /var/www/html/kontercms/storage
sudo chmod -R 775 /var/www/html/kontercms/bootstrap/cache

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build
```

### 3. Konfigurasi Environment

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Edit file `.env`:
```env
APP_NAME="KonterCMS"
APP_ENV=production
APP_KEY=base64:xxxxx
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kontercms
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Setup Database dan Seeding

```bash
# Buat database MySQL
mysql -u root -p
CREATE DATABASE kontercms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'kontercms_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON kontercms.* TO 'kontercms_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Jalankan setup production (OTOMATIS)
php artisan kontercms:setup-production
```

**ATAU setup manual:**
```bash
# Migrasi database
php artisan migrate --force

# Seeding data production
php artisan db:seed --class=ProductionSeeder --force

# Optimasi aplikasi
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

### 5. Konfigurasi Web Server

#### Apache Virtual Host
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/html/kontercms/public
    
    <Directory /var/www/html/kontercms/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/kontercms_error.log
    CustomLog ${APACHE_LOG_DIR}/kontercms_access.log combined
</VirtualHost>
```

#### Nginx Configuration
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/html/kontercms/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

### 6. SSL Certificate (Opsional tapi Direkomendasikan)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-apache -y

# Generate SSL certificate
sudo certbot --apache -d yourdomain.com
```

## 🔐 Kredensial Default

Setelah menjalankan `php artisan kontercms:setup-production`, sistem akan menampilkan:

```
📋 KREDENSIAL LOGIN:
   Email: admin@kontercms.com
   Password: [Generated Secure Password]
```

**⚠️ PENTING:**
1. **SIMPAN** password di tempat yang aman
2. **GANTI** password setelah login pertama kali
3. **HAPUS** log yang berisi password

## 📁 Struktur File Penting

```
kontercms/
├── .env                    # Konfigurasi environment
├── public/                 # Document root web server
├── storage/                # File storage (harus writable)
├── bootstrap/cache/        # Cache bootstrap (harus writable)
└── database/
    └── seeders/
        ├── DatabaseSeeder.php      # Seeder development
        └── ProductionSeeder.php    # Seeder production
```

## 🔧 Maintenance Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Update aplikasi
git pull origin main
composer install --optimize-autoloader --no-dev
npm run build
php artisan migrate --force
php artisan config:cache
```

## 🛡️ Security Checklist

- [ ] Set `APP_DEBUG=false` di production
- [ ] Gunakan HTTPS dengan SSL certificate
- [ ] Set permission file yang benar (755/775)
- [ ] Backup database secara berkala
- [ ] Update sistem dan dependencies secara rutin
- [ ] Monitor log error secara berkala
- [ ] Gunakan firewall untuk membatasi akses

## 📞 Support

Jika mengalami masalah saat deployment:

1. Cek log error: `tail -f storage/logs/laravel.log`
2. Cek log web server: `/var/log/apache2/` atau `/var/log/nginx/`
3. Pastikan semua requirements terpenuhi
4. Pastikan permissions file sudah benar

## 🎯 Fitur Utama KonterCMS

- ✅ **Manajemen Konten**: Posts, Pages, Categories, Tags
- ✅ **User Management**: Roles & Permissions
- ✅ **File Manager**: Upload dan kelola media
- ✅ **SEO Optimized**: Meta tags, sitemap
- ✅ **Responsive Design**: Mobile-friendly admin panel
- ✅ **Security**: Role-based access control
- ✅ **API Ready**: RESTful API endpoints

---

**Happy Deploying! 🚀**