# Initialize all tables in the database
# Can be run to also clear tables to a cleared, empty state

use thetatau_db;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
	userid 			varchar(32) NOT NULL,
	firstname 	varchar(32) NOT NULL,
	lastname 		varchar(32) NOT NULL,
	roll 				int 				NOT NULL,
	verified		boolean			DEFAULT FALSE,
	email				varchar(32) NOT NULL,
	img					varchar(64) DEFAULT 'default_profile_img.png',
	PRIMARY KEY (userid)
);

DROP TABLE IF EXISTS profile;
CREATE TABLE profile (
	userid 				varchar(32) NOT NULL,
	major   			varchar(32),
	city					varchar(32),
	state					varchar(5),
	grad_year			int,
	grad_sem			varchar(32),
	pledge_class	varchar(32),
	nickname			varchar(32),
	gender				boolean,
	phone					varchar(64),
	biguserid			varchar(32),
	PRIMARY KEY (userid)
);

DROP TABLE IF EXISTS jobs;
CREATE TABLE jobs (
	userid 			varchar(32) NOT NULL,
	title				varchar(64) NOT NULL,
	company 		varchar(64) NOT NULL,
	description	varchar(512),
	startT			int DEFAULT 0, 
	endT				int DEFAULT 0,
	link				varchar(256),
	PRIMARY KEY (userid,title,company)
);

DROP TABLE IF EXISTS projects;
CREATE TABLE projects (
	userid 			varchar(32) NOT NULL,
	projectname	varchar(64) NOT NULL,
	description	varchar(512),
	startT			int 				DEFAULT 0,
	endT				int 				DEFAULT 0,
	link				varchar(256),
	PRIMARY KEY (userid,projectname)
);

DROP TABLE IF EXISTS hobbies;
CREATE TABLE hobbies (
	userid 	varchar(32) 	NOT NULL,
	hobby		varchar(128) 	NOT NULL,
	PRIMARY KEY (userid,hobby)
);

DROP TABLE IF EXISTS skills;
CREATE TABLE skills (
	userid 	varchar(32) NOT NULL,
	skill 	varchar(64) NOT NULL,
	PRIMARY KEY (userid,skill)
);

DROP TABLE IF EXISTS thetataucareer;
CREATE TABLE thetataucareer (
	userid 		varchar(32) NOT NULL,
	role			varchar(34) NOT NULL,
	year 			int 				NOT NULL,
	semester	varchar(8)	NOT NULL,
	PRIMARY KEY (userid,role,year,semester)
);

DROP TABLE IF EXISTS social_profile;
CREATE TABLE social_profile (
	userid 			varchar(32)  NOT NULL,
	profiletype	varchar(32)  NOT NULL,
	link				varchar(256) NOT NULL,
	PRIMARY KEY (userid,profiletype)
);

DROP TABLE IF EXISTS auth;
CREATE TABLE auth (
	userid 	varchar(32)  NOT NULL,
	pw 			varchar(128) NOT NULL,
	token		varchar(128) NOT NULL,
	PRIMARY KEY (userid)
);

DROP TABLE IF EXISTS userroles;
CREATE TABLE userroles (
	userid 	varchar(32) NOT NULL,
	roleid	varchar(32) NOT NULL,
	PRIMARY KEY (userid, roleid)
);

DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
	roleid 				varchar(32) NOT NULL,
	title 				varchar(32) NOT NULL,
	contact_email varchar(32), 
	PRIMARY KEY (roleid)
);

DROP TABLE IF EXISTS permissions;
CREATE TABLE permissions (
	roleid 	varchar(32)  	NOT NULL,
	action 	varchar(128) 	NOT NULL,
	kind 		int 		 			NOT NULL,
	PRIMARY KEY (roleid, action)
);

DROP TABLE IF EXISTS mastcontent;
CREATE TABLE mastcontent (
	mastimg	varchar(64) 	NOT NULL,
	quote		varchar(512) 	NOT NULL,
	credit 	varchar(32)		NOT NULL
);

DROP TABLE IF EXISTS lineage;
CREATE TABLE lineage (
	biguserid varchar(32),
	littleuserid varchar(32),
	PRIMARY KEY (biguserid, littleuserid)
)