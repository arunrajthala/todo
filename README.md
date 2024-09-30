**Todo management**
------------



Technical Challenge 
============

As a project manager, I would like to manage my todo tasks.
## Overview

This project includes CRUD rest API for todo management. In this project, service-repository pattern is used
with extreme object oriented practice.
The codes follows all the approved PRS standards and best practices. 
It follows SOLID principle with DRY codes. The methods are well testable.


## Installation process


change the directory to the project and run 
Copy .env.example file to .env
```sh
cp .env.example .env
```
Edit the parameters on .env file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tasks
DB_USERNAME=root
DB_PASSWORD=secret
```

Install composer packages
```sh
composer install
```

Create database matching .env parameter DB_DATABASE 

Run following scripts to setup project
```sh
composer dump-autoload
php artisan migrate
npm install
npm run prod
```

to view the results, create server locally
```sh
php artisan serve
```
Then browse the local server

## About

In this project I have used the latest version of Laravel because it is 
one of the best frameworks in PHP. I have been using this framework for more than
5 years and I really appreciate the developers who gave a lot of time to build 
this framework with lots of love and care.
View.js is used for frontend processing.
It makes system pretty fast and user-friendly. 
Very basic HTML template is used. Twitter Bootstrap was used for styling the page.

Hope you guys will like my project.

**Happy Coding !!!**



