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
    f = open('update_birthday_log','r')
    filename ='update_birthday_log'
    today_done_account = f.readlines()
    f.close()
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
            log = " job doing " ,email,uid
            os.system(" echo \"" + str(log) + "\" >> " + filename) 
            res = job.update_info(email, uid) 
            print res
            #if res:
            #    os.system(" echo \"" + str(email) + " done.\" >> " + filename) 
            #break
