import json
import sys
import time
import os
import account

def bueatify(t):
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
        print fname
        sys.exit(0)
        with open(fname, 'r') as f:
            data = f.read
        print data
        #data = json.loads(data)
        text = ''
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

    
