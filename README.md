
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>  

<<<<<<< HEAD
## Run Project
	create your database 
	copy .env.example to .env and enter your mail host and database connection info.

```bash  
Run following commands 
$ composer install
$ composer dempautoload
$ php artisan key:generate
$ php artisan migrat --seed
$ php artisan serve
```

There are two application
-   central application
-   tenant application

For central application the main domain for localhost is
http://localhost:8000/v1/api
for dahsboard
http://localhost:8000/v1/api/dashboard


Tenant Application Domains will be like
=======
## Run Project 
	create your database 
	copy .env.example to .env and enter your mail host and database connection info.
	
```bash  
Run following commands 
$ composer install
$ composer dempautoload
$ php artisan key:generate
$ php artisan migrat --seed
$ php artisan serve
```

There are two application
-   central application
-   tenant application

For central application the main domain for localhost is 
http://localhost:8000/v1/api
for dahsboard
http://localhost:8000/v1/api/dashboard


Tenant Application Domains will be like 
>>>>>>> 7625987f76ee366b6a13725a3639cf0b8e4989b0
http://{tenant-domain}.localhost:8000/v1/api
