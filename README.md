# 🚀 **Laravel CMS with Next.js API Integration**

A modern, professional Content Management System built with Laravel, featuring a complete RESTful API for Next.js integration and an advanced advertisement management system.

## ✨ **Features**

### **🎯 Core Features**
- **Modern Admin Panel** with ultra-professional design
- **Complete RESTful API** for Next.js integration
- **Advanced Ad Management** with 4 ad types support
- **Content Management** for posts, pages, categories, and tags
- **User Management** with authentication and roles
- **File Management** with media uploads
- **SEO Optimization** with meta tags and sitemaps
- **Email System** with contact forms and notifications
- **Responsive Design** optimized for all devices

### **📊 Advertisement System**
- **Manual Banner Ads** with image uploads
- **Manual Text Link Ads** with custom styling
- **Google AdSense Integration** with code injection
- **Adsera Integration** for local advertising
- **11 Ad Positions** strategically placed
- **Analytics Tracking** with views and clicks
- **Scheduling System** with start/end dates
- **Professional Admin Interface** with modern design

### **🔌 API Integration**
- **Complete REST API** with 25+ endpoints
- **Next.js Ready** with TypeScript support
- **Real-time Analytics** tracking
- **CORS Enabled** for cross-origin requests
- **Rate Limiting** for security
- **Error Handling** with proper HTTP status codes

## 📋 **Quick Start**

### **System Requirements**
- PHP 8.1+
- Composer 2.0+
- Node.js 16+
- MySQL 8.0+
- 2GB RAM (recommended)

### **Installation**
```bash
# Clone repository
git clone https://github.com/yourusername/laravel-cms.git
cd laravel-cms

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env file
# DB_DATABASE=laravel_cms
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# Run migrations and seed data
php artisan migrate --seed

# Create storage link and compile assets
php artisan storage:link
npm run build

# Start development server
php artisan serve
```

### **Default Admin Access**
- **URL**: http://localhost:8000/admin
- **Email**: admin@example.com
- **Password**: password

### **API Base URL**
- **Development**: http://localhost:8000/api/v1
- **Production**: https://yourdomain.com/api/v1

## 🚀 **Production Deployment**

### **VPS Requirements**
- Ubuntu 20.04+ or CentOS 8+
- 2GB RAM minimum (4GB recommended)
- 20GB SSD storage
- PHP 8.1+, MySQL 8.0+, Nginx

### **Quick Deploy**
```bash
# On your VPS
sudo apt update && sudo apt upgrade -y

# Install LEMP stack
sudo apt install nginx mysql-server php8.2-fpm php8.2-mysql php8.2-xml php8.2-curl php8.2-zip php8.2-mbstring php8.2-gd -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Clone and setup project
cd /var/www
sudo git clone https://github.com/yourusername/laravel-cms.git
sudo chown -R www-data:www-data laravel-cms
cd laravel-cms

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Setup environment
cp .env.example .env
# Edit .env with production settings
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache

# Configure Nginx
sudo nano /etc/nginx/sites-available/laravel-cms
# Add Nginx configuration (see below)
sudo ln -s /etc/nginx/sites-available/laravel-cms /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx

# Setup SSL with Let's Encrypt
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d yourdomain.com
```

### **Nginx Configuration**
```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/laravel-cms/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

## 📚 **Documentation**

All comprehensive documentation has been consolidated into this README file for easier maintenance and reduced project size. This includes:

- **Installation Instructions** - Complete local setup guide
- **API Documentation** - Full API reference for Next.js integration  
- **VPS Deployment Guide** - Production deployment instructions
- **Usage Examples** - Implementation examples and best practices

For detailed documentation, please refer to the sections below in this README.

## 🎯 **API Endpoints**

### **🎪 Ads API**
```http
GET    /api/v1/ads                    # Get all ads
GET    /api/v1/ads/position/{pos}     # Get ads by position
POST   /api/v1/ads/{id}/click         # Track ad click
GET    /api/v1/ads/{id}/analytics     # Get ad analytics
GET    /api/v1/ads/positions          # Get available positions
```

### **📝 Content API**
```http
GET    /api/v1/posts                  # Get all posts
GET    /api/v1/posts/{slug}           # Get single post
GET    /api/v1/posts/featured         # Get featured posts
GET    /api/v1/posts/latest           # Get latest posts
GET    /api/v1/posts/search           # Search posts

GET    /api/v1/pages                  # Get all pages
GET    /api/v1/pages/{slug}           # Get single page
GET    /api/v1/pages/homepage         # Get homepage content

GET    /api/v1/categories             # Get all categories
GET    /api/v1/categories/{slug}      # Get single category
GET    /api/v1/categories/{slug}/posts # Get category posts

GET    /api/v1/tags                   # Get all tags
GET    /api/v1/tags/popular           # Get popular tags
GET    /api/v1/tags/{slug}            # Get single tag
```

### **⚙️ System API**
```http
GET    /api/v1/settings               # Get all settings
GET    /api/v1/settings/general       # Get general settings
GET    /api/v1/settings/seo           # Get SEO settings
GET    /api/v1/menus/navigation       # Get navigation menu
POST   /api/v1/contact                # Submit contact form
```

## 🎨 **Next.js Integration**

### **Quick Implementation**
```tsx
// components/AdBanner.tsx
import { useState, useEffect } from 'react';

