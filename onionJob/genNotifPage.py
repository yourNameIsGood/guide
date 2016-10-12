# -*- coding: UTF-8 -*-
import json
import sys
import time
import os
import account

def bueatify(t):
    t = str(t)
    t = "<p>"+t+"</p>"
    return t

def putwrap(email,t):
    divhead = "<h3>"+email+"</h3>"
    divfoot = "<hr>" 
    t = divhead+ t + divfoot
    return t

# version 2, going with jsonfile
def version2():
    acc = account.test_account
    htmlfile = "notif_json.html"
    os.system(" > " + htmlfile)
    for a in acc:
        uid = str(a)
        email = acc[a]
        fname = "notif/json_"+email
        with open(fname, 'r') as f:
            datastr = f.read()
        datalist = json.loads(datastr)
        text = ''
        for data in datalist:
            print data['content']
            for i in data:
                info = str(i) + "=="
                print info
                print data[i]
                with open(htmlfile, 'a+') as f:
                    f.write(info)
                    f.write(data[i])
            #text += bueatify(i)
            #text += bueatify(data[i])
            #t = putwrap(email , text)
            #os.system(" echo \"" + str(t) + "\" >> " + htmlfile) 

# version 1
def version1():
    acc = account.not_duplicated_account
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
    pagescript = '''
    <script>
    p = document.getElementsByTagName('p')
    var reply = '回复了你的冒泡'
    var mention = '中提到了你'
    var recom = '被推荐'
    for ( i in p){ 
        var info=p[i].innerHTML; 
        if(info.indexOf(reply)>0 || info.indexOf(mention)>0 ){
            p[i].style.backgroundColor='#ff0' ;
        }
        if(info.indexOf(recom)>0){
            p[i].style.backgroundColor='#f00' ;
        }
    }
    </script>
    '''
    os.system(" echo \"" + str(pagescript) + "\" >> " + htmlfile) 

if __name__ == "__main__":
    version1()


