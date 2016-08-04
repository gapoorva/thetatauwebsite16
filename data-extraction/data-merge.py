import json, re

# Full User Data Struct:
# userid
# firstname
# lastname
# roll
# verified
# email
# img
# major
# city
# state
# grad_year
# pledge_class
# nickname
# gender
# phone
# biguserid
# current_title
# current_company
# past_companies list[]
# tht_roles list[]

roles = []

pledgeclass_lookup = {
  1: "Founders",
  4: "Alpha",
  5: "Beta",
  6: "Gamma",
  7: "Delta",
  8: "Epsilon",
  9: "Zeta",
  10: "Eta",
  11: "Theta",
  12: "Iota",
  13: "Kappa",
  14: "Lambda",
  15: "Mu",
  16: "Nu",
  17: "Xi",
  18: "Omicron",
  19: "Pi",
  20: "Rho",
  21: "Sigma",
  22: "Tau",
  23: "Upsilon",
  24: "Phi",
  25: "Chi",
  26: "Psi",
  28: "Omega",
  30: "Gamma Beta",
  31: "Delta Beta",
  32: "Epsilon Beta",
  33: "Beta Gamma",
  34: "Zeta Beta",
  35: "Transfer",
  36: "Eta Beta",
  37: "Theta Beta",
  38: "Iota Beta",
  41: "Kappa Beta",
  42: "Lambda Beta"
}

def addRole(roleid, title, contact=None):
  roles.append({'roleid':roleid, 'title':title, 'contact':contact})

addRole('regent', 'Regent', 'tht-pres@umich.edu')
addRole('viceregent', 'Vice Regent', 'tht-regents@umich.edu')
addRole('scribe', 'Scribe', 'tht-scribe@umich.edu')
addRole('treasurer', 'Treasurer', 'tht-treasurer@umich.edu')
addRole('corsec', 'Corresponding Secretary', 'tht-corsec@umich.edu')
addRole('pledgemaster', 'Pledge Chair', 'tht-pledge@umich.edu')
addRole('rush', 'Rush Chair', 'tht-rush@umich.edu')
addRole('pd', 'Professional Development Chair', 'tht-pd@umich.edu')
addRole('philanthropy', 'Philanthropy Chair', 'tht-philanthropy@umich.edu')
addRole('social', 'Social Chair', 'tht-socialcom@umich.edu')
addRole('fundraising', 'Fundraising Chair', 'tht-funds@umich.edu')
addRole('web', 'Web Chair', 'tht-web.committee@umich.edu')
addRole('advertising', 'Advertising Chair', 'tht-advertising@umich.edu')
addRole('recsports', 'Recreational Sports Chair', 'tht-recsports@umich.edu')
addRole('traditions', 'Traditions Chair', 'tht-traditions@umich.edu')
addRole('historian', 'Historian', 'tht-historian@umich.edu')
addRole('pfcdelgate', 'PFC Delgate', 'tht-pfc@umich.edu')
addRole('apoorva', 'Tht-Apoorva', 'tht-apoorva@umich.edu')
addRole('academic', 'Academic Chair', 'tht-academic@umich.edu')
addRole('bylawreview', 'Bylaw Review Chair', 'tht-bylaws@umich.edu')
addRole('brobonding', 'Brother Bonding Chair', 'tht-brobonding@umich.edu')
addRole('corpspons', 'Corporate Sponsorship Chair', 'tht-corporate@umich.edu')
addRole('housing', 'Housing Chair', 'tht-housing@umich.edu')
addRole('schrader', 'Schrader', 'tht-schrader@umich.edu')
addRole('wellness', 'Wellness Chair', 'tht-wellness@umich.edu')
addRole('pledge', 'Pledge')
addRole('active', 'Active Brother')
addRole('alumni', 'Alumni')
addRole('rushee', 'Rushee')

def getRow():
  row = {}

  row['userid'] = ''
  row['firstname'] = ''
  row['lastname'] = ''
  row['roll'] = 0
  row['verified'] = False
  row['email'] = ''
  row['img'] = 'images/member-profiles/default_profile_img.jpg'
  row['major'] = ''
  row['city'] = ''
  row['state'] = ''
  row['grad_year'] = 0
  row['grad_sem'] = ''
  row['pledge_class'] = ''
  row['nickname'] = ''
  row['gender'] = None
  row['phone'] = ''
  row['biguserid'] = ''
  row['current_title'] = ''
  row['current_company'] = ''
  row['past_companies'] = []
  row['tht_roles'] = []
  return row

# MAIN SCRIPT

femaleNames = open('femaleNames.txt', 'r').read().split("\n")
maleNames = open('maleNames.txt', 'r').read().split("\n")

merged = {}
# Load up the legacy-data
legacy_data = json.loads(open('legacy-data.json', 'r').read())

