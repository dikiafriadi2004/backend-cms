# KonterCMS - Laravel 12 Content Management System (Backend API)

KonterCMS adalah sistem manajemen konten yang powerful dan lengkap yang dibangun dengan Laravel 12. CMS ini dirancang khusus sebagai **backend API** untuk digunakan dengan frontend Next.js atau framework frontend lainnya. Tidak ada frontend views untuk blog/pages karena semua konten diakses melalui API endpoints.

## 🚀 Fitur Utama

### 1. Dashboard Analytics
- Dashboard dengan statistik lengkap
- Integrasi Google Analytics (siap pakai)
- Overview posts, pages, users, dan categories
- Recent activity tracking

### 2. Posts Management
- **SEO Optimized**: Meta title, description, keywords
- **Rich Text Editor**: TinyMCE dengan file manager integration
- **Media Management**: Thumbnail upload dengan multiple sizes
- **Categories & Tags**: Sistem kategorisasi yang fleksibel
- **Status Management**: Draft, Published, Scheduled
- **Featured Posts**: Highlight posts penting
- **Auto Slug Generation**: SEO-friendly URLs
- **Pagination**: 10 posts per halaman dengan filter dan search

### 3. Pages Management
- **Multiple Templates**: Contact, Privacy, About, Blog, Default
- **SEO Ready**: Complete meta tags support
- **Custom Content**: Rich text editor dengan media support
- **Status Control**: Draft/Published workflow
- **Pagination**: 10 pages per halaman

### 4. Menu Builder
- **Drag & Drop Interface**: Sortable menu items
- **Multiple Menu Locations**: Header, Footer, Custom
- **Nested Menus**: Multi-level menu support
- **Page Integration**: Auto-link ke pages
- **Custom Links**: External dan internal links
- **CSS Classes**: Custom styling support

### 5. User Management
- **Role-Based Access**: Granular permission system
- **User Profiles**: Avatar, bio, status management
- **Activity Tracking**: User actions monitoring
- **Pagination**: 10 users per halaman

### 6. Roles & Permissions
- **Pre-defined Roles**: Super Admin, Admin, Editor, Author
- **Granular Permissions**: 40+ specific permissions
- **Permission Groups**: Organized by functionality
- **Dynamic Assignment**: Flexible role management

### 7. Advertising System
- **Google AdSense**: Ready integration
- **Manual Ads**: Custom HTML/JS ads
- **Adsera Support**: Indonesian ad network
- **Position Management**: Header, Sidebar, Content, Footer
- **Status Control**: Enable/disable ads easily
- **Pagination**: 10 ads per halaman

### 8. Global Settings
- **Site Information**: Name, description, logo, favicon
- **Contact Details**: Email, phone, address
- **SEO Settings**: Meta tags, robots.txt, site verification
- **Social Media**: All major platforms integration
- **Analytics**: Google Analytics, Tag Manager, Facebook Pixel
- **Company Profile**: Complete company information, vision, mission
- **Call to Action**: Customizable CTA sections with WhatsApp integration
- **Settings Seeder**: 39 pre-configured settings ready to use

### 9. File Manager
- **TinyMCE Integration**: Seamless editor integration
- **Multiple Upload**: Batch file uploads
- **Image Optimization**: Auto-resize dan compression
- **Folder Management**: Organized file structure
- **Media Library**: Centralized asset management

### 10. RESTful API
- **Complete API Endpoints**: All data accessible via API
- **JSON Responses**: Structured data format
- **Pagination Support**: Efficient data loading
- **Search & Filter**: Advanced query capabilities
- **CORS Ready**: Frontend integration ready

## 🔒 Fitur Keamanan

### 1. Route Security
- **Homepage Redirect**: Otomatis redirect ke login untuk mencegah akses tidak sah
- **Fallback Route**: Semua route tidak terdefinisi redirect ke login
- **No Test Routes**: Tidak ada route testing yang bisa dieksploitasi

### 2. Security Headers
- **X-Content-Type-Options**: nosniff
- **X-Frame-Options**: DENY (mencegah clickjacking)
- **X-XSS-Protection**: 1; mode=block
- **Referrer-Policy**: strict-origin-when-cross-origin
- **Permissions-Policy**: Membatasi akses geolocation, microphone, camera
- **Server Header**: Dihapus untuk menyembunyikan informasi server

### 3. File Protection
- **Sensitive Files**: .env, .log, .htaccess, .ini, dll diblokir
- **Directory Protection**: storage/, vendor/, node_modules/, tests/, database/ diblokir
- **Security Files**: .htpasswd, *.key, *.pem, *.crt tidak masuk repository

