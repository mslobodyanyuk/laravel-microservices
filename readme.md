Laravel Microservices Full Course | Event Driven Architecture with RabbitMQ
===========================================================================

* ***Actions on the deployment of the project:***

	- Making a new project laravel-microservices.loc:
																		
	sudo chmod -R 777 /var/www/LARAVEL/RabbitMQ/laravel-microservices.loc

	//!!!! .conf
	sudo cp /etc/apache2/sites-available/test.loc.conf /etc/apache2/sites-available/laravel-microservices.loc.conf
			
	sudo nano /etc/apache2/sites-available/laravel-microservices.loc.conf

	sudo a2ensite laravel-microservices.loc.conf

	sudo systemctl restart apache2

	sudo nano /etc/hosts
																																
	cd /var/www/LARAVEL/RabbitMQ/laravel-microservices.loc
														
	git clone https://github.com/scalablescripts/laravel-microservices.git

_+ Сut the contents of the folder up one level and delete the empty one._

`.env`-files:

	`admin-app`

```
...
APP_URL=http://admin.test
...
DB_CONNECTION=mysql
DB_HOST=admin_db
DB_PORT=3306
DB_DATABASE=admin
DB_USERNAME=your_username
DB_PASSWORD=your_password
...
QUEUE_CONNECTION=rabbitmq
...
RABBITMQ_HOST=your_RABBITMQ_host
RABBITMQ_PORT=5672
RABBITMQ_USER=your_RABBITMQ_username
RABBITMQ_PASSWORD=your_RABBITMQ_password
RABBITMQ_VHOST=your_RABBITMQ_username
RABBITMQ_QUEUE = main_queue
```	
	
	`main-app`
	
```
...
APP_URL=http://main.test
...
DB_CONNECTION=mysql
DB_HOST=main_db
DB_PORT=3306
DB_DATABASE=main
DB_USERNAME=your_username
DB_PASSWORD=your_password
...
QUEUE_CONNECTION=rabbitmq
...
RABBITMQ_HOST=your_RABBITMQ_host
RABBITMQ_PORT=5672
RABBITMQ_USER=your_RABBITMQ_username
RABBITMQ_PASSWORD=your_RABBITMQ_password
RABBITMQ_VHOST=your_RABBITMQ_username
RABBITMQ_QUEUE = admin_queue
```	
	
`In Terminal:`
	
`admin-app`:

	cd /var/www/LARAVEL/RabbitMQ/laravel-microservices.loc/admin

	composer install

	composer update

`main-app`:
	
	cd /var/www/LARAVEL/RabbitMQ/laravel-microservices.loc/main

	composer install

	composer update					

"RESULT"-points:
================

