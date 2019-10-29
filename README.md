To Do List Application

# How to 
1. Pull Git 
2. Install Application

# Requirement
1. Composer 
2. PHP >= 7.3
3. MariaDB >= 10.3

# How to Install Application
1. comment all line 41 - 49 from web.php
2. composer install
3. create .env file at ./
4. copy .env.examplet to .env
5. change database hostname to database name at mysql
6. change database username and password to your config
7. change APP_URL to http://127.0.0.1:8000
8. php artisan key:generate
9. php artisan migrate:fresh --seed
10. php artisan storage:link
11. php artisan passport:keys
12. uncomment all line 41 - 49 from web.php
13. php artisan passport:install

# Credentials Data
- Email : bagus.pm29@gmail.com
- Username : baguspm
- Password : qwerty

# Setting User Role
- Manage Setting > Restricted Setting > Role > User Menu Permission
- Check All Module
