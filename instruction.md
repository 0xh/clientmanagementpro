# Evoltly Instruction For Existing Server

## SSH to your DROPLET

### Reset Your ROOT

RESET ROOT password on Your Droplet , check your email

### SSH to Evolutly Server

```
ssh root@evolutly.info
```

### Go to Evolutly Folder
```
cd /var/www/evolutly
```

### go to evolutly root folder


## Resetting Docker Containers

If you are login as ROOT
then just change directory to

```
cd /var/www/laradock
```

check all current containers running

```
docker ps

```

if status is exited...

you may want to Reset the Containers

Usually if you lack memory ,for mysql

Minimum memory required is 2GB if below you may experience , 

that sometimes mysql just exited or stop...



To Reset just type

```
docker-compose down
```

then Re-Up necessary Containers 

```
docker-compose up -d nginx mysql redis phpmyadmin
```

## Using PHPMYAdmin

just go to evolutly.info:8080 and login using the following credentials

```
server: mysql
username: evolutly
password: 1BillionDollarCode
```

## Login in TO Your Main Site As Admin
http://owner.evolutly.info/login

```
username: owner@evolutly.info
password:secret
```