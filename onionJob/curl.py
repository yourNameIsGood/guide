import pycurl
import os.path
import time

def post(url,data=None, cookie_path=None):
    c = pycurl.Curl()
    c.setopt(c.URL, url)
    c.setopt(pycurl.TIMEOUT, 10)
    c.setopt(pycurl.FOLLOWLOCATION, 1)
    c.setopt(c.WRITEDATA, f)
    c.perform()
    statusCode = c.getinfo(c.RESPONSE_CODE)
    c.close()
    if cookie_path:
        if(statusCode != 200):
    return True