### 4. Rate Limiting
- **API Throttling**: Pembatasan request API untuk mencegah abuse
- **Authentication**: Semua admin route memerlukan autentikasi
- **Permission System**: Role-based access control

## 🎯 Backend Only - No Frontend Views

**PENTING**: CMS ini adalah **backend API only**. Tidak ada route atau view untuk blog/pages frontend karena:
- Frontend menggunakan Next.js atau framework lainnya
- Semua konten diakses melalui API endpoints
- Admin panel hanya untuk manajemen konten
- Homepage menampilkan informasi API endpoints

## 🛠️ Teknologi Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Database**: MySQL
- **Frontend**: TailwindCSS 4.0, Alpine.js
- **Editor**: TinyMCE 6
- **File Management**: Laravel File Manager
- **Authentication**: Laravel Breeze
- **Permissions**: Spatie Laravel Permission
- **Media**: Spatie Media Library
- **Image Processing**: Intervention Image

## 📋 Requirements

- PHP 8.2 atau lebih tinggi
- MySQL 5.7+ atau MariaDB 10.3+
- Composer
- Node.js & NPM
- Web Server (Apache/Nginx)

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd backend-cms
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kontercms
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Database Migration & Seeding
```bash
php artisan migrate
php artisan db:seed
```

**Settings Seeder**: Database seeding akan mengisi 39 pengaturan default termasuk:
- General Settings (7 items): Site name, description, logo, favicon, contact info
- SEO Settings (5 items): Meta tags, robots.txt, site verification
- Social Media (5 items): Facebook, Twitter, Instagram, LinkedIn, YouTube
- Analytics (3 items): Google Analytics, Tag Manager, Facebook Pixel
- Company Profile & CTA (19 items): Company info, vision, mission, call-to-action

Untuk menjalankan hanya settings seeder:
```bash
php artisan db:seed --class=SettingSeeder
```

### 6. Storage Link
```bash
php artisan storage:link
```

### 7. Build Assets
```bash
npm run build
```

**Note**: Jika terjadi error "Vite manifest not found", jalankan `npm run build` untuk generate file manifest yang diperlukan.

### 8. Start Server
```bash
php artisan serve
```

**Keamanan**: Homepage otomatis redirect ke login. Akses `http://localhost:8000/` akan langsung diarahkan ke halaman login untuk keamanan.

## 👤 Default Login

Setelah seeding, gunakan kredensial berikut:
- **Email**: admin@kontercms.com
- **Password**: password

## 🔗 API Endpoints

### Posts
- `GET /api/v1/posts` - List all posts
- `GET /api/v1/posts/featured` - Featured posts
- `GET /api/v1/posts/{slug}` - Single post
- `GET /api/v1/categories` - All categories
- `GET /api/v1/tags` - All tags

### Pages
- `GET /api/v1/pages` - List all pages
- `GET /api/v1/pages/{slug}` - Single page

### Menus
- `GET /api/v1/menus/{location}` - Menu by location

### Settings
- `GET /api/v1/settings` - All settings
- `GET /api/v1/settings/{group}` - Settings by group

### Ads
- `GET /api/v1/ads/{position}` - Ads by position

## 🎨 Customization

### Templates
Templates untuk pages tersedia di:
- `resources/views/pages/contact.blade.php`
- `resources/views/pages/privacy.blade.php`
- `resources/views/pages/about.blade.php`
- `resources/views/pages/blog.blade.php`

### Styling
Customize TailwindCSS di:
- `tailwind.config.js`
- `resources/css/app.css`

### Permissions
Tambah permission baru di:
- `database/seeders/PermissionSeeder.php`

## 🔧 Configuration

### File Manager
Konfigurasi file manager di `config/lfm.php`

### Media Library
Konfigurasi media di `config/media-library.php`

### Permissions
Konfigurasi permissions di `config/permission.php`

## 📱 Responsive Design

CMS ini fully responsive dengan:
- Mobile-first approach
- Tablet optimization
- Desktop enhancement
- Touch-friendly interface

## 🔒 Security Features

- CSRF Protection
- XSS Prevention
- SQL Injection Protection
- Role-based Access Control
- File Upload Validation
- Secure Authentication

## 🚀 Performance

- Optimized Database Queries
- Image Compression
- Asset Minification
- Caching Support
- Lazy Loading
- CDN Ready

## 📞 Support

Untuk support dan pertanyaan:
- Email: admin@kontercms.com
- Documentation: [Link to docs]
- Issues: [GitHub Issues]

## 📄 License

This project is licensed under the MIT License.

## 🤝 Contributing

Contributions are welcome! Please read our contributing guidelines.

---

**KonterCMS** - Powerful, Modern, & SEO-Ready Content Management System