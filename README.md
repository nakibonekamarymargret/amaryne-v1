Here’s a **README.md** template to guide users on deploying your Yii2 project using **Nginx**. This will provide step-by-step instructions for setting up the project on a server with Nginx.

---

```markdown
# Yii2 Project Deployment Guide using Nginx

This guide will help you deploy a Yii2 project on your server using **Nginx**. Follow these steps to get your project running.

## Prerequisites

Before you begin, ensure you have the following installed on your server:

- **PHP 7.4+** (or a compatible version)
- **Nginx**
- **Composer** (for managing PHP dependencies)
- **MySQL/PostgreSQL** (or any other database supported by your project)

### 1. Clone the Repository

Clone your Yii2 project from GitHub to your server:

```bash
git clone https://github.com/your-username/your-repository.git
cd your-repository
```

### 2. Install PHP and Composer Dependencies

Make sure PHP and Composer are installed on your server. You can install them with the following commands (assuming you are using Ubuntu or Debian-based systems):

```bash
sudo apt update
sudo apt install php-fpm php-mysql php-xml php-mbstring php-cli php-curl
sudo apt install composer
```

Install the Composer dependencies for your Yii2 project:

```bash
composer install
```

### 3. Set Up Environment Variables

Copy the environment settings from the `.env.example` file:

```bash
cp .env.example .env
```

Edit the `.env` file to match your server’s environment, particularly the database connection settings.

### 4. Set Up the Database

Ensure your database is set up. If you need to create the database, use MySQL or PostgreSQL commands. For example, for MySQL:

```bash
mysql -u root -p
CREATE DATABASE your_database;
```

Then configure the `.env` file with the correct database credentials.

Run the Yii2 migrations to set up your database schema:

```bash
php yii migrate
```

### 5. Configure Nginx

Create a new Nginx server block for your project:

```bash
sudo nano /etc/nginx/sites-available/your-project
```

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
```

Make sure to replace `/path/to/your/project` with the actual path to your Yii2 project’s `web` directory and `your-domain.com` with your domain or IP address.

### 6. Enable the Nginx Site Configuration

Create a symbolic link to enable the site configuration in Nginx:

```bash
sudo ln -s /etc/nginx/sites-available/your-project /etc/nginx/sites-enabled/
```

### 7. Configure PHP-FPM

Ensure that **PHP-FPM** is set up and running:

1. Open the PHP-FPM configuration file for editing:

   ```bash
   sudo nano /etc/php/7.4/fpm/pool.d/www.conf
   ```

2. Make sure the following line is configured to use the `www-data` user (or your server’s user):

   ```bash
   user = www-data
   group = www-data
   ```

3. Restart PHP-FPM to apply the changes:

   ```bash
   sudo systemctl restart php7.4-fpm
   ```

### 8. Test Nginx Configuration

Test your Nginx configuration to ensure there are no syntax errors:

```bash
sudo nginx -t
```

If everything is correct, you should see:

```bash
nginx: configuration file /etc/nginx/nginx.conf test is successful
```

### 9. Restart Nginx

Finally, restart Nginx to apply the configuration changes:

```bash
sudo systemctl restart nginx
```

### 10. Access Your Yii2 Project

At this point, your Yii2 project should be accessible by visiting your server’s domain or IP address (`http://your-domain.com` or `http://your-server-ip`). You can also access the admin panel at `http://your-domain.com/admin` if configured.

---

## Additional Configuration

### Enable Pretty URLs (Optional)

To enable pretty URLs, uncomment or add the following lines in the `nginx.conf` file inside your Nginx server block:

```nginx
location / {
    try_files $uri $uri/ /index.php?$args;
}
```

Then, configure the **URL manager** in your Yii2 application by modifying the `config/web.php` file:

```php
'urlManager' => [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
],
```

### Set File Permissions

Make sure the `runtime` and `web/assets` directories are writable by the web server user:

```bash
sudo chown -R www-data:www-data /path/to/your/project/runtime
sudo chown -R www-data:www-data /path/to/your/project/web/assets
```

### Set Up SSL (Optional)

To serve your site over HTTPS, you can set up **SSL** using Let's Encrypt or any SSL certificate. For example, using Certbot:

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d your-domain.com
```

---

## Troubleshooting

- **500 Internal Server Error**: Check the Nginx and PHP logs for error details.
  - Nginx logs: `/var/log/nginx/error.log`
  - PHP logs: `/var/log/php7.4-fpm.log`

- **Database Issues**: Double-check your `.env` file for the correct database credentials and ensure the database is set up.

---

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
