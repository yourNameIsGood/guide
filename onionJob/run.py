# -*- coding: UTF-8 -*-

import pycurl
import os.path
import time
import sys
import random
# project related
import account
import helper
import job

def notif():
    text = "<a href=\"https://coding.net/u/bananamonkey\">bananamonkey</a> 回复了你的冒泡 <a href=\"https://coding.net/u/fangtianshuu/pp/130331\">我要有好的身体 然后学会照顾你</a>：照顾谁？"
    res = helper.remove_tag_a(text)
    print res

def update_info():
    f = open('done_log/today_done_birthday','r')
    filename ='done_log/today_done_birthday'
    today_done_account = f.readlines()
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
            res = job.update_info(email, uid) 
            time.sleep(2)
            if res:
                os.system(" echo \"" + str(email) + "\" >> " + filename) 
            #goes on and on until all accounts are done

def upload_avatar():
    f = open('done_log/today_done_avatar','r')
    filename ='done_log/today_done_avatar'
    today_done_account = f.readlines()
    f.close()
    f = open("DB_avatar_url",'r')
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

def maopao():
    f = open('done_log/today_done_account','r')
    filename ='done_log/today_done_account'
    today_done_account = f.readlines()
    f.close()
    f = open("DB_all_msg",'r')
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


if __name__ == "__main__":
    if len(sys.argv)<2:
        print 'nothing happen'
        sys.exit(0)
    func = sys.argv[1]
    eval(func+'()')
