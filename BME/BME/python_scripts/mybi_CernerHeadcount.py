import re
import requests
import csv
import os
import pymysql
import time
import sys
reload(sys)
sys.setdefaultencoding('utf-8')
from xml.sax.saxutils import unescape
from bs4 import BeautifulSoup
from datetime import datetime

def print_lines(selector):  # If selector is first then line without \n. Else with \n
    if selector == 'first_line':
        print("===================================================")
    else:
        print("\n===================================================")

def mybi_login(username, password):

    login = """<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v6="urn://oracle.bi.webservices/v6">
		    <soapenv:Body>
			<v6:logon>
			    <v6:name>""" + username + """</v6:name>
			    <v6:password>""" + password + """</v6:password>
			</v6:logon>
		    </soapenv:Body>
		</soapenv:Envelope>"""  # Login Request String

    options = {'Content-Type': 'application/xml'}  # Request Options
    url = "https://mybi.cerner.com/analytics-ws/saw.dll?SoapImpl=nQSessionService"  # Web Service URL

    try:
        response = requests.post(url = url, headers = options, data = login)  # Response Call
        print(response)
        session_id = re.search('<sawsoap:sessionID xsi:type="xsd:string">(.*)<\/sawsoap:sessionID>', str(response.content)).group(1)  # Extract Session Id
        print("\nLogin successful")  # Print Notification
        return session_id
    except Exception as e:
        print("\nError: " + e)  # Print Error

def get_report(report_path, session_id):

    report_call = """<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v6="urn://oracle.bi.webservices/v6">
			<soapenv:Header/>
			<soapenv:Body>
			    <v6:executeXMLQuery>
				<v6:report>
				    <v6:reportPath>""" + report_path + """</v6:reportPath>
				</v6:report>
				<v6:outputFormat>SAWRowsetSchemaAndData</v6:outputFormat>
				<v6:executionOptions>
				     <v6:async></v6:async>
				    <v6:maxRowsPerPage></v6:maxRowsPerPage>
				</v6:executionOptions>
				<v6:sessionID>""" + session_id + """</v6:sessionID>
			    </v6:executeXMLQuery>
			</soapenv:Body>
		    </soapenv:Envelope>"""  # Report Request String

    options = {'Content-Type': 'application/xml'}  # Request Options
    url = "https://mybi.cerner.com/analytics-ws/saw.dll?SoapImpl=xmlViewService"  # Web Service URL

    try:  # Response Call
        response = requests.post(url = url, headers = options, data = report_call)
        report = unescape(response.content)
        print("\nReport returned sucessfully")
        # print report
        return report
    except Exception as e:
        print('\nError: ' + e)  # Print Error
        return e

def mybi_logout(session_id):

    logout = """<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v6="urn://oracle.bi.webservices/v6">
		    <soapenv:Body>
			<v6:logoff>
			    <v6:sessionID>""" + session_id + """</v6:sessionID>
			</v6:logoff>
		    </soapenv:Body>
		</soapenv:Envelope>"""  # Logout Request String


    options = {'Content-Type': 'application/xml'}  # Reponse Options
    url = "https://mybi.cerner.com/analytics-ws/saw.dll?SoapImpl=nQSessionService"  # Reponse URL

    try: # Reponse Call
        response = requests.post(url = url, headers = options, data = logout)
        print("\nLogoff successful")  # Print Message
    except Exception as e:
        print("\nError: " + e)  # Print Error

