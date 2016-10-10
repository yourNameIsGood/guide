# -*- coding: UTF-8 -*-

from StringIO import StringIO
import pycurl
import os.path
import time
# project related
#import account
#import username
#import job

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


def get(url,cookie_path=None):
    storage = StringIO()
    c = pycurl.Curl()
    c.setopt(c.URL, url)
    c.setopt(c.WRITEFUNCTION, storage.write)
    if cookie_path:
        c.setopt(pycurl.COOKIEFILE, cookie_path)
    c.perform()
    c.close()
    content = storage.getvalue()
    return content
