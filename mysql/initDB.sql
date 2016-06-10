# Run the following SQL to initialize a database with required users.
# Meant to run on fresh install of mysql
# aka in case of system failure OR
# for Vagrant Provisioning scripts.

# Run as root or another authorized user:

# DO NOT RUN ON SITEGROUND OR HOSTING SERVICE. USE cPANEL INSTEAD

# create a database with the same name as the production one
DROP DATABASE IF EXISTS thetatau_db;
CREATE DATABASE thetatau_db;

# create a user with the same name as the production one
DROP USER IF EXISTS 'thetatau_user'@'localhost';
CREATE USER 'thetatau_user'@'localhost' IDENTIFIED BY 'mysql';
# user does whatever in this database, but can't make other dbs or query them
GRANT ALL PRIVILEGES ON thetatau_db . * TO 'thetatau_user'@'localhost';
# tells MySQL to reload privilege configs we just created
FLUSH PRIVILEGES;
