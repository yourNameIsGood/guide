# -*- coding: UTF-8 -*-
import json
import sys
import time
import os
import account

def bueatify(t):
    t = str(t)
    t = t.encode('ascii','ignore')
    t = "<p>"+t+"</p>"
    return t

def putwrap(email,t):
    divhead = "<h3>"+email+"</h3>"
    divfoot = "<hr>" 
    t = divhead+ t + divfoot
    return t

if __name__ == "__main__":
    acc = account.test_account

    # version 2, going with jsonfile
    htmlfile = "notif_json.html"
    os.system(" > " + htmlfile)
    for a in acc:
        uid = str(a)
        email = acc[a]
        fname = "notif/json_"+email
        with open(fname, 'r') as f:
            datastr = f.read()
        #print datastr
        #for i in datastr:
        #    print i
        #sys.exit(0)
        datalist = json.loads(datastr)
        text = ''
        for data in datalist:
            print data
            print str(data)
            for i in data:
                text += bueatify(i)
                text += bueatify(data[i])
            t = putwrap(email , text)
            os.system(" echo \"" + str(t) + "\" >> " + htmlfile) 

def version1():
    # version 1
    htmlfile = "notif.html"
    os.system(" > " + htmlfile)
    for a in acc:
        uid = str(a)
        email = acc[a]
        with open("notif/"+email, 'r') as f:
            data = f.readlines()
            text = ''
            for i in data:
                text += bueatify(i)
            t = putwrap(email , text)
            os.system(" echo \"" + str(t) + "\" >> " + htmlfile) 

    
