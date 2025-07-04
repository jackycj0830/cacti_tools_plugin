# Installing Cacti 1.x  in Ubuntu/Debian LAMP stack

## Installing the required packages needed for the LAMP stack

```console
apt-get update
apt-get install -y apache2 rrdtool mariadb-server snmp snmpd php8.0 php8.0-mysql php8.0-snmp php8.0-xml php8.0-mbstring php8.0-json php8.0-gd php8.0-gmp php8.0-zip php8.0-ldap php8.0-mbstring
```

### A special note for systems using PHP-FPM

 Prior to starting the setup process of Cacti you should restart the PHP-FPM
 Daemon to rebuild the Cache or you may received a HTTP 500 Error

```console
systemctl restart php-fpm
```

### A special Note on installing Cacti in LXC Containers such as the ones found on Proxmox

It is recommended to create a privileged container  you may need to update your containers config file with

```console
lxc.apparmor.profile: unconfined
```
This will allow for ICMP ping and other functions to work

A tested configuration file like below should be good however tune to your needs/standards

```console
arch: amd64
cores: 2
hostname: cacti
memory: 2048
net0: name=eth0,bridge=vmbr0,firewall=1,hwaddr=mac-id,ip=dhcp,type=v>
ostype: ubuntu
rootfs: local-lvm:vm-110-disk-0,size=8G
swap: 2048
lxc.apparmor.profile: unconfined
```

### Downloading the Cacti software

Once the OS packages are installed, you will need to download the Cacti files
you can do this by using the git command

```console
git clone -b 1.2.x  https://github.com/Cacti/cacti.git
Cloning into 'cacti'...
remote: Enumerating objects: 81, done.
remote: Counting objects: 100% (81/81), done.
remote: Compressing objects: 100% (55/55), done.
remote: Total 59936 (delta 40), reused 51 (delta 26), pack-reused 59855&
Receiving objects: 100% (59936/59936), 76.33 MiB | 1.81 MiB/s, done.
Resolving deltas: 100% (43598/43598), done.
```

After cloning the Cacti repository, move the files into the /var/www/html
directory

```console
mv cacti /var/www/html
```

#### Database Creation

Next we will create a database for the cacti installation to use

```console
mysql -u root -p
CREATE DATABASE cacti DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
CREATE USER 'cactiuser'@'localhost' IDENTIFIED BY 'cactiuser';
GRANT ALL ON cacti.* TO 'cactiuser'@'localhost';
GRANT SELECT ON mysql.time_zone_name TO 'cactiuser'@'localhost';
ALTER DATABASE cacti CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
FLUSH PRIVILEGES;
```

You will now need to pre-populate the database used by cacti

```console
mysql -u root cacti < /var/www/html/cacti/cacti.sql
```

Next, you will need to create the config.php file in /var/www/html/cacti/include

```console
cd /var/www/html/cacti/include
cp config.php.dist config.php
```

Now, edit the config.php file and make sure to change the database settings as
needed to match the below entries (though it is highly recommended to use a
customised username/password combination for security)

```console
$database_type     = 'mysql';
$database_default  = 'cacti';
$database_hostname = 'localhost';
$database_username = 'cactiuser';
$database_password = 'cactiuser';
$database_port     = '3306';
$database_retries  = 5;
$database_ssl      = false;
$database_ssl_key  = '';
```

### Create your cron task file or systemd units file

Starting with Cacti 1.2.16, you have the option to use either the
legacy Crontab entry, or an optional cactid units file and server
to run your Cacti pollers.

For Crontab use, follow the instructions below:

Create and edit `/etc/cron.d/cacti` file.
Make sure to setup the correct path to poller.php

```console
*/5 * * * * apache php /var/www/html/cacti/poller.php &>/dev/null
```

For systemd unit's file install, you will need to modify the
included units file to following your install location
and desired user and group's to run the Cacti poller as.
To complete the task, follow the procedure below:

```console
vim /var/www/html/cacti/service/cactid.service (edit the path)
touch /etc/sysconfig/cactid
cp -p /var/www/html/cacti/service/cactid.service /etc/systemd/system
systemctl enable cactid
systemctl start cactid
systemctl status cactid
```

The systemd units file makes managing a highly available Cacti
setup a bit more convenient.

The system is now ready to finialise the steps by browsing to
[http://serverip/cacti](http://serverip/cacti) to start the cacti initialization
wizard.

### Considerations when using Proxys in front of Cacti (Cacti 1.2.23+)

For optimal security, only specify the HTTP headers that are set by your proxy
software to prevent unauthorized access.
These can be set by editing the following section of config.php

```ini
 * Allow the use of Proxy IPs when searching for client
 * IP to be used
 *
 * This can be set to one of the following:
 *   - false: to use only REMOTE_ADDR
 *   - true: to use all allowed headers (not advised)
 *   - array of one or more the following:
 *'X-Forwarded-For',
 *'X-Client-IP',
 *'X-Real-IP',
 *'X-ProxyUser-Ip',
 *'CF-Connecting-IP',
 *'True-Client-IP',
 *'HTTP_X_FORWARDED',
 *'HTTP_X_FORWARDED_FOR',
 *'HTTP_X_CLUSTER_CLIENT_IP',
 *'HTTP_FORWARDED_FOR',
 *'HTTP_FORWARDED',
 *'HTTP_CLIENT_IP',
 *
 * NOTE: The following will always be checked:
 *'REMOTE_ADDR',
 */
$proxy_headers = null;
```

---
Copyright (c) 2004-2024 The Cacti Group
