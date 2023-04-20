# How to install

- git clone https://github.com/QR-Code-Waste-Retribution/be-qr-code-retribution.git
- /usr/bin/composer install
- php artisan key:generate
- Buka Xampp 
    - Manager-Osx (mac os) pake command + space
    - Xampp (Windows)        
        - run mysql dan apache

- php artisan migrate:fresh --seed
- php artisan passport:install --force
- php artisan serve
- adb reverse tcp:8000 tcp:8000



# Me-Run dan Menghubungkan dengan Front-End Aplikasi Mobile
- git pull origin main
- /usr/bin/composer install
- Buka Xampp 
    - Manager-Osx (mac os) pake command + space
    - Xampp (Windows)
        - run mysql dan apache

- php artisan migrate:fresh --seed
- php artisan passport:install --force
- php artisan serve
- adb reverse tcp:8000 tcp:8000
