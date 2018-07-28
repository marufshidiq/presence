## Presence

### How to install

- Clone this repository
- `composer update` to install composer package
- Copy `.env.example` to `.env` and configure the environtment
- `php artisan key:generate` to generate key
- `php artisan migrate` to migrate the table
- `php artisan db:seed --class=StartSeeder` to add data seeder