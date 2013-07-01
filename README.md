Cachebuster
====================

A tiny class for cachebusting resource files.

Usage
-----

1. Make sure the `RewriteRule` is included somehow (e.g. in the `.htaccess` file)
```apache
    <IfModule mod_rewrite.c>

        RewriteEngine on
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.+)\.(\d+)\.(js|css|png|jpg|gif)$ $1.$3 [L]

    </IfModule>
```
2. Include the class and initialise the roots:
```php
    require_once('Cachebuster.php');
    $cachebuster = new DannyNimmo\Cachebuster();
    $cachebuster
        ->setFileRoot(dirname(__FILE__))
        ->setWebRoot('/subdir/');
```
3. Use the `getUrl` method to include files:
```phtml
    <link rel="stylesheet" href="<?php echo $cachebuster->getUrl('css/main.css'); ?>">
    <script src="<?php echo $cachebuster->getUrl('js/main.js'); ?>"></script>
    <img src="<?php echo $cachebuster->getUrl('img/mugshots/danny.jpg'); ?>">
```
