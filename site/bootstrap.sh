#!/usr/bin/env bash

DBPASSWD=root

echo "mysql-server mysql-server/root_password password $DBPASSWD" | debconf-set-selections
echo "mysql-server mysql-server/root_password_again password $DBPASSWD" | debconf-set-selections


sudo apt-get -y autoremove > /dev/null
sudo apt-get -y update > /dev/null
sudo apt-get -y upgrade > /dev/null
sudo apt-get -y install python-software-properties
sudo add-apt-repository ppa:ondrej/php5
sudo apt-get -y update > /dev/null
sudo apt-get -y install apache2 php5 php5-cli php5-mysql php5-intl php5-gd php5-curl php5-mcrypt php5-xsl
sudo apt-get -y install mysql-server
sudo sed -r -i "s/bind-address.*/bind-address\t= 0.0.0.0/g" /etc/mysql/my.conf
sudo a2enmod rewrite
sudo sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf
sudo a2enmod rewrite

curl -s https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

if ! [ -L /var/www/html ]; then
  rm -rf /var/www/html
  ln -fs /vagrant/web /var/www/html
fi

sudo service mysql restart 
sudo service apache2 restart
