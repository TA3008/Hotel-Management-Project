# Tạo người dùng mới với quyền super admin 
# user: superadmin@gmail.com
# pass: 123456
php artisan app:create-super-admin

# Tạo role owner
php artisan app:generate-owner-role


# Clear bộ nhớ 
composer dump-autoload
php artisan clear-compiled
php artisan config:clear
php artisan cache:clear
php artisan view:clear