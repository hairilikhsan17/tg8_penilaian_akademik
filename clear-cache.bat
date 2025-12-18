@echo off
echo Clearing Laravel cache...
cd /d D:\laragon\www\tg3_221118
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
echo.
echo Cache cleared successfully!
pause









