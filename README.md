# Tạo người dùng mới với quyền super admin 
# user: superadmin@gmail.com
# pass: 123456
php artisan app:create-super-admin

# Tạo role owner
php artisan app:generate-owner-role

# Generate quyền filament-shield
php artisan shield:generate --all

# Seed data
php artisan db:seed

# Clear bộ nhớ 
composer dump-autoload
php artisan clear-compiled
php artisan config:clear
php artisan cache:clear
php artisan view:clear