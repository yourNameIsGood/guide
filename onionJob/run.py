# -*- coding: UTF-8 -*-

import pycurl
import os.path
import time
import sys
# project related
import account
import username
import job


if __name__ == "__main__":
    f = open("uniq_slogan",'r')
    slogan = f.readlines()
    print (slogan)
    acc = account.not_duplicated_account
    sys.exit(0)
    for a in acc:
        uid = str(a)
        email = acc[a]
        login_res = job.login(email)
        if not login_res:
            print "login ERROR !!!"
            break;
        topic = "#" + "为了码币" + "#"
        content = topic  + "happy eating lunch"
        #mp = job.maopao(email, content)
