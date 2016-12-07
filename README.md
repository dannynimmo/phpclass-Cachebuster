Cachebuster
====================

A tiny class for cachebusting resource files. Once implemented, any change to a resource file will force the browser to re-cache said file.

How it works
------------

The `getUrl` method will return the web path with the file's last modified timestamp appended, e.g. `getUrl('css/main.css')`
might return `/css/main.1372620112.css`. The `RewriteRule` will strip out the timestamp and serve the file correctly, but
browsers will believe the file to be unique. This is currently the method recommended by the [HTML5 Boilerplate team](https://github.com/h5bp/server-configs/blob/master/apache/README.md#cache-busting).

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

2. Add this project to your composer.json:

    ```
    "autoload": {
        "psr-4": {
            "DannyNimmo\\": "libraries/dannynimmo/phpclass-Cachebuster"
        }
    }
    ```
    
3. Include the class and initialise the roots:
    ```php
    use DannyNimmo\Cachebuster;
    
    $cachebuster = new Cachebuster();
    $cachebuster
        ->setFileRoot(dirname(__FILE__))
        ->setWebRoot('/subdir/');
    ```
    
4. Use the `getUrl` method to include files:
    ```phtml
    <link rel="stylesheet" href="<?php echo $cachebuster->getUrl('css/main.css'); ?>">
    <script src="<?php echo $cachebuster->getUrl('js/main.js'); ?>"></script>
    <img src="<?php echo $cachebuster->getUrl('img/mugshots/danny.jpg'); ?>">
    ```
