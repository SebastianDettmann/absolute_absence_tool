# Absolute Absence Tool

## Installation

```bash
cd [PATH-TO-PROJECT]
chmod -R 0777 ./storage && chmod 0777 ./bootstrap/cache && composer install
npm install --no-optional
touch .env
php artisan key:generate
php artisan migrate         or optional with db seedings:    php artisan migrate --seed

set all necessary data in .env file

change password for first admin, can be found in /Libs/Datamap
check the url for the absence tool, can be found in /Libs/Datamap

you can run the app localy with: "php artisan serve"
