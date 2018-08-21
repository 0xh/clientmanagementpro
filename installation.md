# Evolutly

## Server Requirements
- DB : MYSQL
- Server : NGINX and PHP-FPM
- PHP
- Composer
- Server Root Access (for seeding initial data)


## Upload The Whole Folder of Evolutly to Your Server

Use Any FTP program to upload it to your server.

## Installation

-  edit .env
    - Add your Stripe STRIPE_KEY and  STRIPE_SECRET
    - Add Your MYSQL details
    ```
    DB_CONNECTION=127.0.0.1
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE="YOURDBNAME"
    DB_USERNAME=YOURMYSQLUSERNAME
    DB_PASSWORD=YOURMYSQLPASSWORD
    ```
    - Add Your Logo Link Or Simply Add it on Your Public Folder the Image and Link the to the correct path
        - http://evolutly.info/img/yourLOGO.png
    - Add Your Mail Driver and config
    ```
    MAIL_DRIVER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    ```

- configure Nginx Conf or create it and add on your server where nginx is located.
set the proper server name if you need to use other domain name
set proper path of your public directory based on root (if your path is same dont change the example)

```
server {

    listen 80;
    listen [::]:80;
    
    server_name evolutly.info,*.evolutly.info;
    root /var/www/evolutly/public;
    index index.php index.html index.htm;

    location / {
         try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        try_files $uri /index.php =404;
        fastcgi_pass php-upstream;
        fastcgi_index index.php;
        fastcgi_buffers 16 16k;
        fastcgi_buffer_size 32k;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    location /.well-known/acme-challenge/ {
        root /var/www/letsencrypt/;
        log_not_found off;
    }
}

```

## Adding Plans and Company Details

- edit database/seeds/AdminDataSeeder.php (if you need other email or password)
```
User::create([
    'name' => 'admin',
    'username' => 'admin',
    'email' => 'admin@evolutly.info',
    'password' => 'admin'
]);
```

- Edit app/Providers/SparkServiceProvider.php

Edit Your Company Details
```
protected $details = [
        'vendor' => 'Evolutly',
        'product' => 'Task Management App',
        'street' => 'PO Box 111',
        'location' => 'Your Town, NY 12345',
        'phone' => '555-555-5555',
    ];
```
Edit Support Email (if You need to Use Other Email Address)
```
protected $sendSupportEmailsTo = 'admin@evolutly.info';
```

Edit Plan, Note You Should Create this on Your Stripe Account

Note: BASIC_PLAN (first param) is your Plan Name You Want to Show to Public

spark_test_1 this is the plan name in your Stripe Account
Use the same details for price and trials you set on stripe

Lastly you must Declare your Features of the App
```
Spark::plan('BASIC PLAN', 'spark_test_1')
            ->price(10)
            ->trialDays(7)
            ->features([
                'First', 'Second', 'Third'
            ]);
Spark::plan('PRO PLAN', 'spark_test_2')
    ->price(30)
    ->trialDays(7)
    ->features([
        'First', 'Second', 'Third'
    ]);
```

## Seed Your Admin Data

SSH to your Server

```
ssh root@evolutly.info
```
then Type password when prompted.

Note: If You want to use Digital Ocean, just RESET the Password Of ROOT account inside your Dashboard


go to Your Evolytly folder where you place or upload it...

then Inside that folder.

Just Do 

```
php artisan migrate --seed
```

If You Dont Know to Do this...

Second Option.

Use this sql file and import it on your PHPMYADMIN

```
admin.sql
```






