<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Installation

 - git clone https://github.com/Ta0uf19/laravel-messagerie.git
 - composer install 
 - mv .env.example .env 
		 *Then configure database*
   
  - php artisan key:generate    
	   *to generate key for laravel app php*
  - php artisan passport:install 
		   *to generate key for oath passport*
 - chmod -R ug+rwx storage bootstrap/cache  
 - php artisan migrate --seed  
 
   **if error:* [PDOException] could not find driver.  	sudo apt install php7.0-mysql*
   
  - php artisan serve --host=serverip --port=port & 
  *to start the app*
 

## Live demo
http://93.113.206.217:8000
email : test@test.com
password: test1234

![enter image description here](https://i.imgur.com/8YSJYx2.png)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
