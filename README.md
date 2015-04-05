# Mailing List

*A simple mail distribution*

Based on [Kohana 3.2 framework](http://kohanaframework.org/).

### Includes

Uses a number of open source projects to work properly:

* [Twitter Bootstrap] - great UI boilerplate for modern web apps
* [Moment.js] - a lightweight JavaScript date library
* [Bootstrap Datepicker] - great calendar for Twitter Bootstrap
* [Swift Mailer] - powerful component based mailing library for PHP
* [jQuery] - duh

## [Demo](http://mailing.equites.com.ua/)

## Installation

1. Copy soure files to webserver.
2. Make sure the `application/cache` and `application/logs` directories are writable by the web server.
3. Create MySQL database and import dump file `mailing.sql`.
4. Configure connection to the database in `application/config/database.php`.
5. Set absolute site base URL in `application/bootstrap.php` on line 90.
6. Create crontab task for run mail distribution every 10 minutes (or someone else):
```
*/10 * * * * php /path/to/document/root/index.php --uri=distribution/run
```

[Twitter Bootstrap]:http://twitter.github.com/bootstrap/
[Moment.js]:http://momentjs.com/
[Bootstrap Datepicker]:https://github.com/Eonasdan/bootstrap-datetimepicker
[Swift Mailer]:http://swiftmailer.org/
[jQuery]:http://jquery.com/

