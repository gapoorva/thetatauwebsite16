# Update apt-get packages
sudo apt-get update
# Apache install
echo "vagrant-provisioning:[Installing Apache2]"
sudo apt-get -y install apache2
# Default settings for mysql root user. Setting pw as 'root'
echo "vagrant-provisioning:[Installing MySQL]"
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
# MySQL install
sudo apt-get -y install mysql-server libapache2-mod-auth-mysql php5-mysql
echo "vagrant-provisioning:[Configuring MySQL]"
sudo mysql_install_db
# PHP install
echo "vagrant-provisioning:[Installing PHP5]"
sudo apt-get -y install php5 libapache2-mod-php5 php5-mcrypt
# SSH opens in /var/www where the code is
export HOME=/var/www

echo "vagrant-provisioning:[Initiallizing MySQL]"
# Load mysql permissions into file so we don't have to provide them
#echo mysql-startup-credentials > ~/.my.cnf
mysql < $HOME/mysql/initDB.sql
mysql < $HOME/mysql/initTables.sql