past_userids = {}

for l in legacy_data:
  row = getRow()
  # resolve userid
  row['userid'] = l['username']
  row['firstname'] = l['first_name']
  row['lastname'] = l['last_name']
  row['roll'] = l['roll']
  row['email'] = l['email_address']
  row['major'] = l['major']
  row['city'] = l['perm_city']
  row['state'] = l['perm_state']

  if row['city'] == '' or row['state'] == '':
    row['city'] = 'Ann Arbor'
    row['state'] = 'MI'

  if l['birthday_year'] != '':
    row['grad_year'] = int(l['birthday_year']) + 22 # make a good guess on their grad years

  row['grad_sem'] = 'Fall' # then just assume their grad semester
  row['pledge_class'] = pledgeclass_lookup[l['pledge_class']]
  row['nickname'] = l['nickname']

  male = row['firstname'] in maleNames
  female = row['firstname'] in femaleNames
  if male ^ female:
    row['gender'] = male
  else:
    # there is ambiguity about gender. Ask the human to make a determination
    row['gender'] = raw_input('Is '+l['first_name']+' '+l['last_name']+' a male?  ') in ['yes', 'y', 'ye', 'Yes', 1, '\n']
  
  phone_string = re.sub(r'\W+', '', l['cell'])
  if phone_string == '':
    phone_string = re.sub(r'\W+', '', l['phone'])
  if len(phone_string) == 10:
    row['phone'] = '('+phone_string[0:3]+')-'+phone_string[4:6]+'-'+phone_string[7:10]

  if l['roll'] > 8 and l['big_id'] != 0: 
    row['biguserid'] = [x['username'] for x in legacy_data if x['userid'] == l['big_id']][0]
  
  row['current_company'] = l['company']
  their_roles = list(set([x for x in l['position2'].split(',') if x != '']))
  for x in their_roles:
    row['tht_roles'].extend([role['roleid'] for role in roles if role['title'] == x])
  merged[row['roll']] = row

# time to do the alumni_survey

alumni_data = json.loads(open('alumni_survey.json', 'r').read())

for alumni in alumni_data:
  rollnum = float(alumni['roll'])
  if rollnum not in merged:
    merged[rollnum] = getRow()
  if alumni['city'] != '' and alumni['state'] != '':
    merged[rollnum]['city'] = alumni['city']
    merged[rollnum]['state'] = alumni['state']
  merged[rollnum]['email'] = alumni['email']
  merged[rollnum]['firstname'], merged[rollnum]['lastname'] = alumni['fullname'].split(' ', 1)
  phone_string = re.sub(r'\W+', '', alumni['phone_number'])
  merged[rollnum]['phone'] = '('+phone_string[0:3]+')-'+phone_string[4:6]+'-'+phone_string[7:10]
  merged[rollnum]['past_companies'] = alumni['past_work'].split(',')

# add in the internal_survey

internal_data = json.loads(open('internal_survey.json', 'r').read())

for active in internal_data:
  rollnum = float(active['roll'])
  if rollnum not in merged:
    merged[rollnum] = getRow()
  merged[rollnum]['userid'] = active['uniquename']
  merged[rollnum]['firstname'] = active['firstname']
  merged[rollnum]['lastname'] = active['lastname']
  merged[rollnum]['roll'] = active['roll']
  merged[rollnum]['email'] = active['email']
  merged[rollnum]['major'] = active['major']
  merged[rollnum]['city'], merged[rollnum]['state'] = "Ann Arbor", "MI"
  if merged[rollnum]['grad_year'] != '' and merged[rollnum]['grad_sem'] != '':
    merged[rollnum]['grad_year'] = int(active['grad_year'])
    merged[rollnum]['grad_sem'] = active['grad_sem']
  merged[rollnum]['pledge_class'] = active['pledge_class']
  merged[rollnum]['nickname'] = active['nickname']
  if merged[rollnum]['gender'] == None:
    male = active['firstname'] in maleNames
    female = active['firstname'] in femaleNames
    if male ^ female:
      merged[rollnum]['gender'] = male
    else:
      # there is ambiguity about gender. Ask the human to make a determination
      merged[rollnum]['gender'] = raw_input('Is '+active['firstname']+' '+active['lastname']+' a male? ') in ['yes', 'y', 'ye', 'Yes', 1, '\n']
  merged[rollnum]['phone'] = active['phone_number']
  merged[rollnum]['biguserid'] = active['biguserid']

fraternity_data = open('fraternity_data.json', 'w')
fraternity_data.write(json.dumps(merged, sort_keys=True, indent=4, separators=(',', ': ')))
fraternity_data.close()

roles_data = open('roles_data.json', 'w')
roles_data.write(json.dumps(roles, sort_keys=True, indent=4, separators=(',',': ')))
roles_data.close()