#!/usr/bin/env python

import cx_Oracle
import json

dbc = cx_Oracle.connect("ilm","identity01","PRODI04")
curs = dbc.cursor()
#print "dbc connected"

qs = """select IEPSTNO,IADSURN,IADNAMES,IADIDNO,IEPQUAL,IAIDESC,
            IEPDATE,IEPCER,IEPROW,IEPSEATNUM
    from STUD.IEPQAL, STUD.IADBIO, STUD.IAIQAL 
    where IEPSTNO=IADSTNO
    and IEPQUAL=IAIQUAL and IEPCYR=IAICYR
    and IEPDATE>'01-APR-2018' and IEPDATE<'30-MAY-2018'"""
gradsessions = {}
curs.execute(qs)
for r in curs:
    [sn,surn,names,idno,qual,qdesc,sdate,stime,row,seat] = r
    ssndate = sdate.strftime('%Y%m%d')
    ssn= ssndate+"T"+stime
    if ssn not in gradsessions:
        gradsessions[ssn] = {}
    newrec = [sn,surn,names,qual,qdesc,ssn,row,seat]
    gradsessions[ssn][sn] = newrec

#print gradsessions
print "gradInfo="+json.dumps(gradsessions,indent=4)    
    