import json, datetime, hashlib

fdata = json.loads(open('fraternity_data.json', 'r').read())
roles = json.loads(open('roles_data.json', 'r').read())

sql = open('fraternity_data_sql_backup_'+str(datetime.date.today())+'.sql', 'w')

sql.write("use thetatau_db;\n")

role_insert_stmt = "INSERT INTO roles (roleid, title, contact_email) VALUES\n"
for role in roles:
  role_insert_stmt += "\t('"+ role["roleid"] +"','"+ role["title"] +"','"+ (role['contact'] or '') +"'),\n"

role_insert_stmt = role_insert_stmt[:-2] + ';\n\n'

sql.write(role_insert_stmt)


users_insert_stmt = "INSERT INTO users (userid, firstname, lastname, roll, verified, email, img) VALUES\n"
for k, p in fdata.iteritems():
  users_insert_stmt += ("\t('"+ 
    p['userid'].strip() +"','"+ 
    p['firstname'].strip().replace("'", "\\'") +"','"+ 
    p['lastname'].strip().replace("'", "\\'") +"','"+ 
    str(p['roll']) +
    "', FALSE, '"+ 
    p['email'] +"','"+
    p['img'] +
    "'),\n")
users_insert_stmt = users_insert_stmt[:-2] + ';\n\n'

sql.write(users_insert_stmt)


def stob(b):
  if b:
    return "TRUE"
  else:
    return "FALSE"

profile_insert_stmt = "INSERT INTO profile (userid, major, city, state, grad_year, grad_sem, pledge_class, nickname, gender, phone, biguserid) VALUES\n"
for k, p in fdata.iteritems():
  profile_insert_stmt += ("\t('"+
    p['userid'].strip() +"','"+
    p['major'].strip() +"','"+
    p['city'].strip() +"','"+
    p['state'].strip() +"',"+
    str(int(p['grad_year'])) +",'"+
    p['grad_sem'].strip() +"','"+
    p['pledge_class'].strip() +"','"+
    p['nickname'].strip().replace("'", "\\'") +"',"+
    stob(p['gender']) +",'"+
    p['phone'].strip() +"','"+
    p['biguserid'].strip() +
    "'),\n")
profile_insert_stmt = profile_insert_stmt[:-2] + ';\n\n'

sql.write(profile_insert_stmt)


jobs_insert_stmt = "INSERT INTO jobs (userid, title, company) VALUES\n"
for k, p in fdata.iteritems():
  if len(p['past_companies']) > 0:
    for c in p['past_companies']:
      if c != '':
        jobs_insert_stmt += "\t('"+ p['userid'].strip() +"','Engineer','"+ c.strip().replace("'", "\\'") +"'),\n"
jobs_insert_stmt = jobs_insert_stmt[:-2] + ";\n\n"

sql.write(jobs_insert_stmt)

thtcareer_insert_stmt = "INSERT INTO thetataucareer (userid, roleid, year, semester) VALUES\n"
for k, p in fdata.iteritems():
  if len(p['tht_roles']) > 0:
    for t in p['tht_roles']:
      if t != '':
        thtcareer_insert_stmt += "\t('"+ p['userid'] +"','"+ t.strip() +"',0,''),\n"
thtcareer_insert_stmt = thtcareer_insert_stmt[:-2] + ';\n\n'

sql.write(thtcareer_insert_stmt)

def sh(input):
  return hashlib.sha256(input).hexdigest()

auth_insert_stmt = "INSERT INTO auth (userid, pw, token) VALUES\n"
for k, p in fdata.iteritems():
  pw = p['userid']+sh(p['userid'])[:10]
  h = sh(sh(pw)+p['userid'])
  auth_insert_stmt += "\t('"+ p['userid'] +"','"+ h +"','NOTLOGGEDIN'),\n"
auth_insert_stmt = auth_insert_stmt[:-2] + ';\n\n'

sql.write(auth_insert_stmt)



