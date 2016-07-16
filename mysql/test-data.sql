insert into roles (roleid, title) values
  ('pledge', 'Pledge'),
  ('active', "Active Brother"),
  ('alumni', "Alumni"),
  ('rush_chair', 'Rush Chair'),
  ('regent', 'Regent');

insert into userroles(userid, roleid) values
  ('jparus', 'active'),
  ('nxlouie', 'active'),
  ('trburch', 'active'),
  ('mmangle', 'active'),
  ('gapoorva', 'alumni'),
  ('jwstriech', 'alumni'),
  ('kjsung', 'alumni'),
  ('botatoes', 'alumni');

insert into users(userid, firstname, lastname, roll, email) values
  ('jparus', 'justin', 'parus', 301, 'jparus@umich.edu'),
  ('nxlouie', 'nathan', 'louie', 301, 'nxlouie@umich.edu'),
  ('trburch', 'travis', 'burch', 301, 'trburch@umich.edu'),
  ('mmangle', 'marie', 'angle', 301, 'mmangle@umich.edu'),
  ('gapoorva', 'apoorva', 'gupta', 301, 'gapoorva@umich.edu'),
  ('jwstriech', 'jesse', 'striecher', 301, 'jwstriech@umich.edu'),
  ('kjsung', 'ki-joo', 'sung', 301, 'kjsung@umich.edu'),
  ('botatoes', 'bo-ying', 'fu', 301, 'botatoes@umich.edu');

insert into profile (userid, major, gender) values
  ('jparus', 'CS', TRUE),
  ('nxlouie', 'CS', TRUE),
  ('trburch', 'ME', TRUE),
  ('mmangle', 'CS', FALSE),
  ('gapoorva', 'E', TRUE),
  ('jwstriech', 'F', TRUE),
  ('kjsung', 'G', FALSE),
  ('botatoes', 'H', FALSE);

insert into jobs (userid, company) values 
  ('jparus', 'tht'),
  ('nxlouie', 'tht'),
  ('nxlouie', 'ge'),
  ('trburch', 'tht'),
  ('mmangle', 'tht'),
  ('mmangle', 'visa'),
  ('mmangle', 'pwc'),
  ('gapoorva', 'tht'),
  ('gapoorva', 'mrm'),
  ('gapoorva', 'cisco'),
  ('gapoorva', 'qualtrics'),
  ('jwstriech', 'tht'),
  ('jwstriech', 'mujo'),
  ('jwstriech', 'stanford'),
  ('kjsung', 'tht'),
  ('kjsung', 'MIT'),
  ('botatoes', 'tht'),
  ('botatoes', 'ms');

insert into lineage (biguserid, littleuserid) values
  ('botatoes', 'nxlouie'),
  ('kjsung', 'mmangle'),
  ('jwstriech', 'gapoorva');

insert into mastcontent (mastimg) values
  ('images/mast/mast1.jpg'),
  ('images/mast/mast2.jpg'),
  ('images/mast/mast3.jpg'),
  ('images/mast/mast4.jpg'),
  ('images/mast/mast5.jpg');