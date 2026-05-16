@echo off
echo ========================================================
echo   Smart Education System - Starting Servers
echo ========================================================
echo.
echo Starting Laravel Backend Server on port 8000...
start cmd /k "php artisan serve"

echo Starting Vite Frontend Compiler...
start cmd /k "npm run dev"

echo.
echo Servers are starting in separate windows!
echo Please open your browser and go to: http://127.0.0.1:8000
echo.
pause
