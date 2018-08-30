# DLG Poultry Farm Management System

[![Build Status](https://travis-ci.org/keanmndz/dlgpoultry.svg?branch=master)](https://travis-ci.org/keanmndz/dlgpoultry)

As partial fulfillment of requirements for Capstone 2. Help 2 kids graduate in their bachelor's degree in Information Technology. _[We did graduate actually]_

> **[05/19/2018 Update]** Successfully defended this system as our Capstone project and earned Best Capstone for it. Yay!

May also be buggy and have missing files. Might not be updating this anymore but depends. This is the public repo for the project, the private repo is the _[most likely]_ updated version of the project.

## Important Notes

* Note that this project uses the Laravel 5.5 PHP Framework. You may check out the Laravel documentation for further information, which has been greatly referenced by the group. Read below.
* Source is the buggy version of the project.
* The web application may be viewed at:
⋅⋅⋅End User: [https://dlgpoultry.azurewebsites.net/](https://dlgpoultry.azurewebsites.net/)
⋅⋅⋅Admin: [https://dlgpoultry.azurewebsites.net/admin](https://dlgpoultry.azurewebsites.net/admin)

## Pre-requisites

- Composer
- Artisan Tools
- XAMPP (or any similar)
- MailTrap/SendGrid (or any similar for emailing services, not required)
- Maildrop.cc (or any similar for dump emails/dummy email account, not required)

## Instructions

1. Make sure that all pre-requisites are available.
2. Copy the files to your device in your preferred path.
3. Open Command Prompt, and change your directory to the path of the files you copied. For example, the file is saved on drive C:, make sure that your path shows "C:\dlg-admin>" on Command Prompt.
4. Open XAMPP (or any similar) and make sure the Apache and MySQL modules are running.
5. Open phpMyAdmin. Create a new database named "dlg". You do not have to create any table, the application will automatically fill the database with a certain command in the following steps.
6. Check the current environment of the application. Open the file folder and open the file ".env" with any text editor. Configure the APP, DB, and MAIL (For the email services. You will need to have your own. Check out MailTrap or SendGrid for this to work.) settings to your current working environment. Make sure that DB_DATABASE has the same database name that you created. This step will most likely take most of your time and make sure to do research and check out the Laravel documentation if you will be having any troubles with this step.
7. Check if the artisan tools are available by typing in Command Prompt, "php artisan -v". The command should show the current version of Laravel installed and a list of commands. You should make sure that the tools work in order to move on to the next step. Take note that these commands are important and very helpful for the project.
8. Set the application key with the command "php artisan key:generate"
9. Run the migrations with the command "php artisan migrate --seed" so that the database will contain the needed tables of the project with the needed data of the application. If you miss out the "--seed" part of the command, it will fill the database with empty tables. 
10. Run the application with the command "php artisan serve". The application will only run locally if this command is running on Command Prompt, so make sure that you do not close the window where the command is running. If you need to stop the application, press "CTRL+C" on the Command Prompt window where you ran the "serve" command.

The application should run smoothly if all the steps are followed.
Debug anything needed.
Check out the seeder classes for the credentials of available users.

###### _Project by: Keena Mendoza & Serine Obviar_

***

### Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

### Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).
