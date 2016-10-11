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
    acc = account.all_account
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
            log = "\n\n job doing " ,email,uid
            print log
            #os.system(" echo \"" + str(log) + "\" >> " + filename) 
            res = job.update_info(email, uid) 
            time.sleep(2)
            if res:
                os.system(" echo \"" + str(email) + "\" >> " + filename) 
            #break
