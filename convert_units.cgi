#!/usr/bin/python

# Naz Taylor
# 9/14/16
# CS 316

import cgi, cgitb

print "Content-type:text/html\r\n\r\n"

form = cgi.FieldStorage()

amount = form.getvalue("amount")
startUnit = form.getvalue("startUnit")
endUnit = form.getvalue("endUnit")
distance = ["kilometers","meters","miles","feet"]
temperature = ["celsius", "fahrenheit", "kelvin"]
time = ["hours", "minutes", "seconds", "days"]
numberCheck = 0
validUnits = distance + temperature + time

# Start of actual page.	
print "<html>"
print "<head>"
print "<title>Results</title>"
print "</head>"
print "<body>"
try:
	amount = float(amount)
except ValueError:
	numberCheck = 1

if (numberCheck == 0 and startUnit in distance and endUnit in distance or numberCheck == 0 and startUnit in temperature and endUnit in temperature or numberCheck == 0 and startUnit in time and endUnit in time):
		
	# Kilometer conversion
	if (startUnit == "kilometers" and endUnit == "meters"):
		amount = amount*1000
	elif (startUnit == "kilometers" and endUnit == "miles"):
		amount = amount*0.621371
	elif (startUnit == "kilometers" and endUnit == "feet"):
		amount = amount*3280.84
	
	# Meter conversion
	elif (startUnit == "meters" and endUnit == "kilometers"):
		amount = amount/1000
	elif (startUnit == "meters" and endUnit == "miles"):
		amount = amount*0.000621371
	elif (startUnit == "meters" and endUnit == "feet"):
		amount = amount*3.28084

	# Mile conversion
	elif (startUnit == "miles" and endUnit == "kilometers"):
		amount = amount*1.60934
	elif (startUnit == "miles" and endUnit == "meters"):
		amount = amount*1609.34
	elif (startUnit == "miles" and endUnit == "feet"):
		amount = amount*5280

	# Foot conversion	
	elif (startUnit == "feet" and endUnit == "kilometers"):
		amount = amount*0.0003048
	elif (startUnit == "feet" and endUnit == "meters"):
		amount = amount*3280.84
	elif (startUnit == "feet" and endUnit == "miles"):
		amount = amount*0.000189394

	# Celsius conversion
	elif (startUnit == "celsius" and endUnit == "fahrenheit"):
		amount = (amount*1.8)+32.0
	elif (startUnit == "celsius" and endUnit == "kelvin"):
		amount = amount+273.15
	
	# Fahrenheit conversion
	elif (startUnit == "fahrenheit" and endUnit == "celsius"):
		amount = (amount-32)/1.8
	elif (startUnit == "fahrenheit" and endUnit == "kelvin"):
		amount = ((amount-32)/1.8)+273.15

	# Kelvin conversion
	elif (startUnit == "kelvin" and endUnit == "celsius"):
		amount = amount-273.15
	elif (startUnit == "kelvin" and endUnit == "fahrenheit"):
		amount = ((amount-273.15)*1.8)+32

	# Hours conversion
	elif (startUnit == "hours" and endUnit == "minutes"):
		amount = amount*60
	elif (startUnit == "hours" and endUnit == "seconds"):
		amount = amount*60*60
	elif (startUnit == "hours" and endUnit == "days"):
		amount = amount/24

	# Minutes conversion	
	elif (startUnit == "minutes" and endUnit == "hours"):
		amount = amount/60
	elif (startUnit == "minutes" and endUnit == "seconds"):
		amount = amount*60
	elif (startUnit == "minutes" and endUnit == "days"):
		amount = amount/60/24
	
	# Seconds conversion
	elif (startUnit == "seconds" and endUnit == "hours"):
		amount = amount/60/60
	elif (startUnit == "seconds" and endUnit == "minutes"):
		amount = amount/60
	elif (startUnit == "seconds" and endUnit == "days"):
		amount = amount/60/60/24
	
	# Days conversion
	elif (startUnit == "days" and endUnit == "hours"):
		amount = amount*24
	elif (startUnit == "days" and endUnit == "minutes"):
		amount = amount*24*60
	elif (startUnit == "days" and endUnit == "seconds"):
		amount = amount*24*60*60

	print "Results:"
	print form["amount"].value, form["startUnit"].value, "is equal to ",amount, form["endUnit"].value,"."
else:
	print "There was an invalid input conversion could not be done."
print "</body>"
print "</html>"

