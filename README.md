# tiny-framework 

A light wight easy to use RESTful apis framework for education & demo purposes. stripped down framework to the fundamental components that that every one would essentially need to (learn / make a demo application).

Installation Instructions

    1- Clone tiny-framwork
    1- cd /path/to/app
    2- run "composer update -o","composer du"
    3- run the this command "php -S localhost:8080 -t public/" depends on your configuration

# Features
1- Service Container.

2- Routes.

3- Response (json). 

4- Session Handler.

5- Database (PDO driver).

6- Command Line (Symfony Component).

7- Dependency Injection.

8- Models / Controllers.

9- Class Mapping / Reflections.

10- File Handler.
 
# Commands
   1- Creates CRUD Controller / Model / Routes
```
 ./app/Core/Commands/Console tiny:create-crud <name>
```  
# Run Unit Tests
 
```
 1- cd /path/to/app 
 2- run ./vendor/bin/phpunit or composer test 
 ```  

# Missing Features 

 
 - Adding more db drivers
 - Adding front end integration / handling
 - Cover more test cases
 - More Commands (makes it easier to use the framework)
 - Adding DB migration files feature

# Intro 

Typically the entry point is public/index.php

creates a new app object 

from here you will find the framework bootstrapping 

injecting the autoload and calling bootstrap/app.php 

form this point on the framework goes into action filling a service container

reading the routes 

matching the requested route with the registered then get the controller and the requested function 
