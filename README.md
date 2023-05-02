
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>  


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


For central application the main domain for localhost is 

http://localhost:8000/v1/api
for dahsboard
http://localhost:8000/v1/api/dashboard


Tenant Application Domains will be like

http://{tenant-domain}.localhost:8000/v1/api



## Important Notic 
## Defferent between media table and media_library
media table created by spatie/laravel-medialibrary
it use to add media to any of project entity 
we can add media from media library or by upload from user device

media_library custom media library use to make library of files to can embed to any of project modules
