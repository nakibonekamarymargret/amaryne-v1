# Amaryne Saloon management system
**Prerequisites**

Before you begin, ensure you have the following installed on your server:

PHP 7.4+ (or a compatible version)
Nginx
Composer (for managing PHP dependencies)
PostgreSQL

CLONE THE PROJECT
Clone the amaryne-v1 from GitHub to your server:
Open your terminal 
  on Linux **Ctrl + Alt + T**
  
git clone https://github.com/nakibonekamarymargret/amaryne-v1.git
cd amaryne-v1

2. Install PHP and Composer Dependencies
Composer:   https://getcomposer.org/download/ 
PHP: https://www.php.net/manual/en/install.general.php
For LINUX distributions
1. sudo apt update
2. sudo apt install php-fpm php-mysql php-xml php-mbstring php-cli php-curl
3. sudo apt install composer

Install the Composer dependencies for your Yii2 project:

```bash
composer install
```

3. Set Up Environment Variables

Copy the environment settings from the `.env.example` file:

cp .env.example .env
Edit the `.env` file to match your server’s environment, particularly the database connection settings.

4. Set Up the Database

Ensure your database is set up. If you need to create the database, use MySQL or PostgreSQL commands. For example, for MySQL:

mysql -u root -p
CREATE DATABASE your_database;

Then configure the `.env` file with the correct database credentials.

Run the Yii2 migrations to set up your database schema:

php yii migrate

5. Configure Nginx

Create a new Nginx server block for the project project:

sudo nano /etc/nginx/sites-available/amaryne

Add the following Nginx configuration:

```nginx
server {
    listen 80;
    server_name your-domain.com;

    root /path/to/your/project/web;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000; # PHP-FPM
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}

Make sure to replace `/path/to/your/project` with the actual path to your Yii2 project’s `web` directory and `your-domain.com` with your domain or IP address.

6. Enable the Nginx Site Configuration

Create a symbolic link to enable the site configuration in Nginx:

sudo ln -s /etc/nginx/sites-available/your-project /etc/nginx/sites-enabled/

7. Configure PHP-FPM

Ensure that PHP-FPM is set up and running:

1. Open the PHP-FPM configuration file for editing:

   sudo nano /etc/php/7.4/fpm/pool.d/www.conf

2. Make sure the following line is configured to use the `www-data` user (or your server’s user):

   user = www-data
   group = www-data

3. Restart PHP-FPM to apply the changes:

   sudo systemctl restart php7.4-fpm
8. Test Nginx Configuration

Test your Nginx configuration to ensure there are no syntax errors:

sudo nginx -t

If everything is correct, you should see:

nginx: configuration file /etc/nginx/nginx.conf test is successful

9. Restart Nginx

Finally, restart Nginx to apply the configuration changes:

sudo systemctl restart nginx

10. Access Your Yii2 Project

At this point, your Yii2 project should be accessible by visiting your server’s domain or IP address (`http://your-domain.com` or `http://your-server-ip`). You can also access the admin panel at `http://your-domain.com/admin` if configured.

ADDITIONAL CONFIGURATIONS

Enable Pretty URLs (Optional)

To enable pretty URLs, uncomment or add the following lines in the `nginx.conf` file inside your Nginx server block:

location / {
    try_files $uri $uri/ /index.php?$args;
}

Then, configure the **URL manager** in your Yii2 application by modifying the `config/web.php` file:

'urlManager' => [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
],
SET FILE PERMISIONS
Make sure the `runtime` and `web/assets` directories are writable by the web server user:

sudo chown -R www-data:www-data /path/to/your/project/runtime
sudo chown -R www-data:www-data /path/to/your/project/web/assets