export default function AdBanner({ position }: { position: string }) {
  const [ads, setAds] = useState([]);

  useEffect(() => {
    fetch(`/api/v1/ads/position/${position}`)
      .then(res => res.json())
      .then(data => setAds(data.data));
  }, [position]);

  return (
    <div className="ad-container">
      {ads.map(ad => (
        <div key={ad.id} onClick={() => trackClick(ad.id)}>
          {ad.type === 'manual_banner' && (
            <img src={ad.image_url} alt={ad.alt_text} />
          )}
          {ad.type === 'manual_text' && (
            <a href={ad.link_url}>{ad.title}</a>
          )}
          {(ad.type === 'adsense' || ad.type === 'adsera') && (
            <div dangerouslySetInnerHTML={{ __html: ad.code }} />
          )}
        </div>
      ))}
    </div>
  );
}

const trackClick = async (adId: number) => {
  await fetch(`/api/v1/ads/${adId}/click`, { method: 'POST' });
};
```

### **Available Ad Positions**
- `header` - Header area
- `sidebar_top` - Top of sidebar
- `sidebar_middle` - Middle of sidebar
- `sidebar_bottom` - Bottom of sidebar
- `content_top` - Top of content
- `content_middle` - Middle of content
- `content_bottom` - Bottom of content
- `footer` - Footer area
- `between_posts` - Between post listings
- `popup` - Popup/modal ads
- `mobile_banner` - Mobile-specific banners

## 🚀 **Deployment**

### **VPS Deployment**
Follow the complete [VPS Deployment Guide](VPS_DEPLOYMENT_COMPLETE_GUIDE.md) for production setup including:
- Server configuration
- SSL certificate setup
- Performance optimization
- Security hardening
- Monitoring setup

### **Quick Deploy Commands**
```bash
# On your VPS
git clone https://github.com/yourusername/laravel-cms.git
cd laravel-cms
composer install --optimize-autoloader --no-dev
npm install && npm run build
cp .env.example .env
# Configure .env for production
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🛡️ **Security Features**

- **CSRF Protection** on all forms
- **SQL Injection Prevention** with Eloquent ORM
- **XSS Protection** with Blade templating
- **Rate Limiting** on API endpoints
- **Input Validation** with Form Requests
- **File Upload Security** with type validation
- **Authentication** with Laravel Sanctum
- **Password Hashing** with bcrypt

## 📊 **Performance Features**

- **Database Optimization** with proper indexing
- **Query Optimization** with eager loading
- **Caching System** with Redis support
- **Asset Optimization** with Vite
- **Image Optimization** with intervention/image
- **Gzip Compression** enabled
- **CDN Ready** for static assets
- **Database Connection Pooling**

## 🔧 **Development**

### **Project Structure**
```
laravel-cms/
├── app/
│   ├── Http/Controllers/Api/     # API Controllers
│   ├── Http/Controllers/Admin/   # Admin Controllers
│   ├── Models/                   # Eloquent Models
│   └── Mail/                     # Mail Classes
├── database/
│   ├── migrations/               # Database Migrations
│   └── seeders/                  # Database Seeders
├── resources/
│   ├── views/admin/              # Admin Panel Views
│   ├── js/                       # JavaScript Assets
│   └── css/                      # CSS Assets
├── routes/
│   ├── api.php                   # API Routes
│   └── web.php                   # Web Routes
└── public/                       # Public Assets
```

### **Key Models**
- `User` - User management
- `Post` - Blog posts
- `Page` - Static pages
- `Category` - Post categories
- `Tag` - Post tags
- `AdSpace` - Advertisement management
- `Menu` - Navigation menus
- `Setting` - System settings

### **Artisan Commands**
```bash
# Development
php artisan serve                 # Start dev server
php artisan migrate:fresh --seed  # Reset database
php artisan optimize:clear        # Clear all caches

# Production
php artisan config:cache          # Cache configuration
php artisan route:cache           # Cache routes
php artisan view:cache            # Cache views
php artisan queue:work            # Start queue worker
```

## 🤝 **Contributing**

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 **License**

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 **Support**

### **Documentation**
- All documentation is consolidated in this README
- Laravel Framework Documentation: https://laravel.com/docs
- API endpoints documented in this file
- Installation and deployment guides included below

### **Getting Help**
- Create an issue on GitHub
- Check Laravel documentation
- Review the API section in this README
- Follow the installation guide below

## 🎉 **Acknowledgments**

- **Laravel Framework** - The PHP framework for web artisans
- **Tailwind CSS** - A utility-first CSS framework
- **Alpine.js** - A rugged, minimal framework for composing JavaScript behavior
- **Chart.js** - Simple yet flexible JavaScript charting
- **TinyMCE** - The world's most advanced rich text editor

---

## 📈 **Project Status**

- ✅ **Core CMS**: Complete and stable
- ✅ **API Integration**: Fully functional
- ✅ **Admin Panel**: Modern and professional
- ✅ **Ad Management**: Advanced features implemented
- ✅ **Documentation**: Comprehensive guides available
- ✅ **Production Ready**: Deployment guides provided

**Version**: 1.0.0  
**Last Updated**: January 2026  
**Status**: Production Ready 🚀

---

**Made with ❤️ for modern web development**