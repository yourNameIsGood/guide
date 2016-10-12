import json
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

    
