# This script takes a schema and raw SQL insert statments
# The output is an output file containing a Tab-separated text file dump of the data
# Usage:
#   $ python parse_data.py <schema_file> <data_file> <output_file> [<schema_selection>]
#
# parse_data.py : script
# data_file: 		text file containing a single, valid MySQL insert statement
# output_file: 		text file target for data dump
# schema_selection:	Optional. Text file containing newline-separated list of 
#					columns in schema to keep in dump.

import sys, operator


def caseInsensitiveComparison(s1, s2):
	return s1.lower() == s2.lower();

def customInSet(set_list, element, comp=operator.eq):
	for e in set_list:
		if comp(e, element):
			return True
	return False

def consumeUntil(text, cursor = 0, sentinel = " \n\r\t"):
	end = cursor;
	while end != len(text) and text[end] not in sentinel:
		end += 1;
	return text[cursor:end], end

def getToken(text, cursor = 0, delimiter = " \n\r\t"):
	# go from cursor until (at most) end of text. Find a non-empty substring of text
	# RETURNS tuple (substring, new_cursor)
	start = cursor
	end = cursor
	lim = len(text)
	while end != lim and text[end] in delimiter:
		end += 1
	start = end
	while end != lim and text[end] not in delimiter:
		end += 1
	return text[start:end+1].strip(delimiter), end+1

def getGroup(text, cursor = 0, group_start = '(', group_end = ')'):
	# gets the text inside the next parenthetical group (less the parenthesis themselves)
	groups = 0
	end = cursor
	while end < len(text) and text[end] != group_start:
		end += 1
	groups += 1
	start = end
	end += 1
	while end < len(text) and groups != 0:
		if text[end] == group_start:
			groups += 1;
		elif text[end] == group_end:
			groups -= 1;
		end += 1
	if groups == 0:
		return text[start:end].strip(group_start+group_end), end
	else:
		print "ERROR NO CLOSING BRACE FOUND"
		sys.exit()
def splitMixedDelimData(data, delim):
	# create list out of delimited data
	# ignores delimiting characters within quotes
	l = []
	w = []
	in_quote = False
	quote_type = ""
	i = 0
	while i < len(data):
		if data[i] not in delim or in_quote: # append char
			if in_quote and data[i] == '\\':
				i += 1
			elif in_quote and data[i] == quote_type:
				quote_type = ""
				in_quote = False
			elif not in_quote and data[i] in "'\"`":
				quote_type = data[i]
				in_quote = True
			w.append(data[i])
		else:
			l.append("".join(w).strip("'\"` \n\r\t"+delim))
			w = []
		i += 1
	l.append("".join(w).strip("'\"` \n\t\r"+delim))
	return l



# ----- MAIN SCRIPT -----

data_file = sys.argv[1]
output_file = sys.argv[2]
schema_selection =  sys.argv[3] if len(sys.argv) == 4 else ""

# insert statment:
# INSERT INTO <table_name> 
# 	('column_name' [, ...])
# VALUES
#	('value_string' [, ...])
#	[, ('value_string' [,...])] ;
select = set([])
if len(schema_selection):
	select = set([s.strip(' \n\r\t') for s in open(schema_selection).readlines()])

insert_statement = open(data_file).read()
junk, insrt_cur = getToken(insert_statement) # INSERT
junk, insrt_cur = getToken(insert_statement, insrt_cur) # INTO
table_name, insrt_cur = getToken(insert_statement, insrt_cur) # TABLENAME
table_name = table_name.strip(' `\'"')

# Get the columns definition group
columns_string, insrt_cur = getGroup(insert_statement, insrt_cur, '(', ')')
cols_cur = 0
columns = []

# Obtain individual columns in definition
while cols_cur < len(columns_string):
	junk, cols_cur = consumeUntil(columns_string, cols_cur, '`')
	column, cols_cur = getToken(columns_string, cols_cur, '`')
	if len(column):
		columns.append(column)

# Obtain data entries and filter by 
entries = []
while insrt_cur < len(insert_statement)-1:
	entry, insrt_cur = getGroup(insert_statement, insrt_cur) #split this entry
	tup = splitMixedDelimData(entry, ",")
	tup_filtered = []
	col_index = 0
	for data in tup:
		if columns[col_index] in select or len(select) == 0:
			tup_filtered.append(data)
		col_index += 1
	if len(tup_filtered):
		entries.append(tup_filtered)
	col_index = 0

tf = [c for c in columns if c in select or len(select) == 0]
field_widths = [len(col) for col in tf]
f_index = 0

#field_widths = [[max(field_widths[x],len(entry[x])) for x in range(len(entry))] for entry in entries]
for entry in entries:
	for i in range(len(field_widths)):
		field_widths[i] = max(field_widths[i], len(entry[i]))


ofile = open(output_file, "a")
for i in range(len(tf)):
	if len(tf[i]) < field_widths[i]:
		tf[i] += " "*(field_widths[i] - len(tf[i]))
	ofile.write(tf[i]+"|")
ofile.write("\n")
for entry in entries:
	for i in range(len(entry)):
		if len(entry[i]) < field_widths[i]:
			entry[i] += " "*(field_widths[i] - len(entry[i]))
		ofile.write(entry[i]+"|")
	ofile.write("\n")
ofile.close()