[(15:50)]( https://youtu.be/SzsPe_QX__c?t=950 ) `In Browser`:

`In Browser`:

	127.0.0.1:8000

![screenshot of sample]( https://github.com/mslobodyanyuk/laravel-microservices/admin/blob/master/public/images/1.png )

---
	
- Check result 
	
[(53:00)]( https://youtu.be/SzsPe_QX__c?t=3180 )

---

`main`-app		
										
`In Terminal`:

	cd /var/www/LARAVEL/RabbitMQ/laravel-microservices.loc/main
	
	docker-compose up --build		

_If no changes were made after build, for a faster launch, you can use the command WITHOUT the `--build` option_
	
		docker-compose up	
		
`In New Terminal`:				

	cd /var/www/LARAVEL/RabbitMQ/laravel-microservices.loc/main
	
	docker-compose exec main sh
	
	php artisan queue:work

`admin-app`

`In Terminal`:

	cd /var/www/LARAVEL/RabbitMQ/laravel-microservices.loc/admin
	 
	docker-compose up --build
	
_If no changes were made after build, for a faster launch, you can use the command WITHOUT the `--build` option_
	
		docker-compose up
	
	sudo chmod -R 777 /var/www/LARAVEL/RabbitMQ/laravel-microservices.loc
	
`In New Terminal`:				

	cd /var/www/LARAVEL/RabbitMQ/laravel-microservices.loc/admin
	
	docker-compose exec admin sh
	
	php artisan migrate
	
			php artisan migrate:rollback
			
	php artisan db:seed
		
	php artisan fire
	
![screenshot of sample]( https://github.com/mslobodyanyuk/laravel-microservices/admin/blob/master/public/images/2.png )

---

- Check result in RabbitMQ Manager 
[(53:20)]( https://youtu.be/SzsPe_QX__c?t=3200 )

CloudAMQP Console RabbitMQ

<https://customer.cloudamqp.com/login>

`In Browser` Enter the `your_RABBITMQ_host`, like:

	goose.rmq2.cloudamqp.com

To enter, type the:

	your_RABBITMQ_username
	your_RABBITMQ_password

_"If we see the chart we can see that event happened right here and it was processed... We fired event."_

![screenshot of sample]( https://github.com/mslobodyanyuk/laravel-microservices/admin/blob/master/public/images/3.png )
			
---

- The another app is running and we should more containers running now:
[(1:27:05)]( https://youtu.be/SzsPe_QX__c?t=5225 )

	docker ps
	
We see the: 

	admin_admin_1 
	admin_admin_queue_1
	admin_admin_db_1
	main_main_1 
	main_main_queue_1
	main_main_db_1

![screenshot of sample]( https://github.com/mslobodyanyuk/laravel-microservices/admin/blob/master/public/images/4.png )

---

_For Check the result at_
[(53:00)]( https://youtu.be/SzsPe_QX__c?t=3180 )
_I added the nex code._

---
 
Files in `admin`-app:
	
[(51:30)]( https://youtu.be/SzsPe_QX__c?t=3090 ) `app/Providers/EventServiceProvider.php`:

```php
public function boot()
{
	\App::bindMethod(TestJob::class . '@handle', fn($job) => $job->handle());
	...
}
```

[(52:15)]( https://youtu.be/SzsPe_QX__c?t=3135 ) `app/Jobs/TestJob.php`: 

```php
public function handle()
{
	echo 'Event has been handled' . PHP_EOL;
}
```

---

_Also, pay attention:_

- "Usually at first time failed:"

---

[(14:00)]( https://youtu.be/SzsPe_QX__c?t=840 )

	docker-compose up
	
[(14:40)]( https://youtu.be/SzsPe_QX__c?t=880 )	"Usually at first time failed:"
	
Error:
	
_admin_db_1 exited with code 1_

[(14:45)]( https://youtu.be/SzsPe_QX__c?t=885 )
	
	Ctrl + C
	
	- To stop and run command again:
	
	docker-compose up	

	- "Now we have `storage/dbdata` which are the files from mysql which is importing here. We can see we didn't have this folder before."

---

- Error: "The reason is - to run this migration a have to be inside my docker container".

---

[(18:35)]( https://youtu.be/SzsPe_QX__c?t=1115 )

	php artisan migrate
	
	Error: "The reason is - to run this migration a have to be inside my docker container".

[(19:05)]( https://youtu.be/SzsPe_QX__c?t=1145 )

	docker-compose exec admin sh
	 
[(19:30)]( https://youtu.be/SzsPe_QX__c?t=1170 )

	php artisan migrate

---

- The subtle point, based on your PHP version, is to choose the appropriate syntax for callback functions.

---

[(51:36)]( https://youtu.be/SzsPe_QX__c?t=3096 )
	
```php	
		//1:
public function boot()
{        
	\App::bindMethod(TestJob::class . '@handle', function($job){
		return $job->handle();
	});   
}
```	
	
OR	

```php	
		//2:
public function boot()
{        
	\App::bindMethod(TestJob::class . '@handle', fn($job) => $job->handle());
}	
```
	
---
	
- Specify your OS

---

[(1:08:10)]( https://youtu.be/SzsPe_QX__c?t=4090 )
 `main/app/Http/Controllers/ProductController.php`:

```php
public function like($id, Request $request)
{
	$response = \Http::get('http://localhost:8000/api/user');
	
	return $response->json();	
}
```	

[(1:08:40)]( https://youtu.be/SzsPe_QX__c?t=4120 )

[(1:08:55)]( https://youtu.be/SzsPe_QX__c?t=4135 )
 Restart the docker container:
	
	Ctrl + C 
	docker-compose up
	
		- Fail to Response.	

[(1:09:30)]( https://youtu.be/SzsPe_QX__c?t=4170 )
	
_"Becouse the difference between `localhosts`. Sometimes it's `localhost`, sometimes it's not. In docker container we must tosay thet the `localhost` not the `docker localhost`"_:

```php
public function like($id, Request $request)
{
	$response = \Http::get('http://docker.for.mac.localhost:8000/api/user'); 	
							
	return $response->json();	
}

```

---

Useful commands for Ubuntu before using Docker.
===============================================

- UBUNTU - "4+ commands":																							

<https://losst.ru/ochistka-sistemy-ubuntu>

1:

	sudo apt-get autoclean
	
		It is recommended to run this command periodically, cleaning the system of packages that it no longer needs.
2:

	sudo apt-get autoremove

		This command removes the remaining dependencies on packages that have been removed from the system.
3:

	sudo apt-get clean

		Clearing the cache and/or `/var/cache/apt/archives/`.
4:		
	
	sudo /usr/local/bin/remove_old_snaps.sh
	
- IF you create `remove_old_snaps.sh` before, like: 

`remove_old_snaps.sh`:

```
#!/bin/bash
set -eu
LANG=en_US.UTF-8 snap list --all | awk '/disabled/{print $1, $3}' |
while read snapname revision; do
snap remove "$snapname" --revision="$revision"
done
```	
		
`+`	

	sudo apt-get -f install
	
		 Clean up unnecessary packages after software removal, if any.

- DOCKER:
		
<https://habr.com/ru/company/flant/blog/336654/>
		
		Stopping and removing all containers:
		
	docker stop $(docker ps -a -q) && docker rm $(docker ps -a -q)
	
		Removing all images:
		
	docker rmi $(docker images -a -q)

- ALLOCATE MEMORY:

	`free -m`
	
	`sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024`
	
	`sudo /sbin/mkswap /var/swap.1`
	
	`sudo /sbin/swapon /var/swap.1`

Error: 
	
_"proc_open(): fork failed - Cannot allocate memory"_	
	
<https://www.nicesnippets.com/blog/proc-open-fork-failed-cannot-allocate-memory-laravel-ubuntu>

---																							

Scalable Scripts

[Laravel Microservices Full Course | Event Driven Architecture with RabbitMQ (1:28:04)]( https://www.youtube.com/watch?v=SzsPe_QX__c&ab_channel=ScalableScripts )

[00:00:00]( https://youtu.be/SzsPe_QX__c?t=0 ) 
 Project Introduction
 
[00:03:42]( https://youtu.be/SzsPe_QX__c?t=222 )
 Connect Laravel and Mysql with Docker

[00:16:04]( https://youtu.be/SzsPe_QX__c?t=964 )
 Migrations, Seeders and Factories

[00:26:07]( https://youtu.be/SzsPe_QX__c?t=1567 )
 Products Rest API CRUD
  
[00:38:20]( https://youtu.be/SzsPe_QX__c?t=2300 )
 Main App Setup

[00:45:19]( https://youtu.be/SzsPe_QX__c?t=2719 )
 RabbitMQ

[00:53:26]( https://youtu.be/SzsPe_QX__c?t=3206 )
 Data Consistency Between Microservices

[01:04:26]( https://youtu.be/SzsPe_QX__c?t=3866 )
 Internal Http Requests

[01:15:11]( https://youtu.be/SzsPe_QX__c?t=4511 )
 Queue Service
															
Source Code: 
<https://github.com/scalablescripts/laravel-microservices>
		
---

[00:26:07]( https://youtu.be/SzsPe_QX__c?t=1567 )
 Products Rest API CRUD
 
--- 
	
[(28:45)]( https://youtu.be/SzsPe_QX__c?t=1725 )
 Create a `HTTP-Request` - `http.http`:

```
GET http://localhost:8000/api/products
Accept: application/json
```
 
`In Terminal:`

```
curl -X GET -H accept:application/json "http://localhost:8000/api/products"
```

[(30:30)]( https://youtu.be/SzsPe_QX__c?t=1830 )

 `http.http`:

```
GET http://localhost:8000/api/products/1
Accept: application/json
```	

`In Terminal:`

```
curl -X GET -H accept:application/json "http://localhost:8000/api/products/1"
```

[(34:10)]( https://youtu.be/SzsPe_QX__c?t=2050 )
 `http.http`:

```
POST http://localhost:8000/api/products
Accept: application/json
Content-Type: application/json

{
	"title": "title",
	"image": "image"	
}
```	

`In Terminal:`

```
curl -X POST -H accept:application/json -H Content-type:application/json --data-binary '{ "title": "title", "image": "image" }' "http://localhost:8000/api/products"
```

[(36:35)]( https://youtu.be/SzsPe_QX__c?t=2195 )
 `http.http`:

```
PUT http://localhost:8000/api/products/11
Accept: application/json
Content-Type: application/json

{
	"title": "new title",
	"image": "new image"	
}
```	

`In Terminal:`

```
curl -X PUT -H accept:application/json -H Content-type:application/json --data-binary '{ "title": "new title", "image": "new image" }' "http://localhost:8000/api/products/11"
```

[(37:55)]( https://youtu.be/SzsPe_QX__c?t=2275 )
 `http.http`:

```
DELETE http://localhost:8000/api/products/11
Accept: application/json
Content-Type: application/json
```

`In Terminal:`

```
curl -X DELETE -H accept:application/json -H Content-type:application/json "http://localhost:8000/api/products/11"
```
	
[(38:10)]( https://youtu.be/SzsPe_QX__c?t=2290 )
 `http.http`:

```
GET http://localhost:8000/api/products/11
Accept: application/json
Content-Type: application/json
...
	<Response body is empty>
```

`In Terminal:`

```
curl -X GET -H accept:application/json -H Content-type:application/json "http://localhost:8000/api/products/11"
```

[00:38:20]( https://youtu.be/SzsPe_QX__c?t=2300 )
 Main App Setup
 
--- 

[00:45:19]( https://youtu.be/SzsPe_QX__c?t=2719 )
 RabbitMQ
 
--- 

[00:53:26]( https://youtu.be/SzsPe_QX__c?t=3206 )
 Data Consistency Between Microservices

---

[(58:10)]( https://youtu.be/SzsPe_QX__c?t=3490 )
 Let's try again `http.http` - Now it's processed successfully:

```
POST http://localhost:8000/api/products
Accept: application/json
Content-Type: application/json

{
	"title": "t2",
	"image": "2i"	
}
```

`In Terminal:`

```
curl -X POST -H accept:application/json -H Content-type:application/json  --data-binary '{ "title": "t2", "image": "2i" }' "http://localhost:8000/api/products"
```	

[(1:03:20)]( https://youtu.be/SzsPe_QX__c?t=3800 )

```
PUT http://localhost:8000/api/products/12
Accept: application/json
Content-Type: application/json

{
	"title": "new t",
	"image": "2i"	
}
```

`In Terminal:`

```
curl -X PUT -H accept:application/json -H Content-type:application/json  --data-binary '{ "title": "new t", "image": "2i" }' "http://localhost:8000/api/products/12"
```

[(1:04:05)]( https://youtu.be/SzsPe_QX__c?t=3845 )

```
DELETE http://localhost:8000/api/products/12
Accept: application/json
Content-Type: application/json
```

- Now we don't have a Product.
 
`In Terminal:`

```
curl -X DELETE -H accept:application/json -H Content-type:application/json "http://localhost:8000/api/products/12"
``` 

[01:04:26]( https://youtu.be/SzsPe_QX__c?t=3866 )
 Internal Http Requests
 
--- 
	
[(1:06:05)]( https://youtu.be/SzsPe_QX__c?t=3965 )
 `http.http`:

```
GET http://localhost:8000/api/user
Accept: application/json
Content-Type: application/json
```

`In Terminal:`

```
curl -X GET -H accept:application/json -H Content-type:application/json "http://localhost:8000/api/user"
```

[(1:10:00)]( https://youtu.be/SzsPe_QX__c?t=4200 )
 `http.http`:

```
POST http://localhost:8001/api/products/13/like
Accept: application/json
Content-Type: application/json

{}
```

`In Terminal:`

```
curl -X POST -H accept:application/json -H Content-type:application/json  --data-binary '{ }' "http://localhost:8001/api/products/13/like"
```

[(1:13:45)]( https://youtu.be/SzsPe_QX__c?t=4425 )
 Let's like again this Product `http.http`:

```
POST http://localhost:8001/api/products/13/like
Accept: application/json
Content-Type: application/json

{}
```

_"error": "You already liked this product!"_	
	

[(1:14:35)]( https://youtu.be/SzsPe_QX__c?t=4475 )
 Try again:

_"message": "success"_	    

[(1:15:05)]( https://youtu.be/SzsPe_QX__c?t=4505 )
 Like again:	
	
_"error": "You already liked this product!"_		

		- So this is how you make Internal Requests with Laravel.

[01:15:11]( https://youtu.be/SzsPe_QX__c?t=4511 )
 Queue Service
	
---	

[(1:18:40)]( https://youtu.be/SzsPe_QX__c?t=4720 )

```
POST http://localhost:8001/api/products/13/like
Accept: application/json
Content-Type: application/json

{}
```

_"error": "You already liked this product!"_	

Try again:

_"message": "success"_	    	
	
[(1:20:15)]( https://youtu.be/SzsPe_QX__c?t=4815 )
	- Let's see the Terminal - it Failed, becouse we don't have Product 13.

```
POST http://localhost:8000/api/products
Accept: application/json
Content-Type: application/json

{ 
	"title": "t",
	"image": "i"
}
```

`In Terminal:`

```
curl -X POST -H accept:application/json -H Content-type:application/json  --data-binary '{ "title": "t", "image": "i" }' "http://localhost:8000/api/products"
```

[(1:22:50)]( https://youtu.be/SzsPe_QX__c?t=4970 )
 Let's Create again Product:		
	
```
POST http://localhost:8001/api/products/15/like
Accept: application/json
Content-Type: application/json

{ 
	"title": "t",
	"image": "i"
}
```

	"- Product 15 is Created. So we got the Product here and not processed here. Change port to 8001 and ...:" 
	
`In Terminal:`

```
curl -X POST -H accept:application/json -H Content-type:application/json  --data-binary '{ "title": "t", "image": "i" }' "http://localhost:8001/api/products/15/like"
```
	
[(1:23:10)]( https://youtu.be/SzsPe_QX__c?t=4990 )
	
```
POST http://localhost:8001/api/products/15/like
Accept: application/json
Content-Type: application/json

{ 
	"title": "t",
	"image": "i"
}
```	
	"- So the message was successful and Not handled, another - handled. So we got the two different queues now running parallely."
	
`In Terminal:`

```
curl -X POST -H accept:application/json -H Content-type:application/json  --data-binary '{ "title": "t", "image": "i" }' "http://localhost:8001/api/products/15/like"
```

[(1:27:15)]( https://youtu.be/SzsPe_QX__c?t=5235 )

```
POST http://localhost:8001/api/products/15/like
Accept: application/json
Content-Type: application/json

{ 
	"title": "t",
	"image": "i"
}
```	

And one app should handle, so this app processed product liked. 
	
`In Terminal:`

```
curl -X POST -H accept:application/json -H Content-type:application/json  --data-binary '{ "title": "t", "image": "i" }' "http://localhost:8001/api/products/15/like"
```

[(1:27:35)]( https://youtu.be/SzsPe_QX__c?t=5255 )
 And if I Create a Product:

```
POST http://localhost:8000/api/products
Accept: application/json
Content-Type: application/json

{ 
	"title": "t",
	"image": "i"
}
```	

 - It should be the other app, so this app doesn't do anything here. But this app is processed that product created. And we can actually see it in a database.

`In Terminal:`

```
curl -X POST -H accept:application/json -H Content-type:application/json  --data-binary '{ "title": "t", "image": "i" }' "http://localhost:8000/api/products"
``` 

#### Useful links:

Scalable Scripts

[Laravel Microservices Full Course | Event Driven Architecture with RabbitMQ]( https://www.youtube.com/watch?v=SzsPe_QX__c&ab_channel=ScalableScripts )

Source Code: 
<https://github.com/scalablescripts/laravel-microservices>

---

Vladimir Yuldashev

<https://github.com/vyuldashev/laravel-queue-rabbitmq>

<https://www.larablocks.com/package/vladimir-yuldashev/laravel-queue-rabbitmq>

---

Install RabbitMQ

<https://coderun.ru/blog/kak-ustanovit-rabbitmq-server-v-ubuntu-18-04-i-16-04-lts/>

[Install RabbitMQ on Ubuntu and work with NodeJS]( https://www.youtube.com/watch?v=FmAMhpeek8A&ab_channel=NevyanNeykov )

<https://customer.cloudamqp.com/login>

---

Docker

<https://habr.com/ru/company/flant/blog/336654/>

---

Ubuntu

<https://losst.ru/ochistka-sistemy-ubuntu>

---

Possible Errors

<https://www.nicesnippets.com/blog/proc-open-fork-failed-cannot-allocate-memory-laravel-ubuntu>

<https://laracasts.com/discuss/channels/laravel/php-arrow-functions-just-stopped-working>