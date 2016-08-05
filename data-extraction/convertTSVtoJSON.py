import json
f = open('internal_survey.tsv', 'r')

fields = [
  "ts",
  "uniquename",
  "firstname",
  "lastname",
  "roll",
  "email",
  "major",
  "grad_year",
  "grad_sem",
  "pledge_class",
  "nickname",
  "phone_number",
  "big_name",
  "biguserid"
]

data = []

i = 0
for line in f:
  m = {}
  row = line.split("\t")
  i = 0
  for c in row:
    m[fields[i]] = c.strip()
    i = i +1
  data.append(m)

o = open('internal_survey.json', 'w')
o.write(json.dumps(data, sort_keys=True, indent=4, separators=(',',': ')))
o.close()