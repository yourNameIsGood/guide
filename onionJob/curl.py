import pycurl
import os.path
import time
# project related
import account
import username
import job

def post(url,data=None, cookie_path=None, store_cookie=None):
    c = pycurl.Curl()
    c.setopt(c.URL, url)
    c.setopt(pycurl.TIMEOUT, 10)
    c.setopt(pycurl.FOLLOWLOCATION, 1)
    if not data:
        data = " "
    c.setopt(pycurl.POSTFIELDS, data)
    if store_cookie:
        c.setopt(pycurl.COOKIEJAR, store_cookie)
    if cookie_path:
        c.setopt(pycurl.COOKIEFILE, cookie_path)

    c.perform()
    statusCode = c.getinfo(c.RESPONSE_CODE)
    c.close()
    if(statusCode != 200):
        print 'statusCode' + str(statusCode)
    return True


if __name__ == "__main__":

    acc = account.test_account
    for a in acc:
        uid = str(a)
        email = acc[a]
        login_res = job.login(email)
        if not login_res:
            print "login ERROR !!!"
            break;
        #task = job.create_task(email, uid, 'bring home the shampoo')
        mp = job.like(email, 130033)
