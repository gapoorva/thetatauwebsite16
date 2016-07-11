import sys, json


def esc(s):
	return s.replace("'","\\'")

inputfile = sys.argv[1]
f = open(inputfile, 'r')

attrfile = sys.argv[2]
a = open(attrfile, 'r')
attrs = [line.strip() for line in a]
a.close()

selectfile = sys.argv[3]
s = open(selectfile, 'r')
select = [line.strip() for line in s]
s.close()

outputfile = sys.argv[4]
o = open(outputfile, 'w')

table = []

for line in f:
	entry = line.split("\t")
	i = 0
	row = {}
	for data in entry:
		if attrs[i] in select:
			try:
				val = int(data)
			except ValueError:
				val = data # just a string
			finally:
				row[attrs[i]] = val 
		i += 1
	table.append(row)


f.close()

# output core user data

sql = "INSERT INTO users (userid, firstname, lastname, roll, email) VALUES \n"
inserts = []

for row in table:
	# row is a dictionary containing a full user profile schema
	entry = [
		esc(row['username']),
		esc(row['first_name']),
		esc(row['last_name']),
		esc(str(row['roll'])),
		esc(row['email_address'])
	]
	inserts.append("('"+"','".join(entry)+"')") 

o.write(sql+",\n".join(inserts)+";\n\n")

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

sql = "INSERT INTO profile (userid, major, city, state, pledge_class, nickname, phone, biguserid) VALUES \n"
inserts = []

for row in table:
	entry = [
		esc(row['username']),
		esc(row['major']),
		esc(row['perm_city']),
		esc(row['perm_state']),
		esc(pledgeclass_lookup[row['pledge_class']]),
		esc(row['nickname']),
		"" if esc(row['cell']) == "--" else esc(row['cell'])
	]
	for searchrow in table:
		if row['big_id'] != 0 and row['big_id'] == searchrow['userid']:
			entry.append(esc(searchrow['username'])) # add a biguserid to the entry
			break
	
	if len(entry) < 8:
		entry.append("0"); # case of no big (founders)

	inserts.append("('"+"','".join(entry)+"')")  

o.write(sql+",\n".join(inserts)+";\n\n")


# print json.dumps(table, sort_keys=True, indent=4, separators=(',', ': '))


o.close()