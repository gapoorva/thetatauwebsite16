# Update apt-get packages
sudo apt-get update
# Apache install
sudo apt-get -y install apache2
# Default settings for mysql root user. Setting pw as 'root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
# MySQL install
sudo apt-get -y install mysql-server libapache2-mod-auth-mysql php5-mysql
sudo mysql_install_db
# PHP install
sudo apt-get -y install php5 libapache2-mod-php5 php5-mcrypt
# SSH opens in /var/www where the code is
export HOME=/var/www
