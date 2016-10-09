# -*- coding: UTF-8 -*-

import pycurl
import os.path
import time
import sys
import random
# project related
import account
import username
import job

if __name__ == "__main__":
    f = open('today_done_account','r')
    filename ='today_done_account'
    today_done_account = f.readlines()
    f.close()
    f = open("uniq_slogan",'r')
    slogan = f.readlines()
    f.close() 
    acc = account.not_duplicated_account
    for a in acc:
        uid = str(a)
        email = acc[a]
        if email+"\n" in today_done_account:
            print str(email) + " is done already "
            continue
        else:
            login_res = job.login(email)
            if not login_res:
                print "login ERROR !!!"
                break;
            topic = ""
            topic = ("#"+topic+"#") if topic else topic
            con = random.choice(slogan)#slogan.pop()
            content = topic  + con
            print "\n job doing " , email,content
            mp = job.maopao(email, content) 
            if mp:
                os.system(" echo \"" + str(email) + "\" >> " + filename) 
            break
