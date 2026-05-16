@echo off
echo ========================================================
echo   Smart Education System - Database ^& Spatie Fix
echo ========================================================

echo.
echo [1/4] Clearing application and permission caches...
call php artisan cache:clear
call php artisan config:clear
call php artisan permission:cache-reset

echo.
echo [2/4] Ensuring Spatie Permissions are published...
call php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force

echo.
echo [3/4] Running fresh migrations and seeders...
echo (This will drop all existing tables, recreate them, and seed the demo data)
call php artisan migrate:fresh --seed

echo.
echo [4/4] Done! 
echo.
echo You can now log in using:
echo - admin@smartedu.com / password
echo - teacher@smartedu.com / password
echo - student@smartedu.com / password
echo.
pause
