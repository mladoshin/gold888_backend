1. cp  .env.example .env
2. make fpm
3. composer install
4. php artisan key:generate 
5. php artisan migrate --seed
6. mysql -u user -p app_db < d1612.sql 



