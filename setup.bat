@echo off
echo ========================================================
echo   Smart Education System - Corrected Setup Script
echo ========================================================
echo.

echo Cleaning up previous failed setup files...
if exist composer.json del composer.json
if exist composer.lock del composer.lock
if exist vendor rmdir /S /Q vendor
if exist node_modules rmdir /S /Q node_modules
if exist package.json del package.json
if exist package-lock.json del package-lock.json

echo.
echo [1/4] Installing Laravel 11...
call composer create-project laravel/laravel smart_edu_temp
xcopy /E /Y /H smart_edu_temp\* .
rmdir /S /Q smart_edu_temp

echo.
echo [2/4] Installing Laravel Breeze (Authentication)...
call composer require laravel/breeze --dev
call php artisan breeze:install blade --dark

echo.
echo [3/4] Installing Spatie Laravel Permission...
call composer require spatie/laravel-permission
call php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

echo.
echo [4/4] Installing Chart.js for Analytics...
call npm install chart.js

echo.
echo ========================================================
echo Setup Complete! 
echo Please reply to Antigravity letting it know the setup is done.
echo ========================================================
pause
