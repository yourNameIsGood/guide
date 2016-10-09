import pycurl
import os.path
import time

def post(url,data=None, cookie_path=None):
    c = pycurl.Curl()
    c.setopt(c.URL, url)
    c.setopt(pycurl.TIMEOUT, 10)
    c.setopt(pycurl.FOLLOWLOCATION, 1)
    if data:
        c.setopt(pycurl.POSTFIELDS, data)
    if cookie_path:
        c.setopt(pycurl.COOKIEJAR, cookie_path)

    c.perform()
    statusCode = c.getinfo(c.RESPONSE_CODE)
    c.close()
    if(statusCode != 200):
        print 'statusCode' + str(statusCode)
    return True
