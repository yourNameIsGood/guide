import pycurl
import os.path
import time
import account

def post(url,data=None, cookie_path=None, store_cookie=None):
    c = pycurl.Curl()
    c.setopt(c.URL, url)
    c.setopt(pycurl.TIMEOUT, 10)
    c.setopt(pycurl.FOLLOWLOCATION, 1)
    if data:
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

    # login #
    url = "https://coding.net/api/login"
    login_data = "password=403ce753c041efda97535bdfbcf836ea7d20215d&remember_me=false&email="
    acc = account.test_account #TODO replace it
    for a in acc:
        uid = a
        email = acc[a]
        login_data += email
        store_cookie = "cookies"+os.sep+email
    result = post(url, login_data, None, store_cookie)
    print result

    # make task #
    url="https://coding.net/api/user/{email_prefix}/project/project_nim/task"
    for a in acc:
        uid = str(a)
        email = acc[a]
        email_prefix = email[0:email.index("@")]
        if email_prefix=='jack20039':
            email_prefix = 'bananamonkey'
        url = url.replace("{email_prefix}",email_prefix)
        print url
        task_data = "owner_id={uid}&priority=1&content=logAvslogB&description=v&deadline=&labels=&watchers=".replace("{uid}",uid)
        task_data = task_data.replace("{uid}",uid)
        cookie_path = "cookies"+os.sep+email
        #print cookie_path
    result = post(url, task_data, cookie_path)
    print result
 
