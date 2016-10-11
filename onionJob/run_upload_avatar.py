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
    f = open('upload_ava_log','r')
    filename ='upload_ava_log'
    today_done_account = f.readlines()
    f.close()
    f = open("avatar_url",'r')
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
            con = random.choice(slogan)
            content = con
            print "\n job doing " , email,content
            res = job.upload_avatar(email, content) 
            if res:
                os.system(" echo \"" + str(email) + "\" >> " + filename) 
            break
