<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About this project

According to the job ad, submited by [Asimov](https://goo.gl/M9vJX2), I have developed a solution 

## Considerate the following
- I have assumed that you know how to install a laravel project
- I Have assumed that you have knowledge about databases, php, css, etc

## Step 1: The web client
- Open a terminal and clone this repo ```git clone  https://github.com/guillermoprojaslema/asimov_web.git```
- ```cd asimov_web```
- ```composer install```
- ```php artisan serve```
## Step 2: The API project
- Open a terminal and clone this other repo ```git clone  https://github.com/guillermoprojaslema/asimov.git```
- ```cd asimov```
- ```composer install```
### 2.1 Create  your database. In this case, I'll use MySql
- ``` mysql -u root -p``` then type your pasword and then ``` create database asimov; use asimov; ```
- Then, you'll have to edit your ```.env``` with valid credentials for your environment, such as database name, database driver, password. You can achive that with ```nano .env```
- One, your ```.env``` is ready, execute ```php artisan migrate```
- ```php artisan db:seed``` 
- ```php -S localhost:8080 -t public```

## Step 3: See the web client
- Open your favourite browser and go to ```http://localhost:8000/appointments```

## Step 4: Hire me!


