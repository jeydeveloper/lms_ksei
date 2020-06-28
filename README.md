# NCCLP2-NEW-DESIGN
NCCLP2 new design

# SOFTWARE PREREQUISITE

* XAMPP 5.6.28-0
* MySQL/MariaDB 10.1.19
* PHP 5.6.28
* phpMyAdmin 4.5.2

# APPLICATION SETUP

- edit system/application/config/config.php
```php
$config['base_url']= "http://localhost/lmsv2/";  //sesuaikan dengan environtment
```

- edit database config : ./system/application/config/database.php
```php
$db['default']['hostname'] = "localhost";
$db['default']['username'] = "root";
$db['default']['password'] = "abcd";
$db['default']['database'] = "netpolitan_lmsv2";
$db['default']['dbdriver'] = "mysql";
```

- edit system/application/config/config.path.php
```php
$config['base_path']= "C:/xampp/htdocs/elearning";
```