def main():

    print_lines('first_line')
    print "# Start time ",datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    timestr = time.strftime("%d %m %Y-%H:%M:%S")
    filename = "headcount_"+timestr+".csv"

    username = 'svc_CTS_BLR_BckpDPM'  # Service Account Username
    password = 'Cerner123'  # Service Account Password
    report_path = '/shared/System/SOAP_CTS_BLR_BckpDPM/Cerner Headcount_1'  # Report Path

    print_lines('text_line')
    session_id = mybi_login(username, password) # Log into MyBi
    print_lines('text_line')
    report = get_report(report_path, session_id)  # Get Report
    print_lines('text_line')
    mybi_logout(session_id)  # Logout of MyBi
    print_lines('text_line')

    _this_dir = os.path.dirname(os.path.abspath(__file__))
    f = open(os.path.join(_this_dir, 'Headcount/temp.xml'), 'w')
    f.write(unescape(report))
    f.close()

    with open(os.path.join(_this_dir, 'Headcount/temp.xml')) as fhandle:
        soup = BeautifulSoup(fhandle.read(), 'xml')
        if __name__ == '__main__':
            with open(os.path.join(_this_dir, 'Headcount/'+filename), 'w') as fhandle:  # Opens a CSV file
                writer = csv.writer(fhandle)  # Write into CSV file
                writer.writerow(('Associate Name', 'Operator ID', 'Assoc Location', 'Status', 'Role','Title','email','Country', 'Manager Name', 'Organization Unit', 'Department', 'Business Unit', 'Executive' ))
                for row in soup.find_all('Row'):
                    writer.writerow((row.Column0.text,
                                    row.Column1.text,
                                    row.Column2.text,
                                    row.Column3.text,
                                    row.Column4.text,
                                    row.Column5.text,
                                    row.Column7.text,
                                    row.Column6.text,
                                    row.Column8.text,
                                    row.Column9.text,
                                    row.Column10.text,
                                    row.Column11.text,
                                    row.Column12.text
                                    ))

    # os.remove(os.path.join(_this_dir, 'Headcount/temp.xml'))  # Remove XML file

    mydb = pymysql.connect(host='localhost', user='root', passwd='cernces6435', db='BME1')  # Database Credentials
    cursor = mydb.cursor()
    cursor.execute("truncate Head_Count;")
    csv_data=csv.reader(file(os.path.join(_this_dir, 'Headcount/'+filename)))  # Open CSV file
    # csv_data=csv.reader(file(os.path.join(_this_dir, 'Headcount/headcount_10 11 2018-04:10:06.csv')))  # Open required csv file
    next(csv_data)  # skip the header from CSV
    for row in csv_data:  # Push the records into the database table, one row at a time.
        cursor.execute('Insert into Head_Count (`Associate_Name`, `Associate_Id`, `Associate_Location`, `Status`, `Role`, `Title`, `Global_Assignment`, `Country`, `Manager_Name`, `Organization_Unit`, `Department`, `Business_Unit`, `Executive`) values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)', row)
    # cursor.execute("update  `Head_Count` set upload=NOW()")
    cursor.execute("UPDATE Head_Count SET Country='India' where Country='IND'")    
    cursor.execute("UPDATE Head_Count SET Country='Romania' where Country='ROU'")    
    cursor.execute("UPDATE Head_Count SET Country='Sweden' where Country='SWE'")    
    cursor.execute("UPDATE Head_Count SET Country='Australia' where Country='AUS'")    
    cursor.execute("UPDATE Head_Count SET Country='United Arab Emirates' where Country='ARE'")    
    cursor.execute("UPDATE Head_Count SET Country='Malaysia' where Country='MYS'")    
    cursor.execute("UPDATE Head_Count SET Country='Saudi Arabia' where Country='SAU'")    
    cursor.execute("UPDATE Head_Count SET Country='United Kingdom' where Country='GBR'")    
    cursor.execute("UPDATE Head_Count SET Country='Lebanon' where Country='LBN'")    
    cursor.execute("UPDATE Head_Count SET Country='Norway' where Country='NOR'")    
    cursor.execute("UPDATE Head_Count SET Country='France' where Country='FRA'")
    cursor.execute("UPDATE Head_Count SET Country='Germany' where Country='DEU'")
    cursor.execute("UPDATE Head_Count SET Country='Spain' where Country='ESP'")
    cursor.execute("UPDATE Head_Count SET Country='Egypt' where Country='EGY'")
    cursor.execute("UPDATE Head_Count SET Country='Brazil' where Country='BRA'")
    cursor.execute("UPDATE Head_Count SET Country='Canada' where Country='CAN'")
    cursor.execute("UPDATE Head_Count SET Country='Austria' where Country='AUT'")
    cursor.execute("UPDATE Head_Count SET Country='Qatar' where Country='QAT'")
    cursor.execute("UPDATE Head_Count SET Country='Portugal' where Country='PRT'")
    cursor.execute("UPDATE Head_Count SET Country='Italy' where Country='ITA'")
    cursor.execute("UPDATE Head_Count SET Country='Ireland' where Country='IRL'")
    cursor.execute("UPDATE Head_Count SET Country='Netherlands' where Country='NLD'")
    cursor.execute("UPDATE Head_Count SET Country='Slovakia' where Country='SVK'")
    cursor.execute("UPDATE Head_Count SET Country='South Africa' where Country='ZAF'")
    cursor.execute("UPDATE Head_Count SET Country='Finland' where Country='FIN'")
    cursor.execute("UPDATE Head_Count SET Country='Mexico' where Country='MEX'")
    cursor.execute("UPDATE Head_Count SET Country='Belgium' where Country='BEL'")
    cursor.execute("UPDATE Head_Count SET Country='Mauritius' where Country='MUS'")    
    cursor.execute("UPDATE Head_Count SET Country='Singapore' where Country='SGP'")    
    cursor.execute("UPDATE Head_Count SET Country='United Kingdom' where Country='ENG'")    
    cursor.execute("UPDATE Head_Count SET Country='Afghanistan' where Country='AFG'")    
    cursor.execute("UPDATE Head_Count SET Country='Chile' where Country='CHL'")    
    cursor.execute("UPDATE Head_Count SET Country='Argentina' where Country='ARG'")    
    cursor.execute("UPDATE Head_Count SET Country='United States' where Country='USA'")    
    cursor.execute("UPDATE Head_Count SET Country='India' WHERE Country='IND'")
    cursor.execute("UPDATE `Head_Count` SET `Associate_Location`='GTP Tower A > Floor 4' where `Associate_Location` LIKE '%Global Technology Park Tower A > Floor 4%'")
    cursor.execute("UPDATE `Head_Count` SET `Associate_Location`='GTP Tower A > Floor 3' where `Associate_Location` LIKE '%Global Technology Park Tower A > Floor 3%'")
    cursor.execute("UPDATE `Head_Count` SET `Associate_Location`='Bangalore, India - Northgate > Floor 3' where `Associate_Location`='Bangalore, India - North Gate > Floor 3'")
    cursor.execute("UPDATE `Head_Count` SET `Associate_Location`='Bangalore, India - Northgate > Floor 4' where `Associate_Location`='Bangalore, India - North Gate > Floor 4'")
    cursor.execute("UPDATE `Head_Count` SET `Associate_Location`='Bangalore, India - Northgate > Floor 1' where `Associate_Location`='Bangalore, India - North Gate > Floor 1'")
    cursor.execute("UPDATE `Head_Count` SET `Associate_Location`='Bangalore, India - Northgate > Floor 2' where `Associate_Location`='Bangalore, India - North Gate > Floor 2'")
    cursor.execute("UPDATE `Head_Count` SET `Associate_Location`='Bangalore, India - Northgate > Floor 5' where `Associate_Location`='Bangalore, India - North Gate > Floor 5'")
    cursor.execute("UPDATE `Head_Count` SET Country='India' WHERE Country='IND'")
    cursor.execute("UPDATE `Head_Count` SET Country='India' WHERE `Associate_Location` LIKE '%H-2%'")
    cursor.execute("UPDATE `Head_Count` SET Country='India' WHERE `Associate_Location` LIKE '%C-2%'")
    cursor.execute("UPDATE `Head_Count` SET Country='India' WHERE `Associate_Location` LIKE '%G-3%'")
    cursor.execute("UPDATE `Head_Count` SET Country='India' WHERE `Associate_Location` LIKE '%GTP%'")
    cursor.execute("UPDATE `Head_Count` SET Country='India' WHERE `Associate_Location` LIKE '%MBBP%'")
    mydb.commit()  # Commit Database Transactions
    cursor.close()  # Close the Database Connection
    print "Done"
    print "# End time ",datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    print "########################################################"
main()
