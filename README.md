<h1>CMS</h1>



## About 

CMS is a Management platform to help the organization manage employee requests by sending the requests to the manager for approval or denial.

## Technologies

* PHP ^8.1
* Laravel ^10 
* Express ^4.18.2 
* Node ^12.22 
* MySQL 
* Axios.js 


## Installation 
To install first you need to clone the project 
  
```bash
git clone https://github.com/Aamer99/laravel-api.git 
```

Go to the project directory

```bash
  cd my-project
```
Go to the frontend folder 

```bash
  cd frontend 
```

Install dependencies

```bash
  npm install
```

Start the server

```bash
  npm run dev
```

know we need to run the backend but first, we need to do: 
1. install Redis 
2. install Horizon.
3. set up the email configuration. 
4. create a database.
5. migrate to create the tables in the database.


 
after that, we need to install the Redis and setup in the env file
## Install Redis 
Go to the project directory
```bash
  cd my-project
```
Install Redis

```bash 
composer require predis/predis
```
Setup Redis on the env 

```bash 
BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=redis
SESSION_DRIVER=file
SESSION_LIFETIME=120
```
for more information about how to install Redis on docker [Link](https://hub.docker.com/_/redis) 

##  Install Horizon
To install, run the following command

```bash
composer require laravel/horizon
```
 Publish its assets using the horizon:install Artisan command: 
```bash 
php artisan horizon:install 
```
## Setub the email configuration
for the email go to the [mailtrap](https://mailtrap.io/) and create an account after that take the configuration values and put it on the env file 

```bash 
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=*******
MAIL_PASSWORD=********
MAIL_ENCRYPTION=tls
```

## Create Database 

after we install what we won't know you need to create the database and set it to the env 

```bash 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```  
after that, we need to migrate all the tables by writing this command.
 
```bash
php artisan migrate
```

know you can run the server by writing this command. 

```bash
php artisan serve
```
final step run the queue bt writing this command 
``` bash 
php artisan queue:work 
```

know we need to install the draft server [Follow this link](https://github.com/Aamer99/AM/tree/main/DraftServer)