ur_insert_stmt = "INSERT INTO userroles (userid, roleid) VALUES\n('rohansawalka','alumni'),\n('csaucier','alumni'),\n('gbhatia','alumni'),\n('ncozen','alumni'),\n('jmartog','alumni'),\n('simsbl','alumni'),\n('harrisri','alumni'),\n('shdeitt','alumni'),\n('lapohl','alumni'),\n('botatoes','alumni'),\n('bjuhrend','alumni'),\n('mantung','active'),\n('alexng','alumni'),\n('cecamp','alumni'),\n('johnkmur','active'),\n('andredan','alumni'),\n('genevich','alumni'),\n('britflah','alumni'),\n('marcmarc','alumni'),\n('sbatch','alumni'),\n('jrilly','alumni'),\n('jwfong','alumni'),\n('rmeggert','alumni'),\n('audosbo','alumni'),\n('waimanl','alumni'),\n('philipw','alumni'),\n('molsofsk','alumni'),\n('gsabo','alumni'),\n('mehtat','alumni'),\n('qzhxfp','alumni'),\n('jpmyers','alumni'),\n('dwallen','alumni'),\n('jordzhu','active'),\n('ccschul','alumni'),\n('pkostas','active'),\n('sanjsub','active'),\n('mgiska','alumni'),\n('jmellent','alumni'),\n('bethgles','alumni'),\n('yuanm','alumni'),\n('xiaobpan','active'),\n('muskr','alumni'),\n('jaiyeong','alumni'),\n('jjbailey08','alumni'),\n('tkem','active'),\n('kunalm','alumni'),\n('haohsu','active'),\n('jasleung','alumni'),\n('aoaoaoa','active'),\n('vidhyasr','active'),\n('stanvi','alumni'),\n('lcpol','alumni'),\n('grailo','alumni'),\n('freemaja','alumni'),\n('khpatel','alumni'),\n('ppoisson','alumni'),\n('kphall','alumni'),\n('kjschill','alumni'),\n('chelseae','alumni'),\n('smpraus','alumni'),\n('cwyckoff','alumni'),\n('tabuesch','alumni'),\n('minnaepc','alumni'),\n('ruansj','active'),\n('maxkotu','alumni'),\n('jlkron','alumni'),\n('jfairchi','alumni'),\n('ranavk','active'),\n('pdoll','alumni'),\n('angraor','alumni'),\n('mjquinn','alumni'),\n('rburkhar','alumni'),\n('emr','alumni'),\n('kgunberg','alumni'),\n('emschmid','alumni'),\n('alancast','alumni'),\n('andyjm','active'),\n('patwan','alumni'),\n('derino','active'),\n('cmbaums','active'),\n('damjohn','alumni'),\n('kimyusun','active'),\n('jgussert','alumni'),\n('jordandr','active'),\n('lowekiah','active'),\n('trburch','active'),\n('megjoki','alumni'),\n('gmcewan','alumni'),\n('nricci','active'),\n('malvikab','alumni'),\n('jtmi','alumni'),\n('esoybay','alumni'),\n('cmillera','alumni'),\n('kfairc','alumni'),\n('mfaibish','alumni'),\n('lcrook','alumni'),\n('aosorio','alumni'),\n('jrswift','alumni'),\n('asenyk','alumni'),\n('stridas','alumni'),\n('clemense','alumni'),\n('rabani','alumni'),\n('cmarti','alumni'),\n('cmuhich','alumni'),\n('jengehle','alumni'),\n('ajfrantz','alumni'),\n('vinnyv','alumni'),\n('milliken','alumni'),\n('reedml','alumni'),\n('maherk','alumni'),\n('ensignlm','alumni'),\n('quanz','alumni'),\n('phalexan','alumni'),\n('katsb','alumni'),\n('maramae','alumni'),\n('nxlouie','active'),\n('michfern','alumni'),\n('altung','active'),\n('emjburns','alumni'),\n('reider','active'),\n('thanav','alumni'),\n('jennyhuh','active'),\n('kwolok','alumni'),\n('rhsunnie','alumni'),\n('jbroggio','alumni'),\n('carteraj','alumni'),\n('troywe','active'),\n('rmeder','alumni'),\n('kriskim','alumni'),\n('annastar','active'),\n('cascook','active'),\n('christag','alumni'),\n('fpenikis','active'),\n('ppreet','active'),\n('ckokenoz','active'),\n('sjdo','active'),\n('dahodge','active'),\n('ralevens','active'),\n('chanmeec','active'),\n('kelemley','alumni'),\n('venugovi','active'),\n('cmmcd','active'),\n('malinare','alumni'),\n('ehorste','alumni'),\n('kert','alumni'),\n('fltr','alumni'),\n('zepeda','alumni'),\n('jyiyang','alumni'),\n('justingk','alumni'),\n('clooney','alumni'),\n('smiatrow','alumni'),\n('furlongl','alumni'),\n('nkizy','alumni'),\n('jsuther','alumni'),\n('tanayn','alumni'),\n('hnpatel','alumni'),\n('kjsand','alumni'),\n('hkast','alumni'),\n('darrint','alumni'),\n('lravindr','alumni'),\n('oriachun','active'),\n('jrnisbet','active'),\n('ntapia','alumni'),\n('avalique','alumni'),\n('stepania','alumni'),\n('rbronson','alumni'),\n('jdaunoravicius','alumni'),\n('jjinnah','alumni'),\n('rileym','alumni'),\n('duanmua','alumni'),\n('jeremylc','active'),\n('ebklouda','alumni'),\n('jessewst','alumni'),\n('atammana','active'),\n('hjihong','active'),\n('meland','alumni'),\n('nabani','alumni'),\n('jmodes','active'),\n('lispag','alumni'),\n('anlevin','active'),\n('adcunha','alumni'),\n('willhorn','active'),\n('gabelok','alumni'),\n('emiupton','active'),\n('gregfi','alumni'),\n('dpinkney','alumni'),\n('kdashair','alumni'),\n('jcgrimm','alumni'),\n('malbrigh','alumni'),\n('stoloreb','alumni'),\n('davemich','alumni'),\n('akluck','alumni'),\n('markalan','alumni'),\n('patelmn','alumni'),\n('hdorer','alumni'),\n('rovinski','alumni'),\n('andybrwn','alumni'),\n('mwinsemi','alumni'),\n('aczubko','alumni'),\n('aavila','alumni'),\n('coolbre','alumni'),\n('madspeck','active'),\n('zachchoi','active'),\n('tmidde','active'),\n('ldemonte','alumni'),\n('emichang','alumni'),\n('jgaulzet','active'),\n('rhchoi','alumni'),\n('mhensel','alumni'),\n('dmcewan','alumni'),\n('tindeck','alumni'),\n('lhmarks','active'),\n('dbzero','alumni'),\n('catpat','alumni'),\n('flynnmo','alumni'),\n('njmontes','alumni'),\n('derekdcs','alumni'),\n('kachou','alumni'),\n('nklam','alumni'),\n('aarthara','alumni'),\n('aagrajek','alumni'),\n('kennyvan','active'),\n('kamalk','alumni'),\n('camphan','active'),\n('caitlincramer12','alumni'),\n('ccprice','alumni'),\n('jbrendel','alumni'),\n('jmolesky','active'),\n('xjsixjag','alumni'),\n('fszalay','alumni'),\n('emstark','alumni'),\n('mikeqin','alumni'),\n('erekn','alumni'),\n('natbrwn','alumni'),\n('jamesbl','alumni'),\n('benfried','alumni'),\n('cdsadler','alumni'),\n('jldolan','alumni'),\n('ebusen','alumni'),\n('mwrod','alumni'),\n('mezen','alumni'),\n('sassyk','alumni'),\n('batchac','alumni'),\n('mfeustel','alumni'),\n('aolosfsk','alumni'),\n('mascione','alumni'),\n('david.moenssen','alumni'),\n('jhschaef','alumni'),\n('dcepeda','alumni'),\n('todd_moilanen','alumni'),\n('sbisgaie','alumni'),\n('hanfan','active'),\n('weitung','alumni'),\n('sungkj','alumni'),\n('mirim','alumni'),\n('dmholt','active'),\n('jelzinga','active'),\n('jiaxin','alumni'),\n('rbiswas','alumni'),\n('dallj','alumni'),\n('samcdev','alumni'),\n('ishaanjs','alumni'),\n('rgappel','alumni'),\n('vward','alumni'),\n('kadann','alumni'),\n('meganelb','alumni'),\n('jgfernan','alumni'),\n('louk','active'),\n('ttristan','active'),\n('dlheard','active'),\n('esoreide','active'),\n('reozdowy','alumni'),\n('rkreiter','alumni'),\n('albanka','alumni'),\n('jimsiang','alumni'),\n('nataaron','alumni'),\n('jumilton','alumni'),\n('thumme','alumni'),\n('jamesrg','alumni'),\n('saraali','alumni'),\n('sylviach','alumni'),\n('ryanbell','alumni'),\n('monticme','alumni'),\n('mwald','active'),\n('domlanni','alumni'),\n('jjwashbu','alumni'),\n('pconlin','alumni'),\n('bkilbour','alumni'),\n('squintan','alumni'),\n('mperaino','alumni'),\n('rauchs','alumni'),\n('cvanitt','alumni'),\n('tketai','alumni'),\n('bsw','alumni'),\n('jrtervol','alumni'),\n('cworthem','alumni'),\n('rsekela1','alumni'),\n('rachneal','active'),\n('afurman','alumni'),\n('zmklav','alumni'),\n('rosephi','alumni'),\n('ryaneth','alumni'),\n('changmar','alumni'),\n('nclay','alumni'),\n('hwangm','alumni'),\n('jmvan','alumni'),\n('ryakee','alumni'),\n('rapete','alumni'),\n('rlakhani','alumni'),\n('ajinebge','alumni'),\n('eaboett','alumni'),\n('siukathr','alumni'),\n('sbarr','alumni'),\n('schremsa','alumni'),\n('mmbowman','alumni'),\n('mjbyom','alumni'),\n('alexkotu','alumni'),\n('rmsherm','alumni'),\n('kofahlum','alumni'),\n('dparrotb','alumni'),\n('jmdonogh','alumni'),\n('gapoorva','active'),\n('lizsgoul','active'),\n('rhchung','active'),\n('anvmat','active'),\n('dingding','alumni'),\n('kunaln','alumni'),\n('srishtip','alumni'),\n('isaak','alumni'),\n('eguder','active'),\n('jparus','active'),\n('libbyej','active'),\n('nkhm','active'),\n('mmangle','active'),\n('adibatra','active'),\n('repatin','active');\n\n"
# ur_insert_stmt = "INSERT INTO userroles (userid, roleid) VALUES\n"
# for k, p in fdata.iteritems():
#   if int(p['roll']) < 263:
#     # alum
#     ur_insert_stmt += "\t('"+ p['userid'] +"','alumni'),\n"
#   else:
#     isalum = raw_input('Is '+p['firstname']+' '+p['lastname']+' an alumni? ') in ['yes', 'y', 'g', 'ye', 'Yes', 1, '\n']
#     if isalum:
#       ur_insert_stmt += "\t('"+ p['userid'] +"','alumni'),\n"
#     else:
#       ur_insert_stmt += "\t('"+ p['userid'] +"','active'),\n"

# ur_insert_stmt = ur_insert_stmt[:-2] + ';\n\n'

sql.write(ur_insert_stmt)



lineage_insert_stmt = "INSERT INTO lineage (biguserid, littleuserid) VALUES\n"
for k, p in fdata.iteritems():
  if p['biguserid'] != "":
    lineage_insert_stmt += "\t('"+ p['biguserid'] +"','"+ p['userid'] +"'),\n"
lineage_insert_stmt = lineage_insert_stmt[:-2] + ';\n\n'

sql.write(lineage_insert_stmt)

sql.close()