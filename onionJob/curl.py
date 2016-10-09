import pycurl
import os.path
import time
import account

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


if __name__ == "__main__":

    # login #
    url = "https://coding.net/api/login"
    login_data = "password=403ce753c041efda97535bdfbcf836ea7d20215d&remember_me=false&email="
    acc = account.test_account #TODO replace it
    for a in acc:
        uid = a
        email = acc[a]
        login_data += email
        cookie_path = "cookies"+os.sep+email
    #result = post(url, login_data)
    #print result

    # make task #
    url="https://coding.net/api/user/{email_prefix}/project/project_nim/task"
    for a in acc:
        uid = a
        email = acc[a]
        email_prefix = email[0:email.index("@")]
        url = url.replace("{email_prefix}",email_prefix)
        print url
        cookie_path = "cookies"+os.sep+email
        #print cookie_path
    result = post(url, login_data)
    print result
 
