# Clone Project Review - Deployment Guide

## Overview
This is a comprehensive web-based project management system built with Laravel 11 that handles work orders, commissions, document management, and notifications across multiple user roles (Admin, PM, Staff, HOD).

## Key Features
- ✅ Multi-role user management (Admin, PM, Staff, HOD)
- ✅ Project/work order management
- ✅ Commission tracking and approval system
- ✅ Real-time notification system (especially HOD notifications for commission submissions)
- ✅ Document management
- ✅ Role-based access control
- ✅ Database synchronization with live data

## User Accounts (Default)
- **Admin**: admin@example.com / password
- **PM**: pm@example.com / password
- **Staff**: staff@example.com / password
- **HOD**: hod@example.com / password

## Server Requirements
- PHP 8.2 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js 16+ (for asset compilation)
- Web server (Apache/Nginx)

## Deployment Options

### Option 1: VPS/Cloud Server Deployment

#### 1. Prepare Server
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.2 and extensions
sudo apt install php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-bcmath php8.2-gd -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Install MySQL
sudo apt install mysql-server -y
sudo mysql_secure_installation
```

#### 2. Setup Database
```bash
# Login to MySQL
sudo mysql -u root -p

# Create database and user
CREATE DATABASE project_management;
CREATE USER 'project_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON project_management.* TO 'project_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### 3. Deploy Application
```bash
# Clone repository
git clone https://github.com/Suuoss-art/Clone-Project-Review.git
cd Clone-Project-Review

# Install dependencies
composer install --optimize-autoloader --no-dev

# Setup environment
cp .env.example .env
nano .env  # Edit with your database credentials

# Generate application key
php artisan key:generate

# Set permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed

# Compile assets
npm install
npm run build

# Setup supervisor for queue worker
sudo nano /etc/supervisor/conf.d/project-worker.conf
```

#### 4. Supervisor Configuration
```ini
[program:project-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
```

#### 5. Web Server Configuration

**Apache Virtual Host:**
```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /path/to/your/project/public
    
    <Directory /path/to/your/project/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/project_error.log
    CustomLog ${APACHE_LOG_DIR}/project_access.log combined
</VirtualHost>
```

**Nginx Configuration:**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/your/project/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### Option 2: XAMPP Deployment (Development/Local)

#### 1. Install XAMPP
- Download XAMPP from https://www.apachefriends.org/
- Install with Apache, MySQL, and PHP

#### 2. Setup Project
```bash
# Navigate to htdocs
cd C:\xampp\htdocs  # Windows
cd /opt/lampp/htdocs  # Linux

# Clone project
git clone https://github.com/Suuoss-art/Clone-Project-Review.git
cd Clone-Project-Review

# Install dependencies
composer install

# Setup environment
copy .env.example .env  # Windows
cp .env.example .env    # Linux
```

#### 3. Configure Environment (.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_management
DB_USERNAME=root
DB_PASSWORD=
```

#### 4. Setup Database
- Open http://localhost/phpmyadmin
- Create database `project_management`
- Run: `php artisan migrate --seed`

### Option 3: Replit Deployment

#### 1. Import to Replit
- Go to https://replit.com
- Import from GitHub: https://github.com/Suuoss-art/Clone-Project-Review
- Choose PHP template

#### 2. Configure Environment
```bash
# Install dependencies
composer install

# Setup environment
cp .env.example .env

# Generate key
php artisan key:generate

# Use SQLite for simplicity
DB_CONNECTION=sqlite

# Run migrations
php artisan migrate --seed
```

#### 3. Run Application
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

## Post-Deployment Setup

### 1. Test All User Roles
```bash
# Test login for each role
# Admin: admin@example.com / password
# PM: pm@example.com / password  
# Staff: staff@example.com / password
# HOD: hod@example.com / password
```

### 2. Start Queue Worker (Production)
```bash
# For background processing of notifications
php artisan queue:work --daemon

# Or use supervisor (recommended)
sudo supervisorctl start project-worker:*
```

### 3. Test Notification System
1. Login as PM
2. Create/edit commission for a project
3. Check HOD account for notifications
4. Verify real-time updates work

### 4. Configure Cron Jobs (Production)
```bash
# Add to crontab
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

## Key Features Testing Checklist

### Authentication & Authorization
- [ ] All user roles can login successfully
- [ ] Role-based dashboard access works
- [ ] Unauthorized access is properly blocked
- [ ] Logout functionality works

### Project Management
- [ ] Create, view, edit projects
- [ ] Assign personnel to projects
- [ ] Track project status
- [ ] Document upload/management

### Commission System
- [ ] PM can input commission data
- [ ] Commission calculations are accurate
- [ ] HOD receives notifications when PM submits commissions
- [ ] Commission approval workflow works
- [ ] History tracking is functional

### Notification System
- [ ] HOD receives real-time notifications
- [ ] Notification marking as read works
- [ ] Notification data is accurate
- [ ] Email notifications work (if configured)

### Database Synchronization
- [ ] All data updates in real-time
- [ ] No placeholder/dummy data
- [ ] Relationships between tables work correctly
- [ ] Data integrity is maintained

## Troubleshooting

### Common Issues

1. **Permission Errors**
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

2. **Database Connection Issues**
- Check database credentials in .env
- Ensure database service is running
- Verify database user permissions

3. **Queue Jobs Not Processing**
```bash
php artisan queue:restart
php artisan queue:work
```

4. **Assets Not Loading**
```bash
npm install
npm run build
php artisan storage:link
```

5. **Route Errors**
```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

## Security Considerations

1. **Environment File**
   - Never commit .env to version control
   - Use strong database passwords
   - Set APP_DEBUG=false in production

2. **File Permissions**
   - Restrict access to sensitive directories
   - Use proper web server user

3. **Database Security**
   - Use dedicated database user with minimal privileges
   - Regular backups
   - Enable MySQL/MariaDB security features

## Support

For issues or questions:
1. Check the troubleshooting section
2. Review Laravel documentation
3. Check application logs in `storage/logs/`
4. Contact system administrator

## System Requirements Summary

- **Minimum RAM**: 512MB (2GB recommended)
- **Storage**: 1GB minimum
- **PHP Version**: 8.2+
- **Database**: MySQL 5.7+ or SQLite 3.8+
- **Web Server**: Apache 2.4+ or Nginx 1.15+

The application is now fully functional with all role-based features, real-time notifications, and proper database synchronization!