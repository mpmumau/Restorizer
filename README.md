# Restorizer

A PHP-based RESTful web service with psuedo-MVC properties.

Copyright (c) 2015 Matt Mumau

Licensed under The MIT License. 
For full copyright and license information, please see the LICENSE.txt.
Redistributions of files must retain the above copyright notice.

## About

Restorizer is a PHP-based RESTful web service that attempts to mimick an MVC framework. It allows you to serve data from a database using RESTful principals, while also allowing you to override the basic REST operations (GET, PUT, DELETE, POST) with your own custom MVC-like logic. It outputs JSON objects only as returns from RESTful operations.

## Purpose

Applications built with Restorizer would be used as backends to frontend client web sites. Whereas traditional MVC frameworks cover both the front and backend output of web information, Restorizer is meant exclusively to provide a backend service. 

One could imagine using Restorizer with, for example, a "one-page," Javascript-based web client. The frontend application would send an XMLHttpRequest to the Restorizor backend, which would in turn give the client JSON data in return.

While I am aware there are many solutions out there that do something similar, what makes Restorizer different is that you may write models, controllers and views for Restorizer will may override the basic RESTful operations in order to provide data in a format of your design.

## Usage

Simply upload the files to a web server directory. Edit the "app/db_config.php" to suit your database, and away you go!

You can start working with database tables without even writing any code. Simply creating a database table is enough to begin with. 

For example, we'll imagine we want a backend to output articles. In that case, make a database table called "articles" (note that the naming convention for tables should be #1 all lowercase and #2 the pluralized version of your objects: cats, dogs, mice; the application will automatically pluralize English words correctly). Database tables should include an "id" field as an autoincrementing integer for identifying specific objects.

To access that data (for example, using Postman-generated requests for testing purposes), simply include RESTful style requests, like so:

[GET] http://your-domain.com/article 
* Returns all articles

[GET] http://your-domain.com/article/5
* Returns article with id of 5

[PUT] http://your-domain.com/article
* Creates a new article

[PUT] http://your-domain.com/article/5 {include body data}
* Updates an article

[DELETE] http://your-domain.com/article/3
* Deletes and article

## Changelog

v0.1.0
* Initial version.





