# Initialize all tables in the database
# Can be run to also clear tables to a cleared, empty state

use thetatau_db;

delete from users where 1=1;
 

delete from profile where 1=1;
 

delete from jobs where 1=1;
  

delete from projects where 1=1;
 

delete from hobbies where 1=1;
  

delete from skills where 1=1;
  

delete from thetataucareer where 1=1;
  

delete from social_profile where 1=1;
  

delete from auth where 1=1;
  

delete from userroles where 1=1;
  

delete from roles where 1=1;
  

delete from permissions where 1=1;
  

delete from mastcontent where 1=1;


delete from lineage where 1=1;
