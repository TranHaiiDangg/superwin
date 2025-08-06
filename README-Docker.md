# Hướng dẫn Docker cho SuperWin Laravel

## Tổng quan

Dự án SuperWin sử dụng Docker để containerize ứng dụng Laravel với các services:
- **Laravel App**: PHP 8.2 + Nginx
- **MySQL**: Database chính
- **Redis**: Cache và session storage
- **phpMyAdmin**: Quản lý database
- **Node.js**: Development server (optional)

## Cấu trúc Docker

```
superwin/
├── Dockerfile                 # Docker image cho Laravel app
├── docker-compose.yml         # Orchestration các services
├── .dockerignore             # Loại trừ files khi build
├── docker/
│   ├── php.ini              # Cấu hình PHP
│   ├── nginx.conf           # Cấu hình Nginx
│   ├── supervisord.conf     # Cấu hình Supervisor
│   └── entrypoint.sh        # Script khởi tạo
└── mysql-inti/
    └── init.sql             # Database schema
```

## Cài đặt và Chạy

### 1. Yêu cầu hệ thống
- Docker
- Docker Compose
- Git

### 2. Clone và cài đặt
```bash
# Clone repository
git clone <repository-url>
cd superwin

# Build và chạy containers
docker-compose up -d --build
```

### 3. Truy cập ứng dụng
- **Laravel App**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080
  - Username: `superwin_user`
  - Password: `superwin_password`
- **MySQL**: localhost:3306
- **Redis**: localhost:6379

## Cấu hình Database

### Thông tin kết nối
- **Host**: `mysql` (trong container) hoặc `localhost` (từ host)
- **Port**: `3306`
- **Database**: `superwin`
- **Username**: `superwin_user`
- **Password**: `superwin_password`
- **Root Password**: `root_password`

### Environment Variables
Tạo file `.env` với các cấu hình sau:
```env
APP_NAME=SuperWin
APP_ENV=local
APP_KEY=base64:your-key-here
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=superwin
DB_USERNAME=superwin_user
DB_PASSWORD=superwin_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## Lệnh Docker hữu ích

### Quản lý containers
```bash
# Khởi động tất cả services
docker-compose up -d

# Dừng tất cả services
docker-compose down

# Xem logs
docker-compose logs -f app

# Rebuild containers
docker-compose up -d --build

# Xóa volumes (cẩn thận - sẽ mất data)
docker-compose down -v
```

### Laravel Commands
```bash
# Chạy artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan make:controller TestController
docker-compose exec app php artisan tinker

# Composer commands
docker-compose exec app composer install
docker-compose exec app composer update

# NPM commands
docker-compose exec app npm install
docker-compose exec app npm run dev
docker-compose exec app npm run build
```

### Database
```bash
# Truy cập MySQL
docker-compose exec mysql mysql -u superwin_user -p superwin

# Backup database
docker-compose exec mysql mysqldump -u superwin_user -p superwin > backup.sql

# Restore database
docker-compose exec -T mysql mysql -u superwin_user -p superwin < backup.sql
```

## Development Workflow

### 1. Development Mode
```bash
# Chạy với Node.js development server
docker-compose --profile dev up -d

# Hoặc chạy Vite development server riêng
docker-compose exec app npm run dev
```

### 2. Production Build
```bash
# Build production assets
docker-compose exec app npm run build

# Optimize Laravel
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

### 3. Testing
```bash
# Chạy tests
docker-compose exec app php artisan test

# Chạy với coverage
docker-compose exec app php artisan test --coverage
```

## Troubleshooting

### 1. Permission Issues
```bash
# Fix permissions
docker-compose exec app chown -R www-data:www-data /var/www/html
docker-compose exec app chmod -R 755 /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/bootstrap/cache
```

### 2. Database Connection Issues
```bash
# Check MySQL status
docker-compose exec mysql mysqladmin ping -u root -p

# Reset database
docker-compose down -v
docker-compose up -d
```

### 3. Cache Issues
```bash
# Clear all caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### 4. Storage Issues
```bash
# Recreate storage link
docker-compose exec app php artisan storage:link

# Fix storage permissions
docker-compose exec app chmod -R 775 /var/www/html/storage
```

## Performance Optimization

### 1. OPcache
OPcache đã được cấu hình trong `docker/php.ini`:
- Memory consumption: 128MB
- Max accelerated files: 4000
- Revalidate frequency: 2 seconds

### 2. Nginx
- Gzip compression enabled
- Static file caching
- Security headers

### 3. Redis
- Session storage
- Cache driver
- Queue connection

## Security

### 1. Environment Variables
- Không commit file `.env` vào Git
- Sử dụng strong passwords cho database
- Rotate application keys regularly

### 2. File Permissions
- Storage và cache directories có proper permissions
- Sensitive files được deny access trong Nginx

### 3. Network Security
- Containers isolated trong Docker network
- Ports exposed chỉ khi cần thiết

## Monitoring

### 1. Health Check
```bash
# Check application health
curl http://localhost:8000/health
```

### 2. Logs
```bash
# Application logs
docker-compose logs -f app

# Nginx logs
docker-compose exec app tail -f /var/log/nginx/access.log

# PHP logs
docker-compose exec app tail -f /var/log/php_errors.log
```

### 3. Resource Usage
```bash
# Check container resources
docker stats

# Check disk usage
docker system df
```

## Backup và Restore

### 1. Database Backup
```bash
# Create backup
docker-compose exec mysql mysqldump -u superwin_user -p superwin > backup_$(date +%Y%m%d_%H%M%S).sql

# Restore backup
docker-compose exec -T mysql mysql -u superwin_user -p superwin < backup_file.sql
```

### 2. Application Backup
```bash
# Backup application files
tar -czf app_backup_$(date +%Y%m%d_%H%M%S).tar.gz --exclude=node_modules --exclude=vendor .

# Backup volumes
docker run --rm -v superwin_mysql_data:/data -v $(pwd):/backup alpine tar czf /backup/mysql_backup_$(date +%Y%m%d_%H%M%S).tar.gz -C /data .
```

## Production Deployment

### 1. Environment Setup
```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 2. Security
```bash
# Generate strong application key
docker-compose exec app php artisan key:generate --force

# Optimize for production
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

### 3. SSL/TLS
- Sử dụng reverse proxy (Nginx/Traefik)
- Configure SSL certificates
- Enable HTTPS redirects

## Support

Nếu gặp vấn đề, hãy kiểm tra:
1. Docker logs: `docker-compose logs`
2. Application logs: `storage/logs/laravel.log`
3. Nginx logs: `/var/log/nginx/`
4. PHP logs: `/var/log/php_errors.log` 