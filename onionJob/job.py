import os
import curl
import username


def login(email):
    url = "https://coding.net/api/login"
    login_data = "password=403ce753c041efda97535bdfbcf836ea7d20215d&remember_me=false&email="
    login_data += email
    store_cookie = "cookies"+os.sep+email
    res = curl.post(url, login_data, None, store_cookie)
    return res

def create_task(email,uid,content='finishlog'):
    url="https://coding.net/api/user/{email_prefix}/project/project_nim/task"
    email_prefix = email[0:email.index("@")]
    email_prefix = username.uname(email_prefix)
    url = url.replace("{email_prefix}",email_prefix)
    task_data = "owner_id={uid}&priority=1&content={content}&description=v&deadline=&labels=&watchers="
    task_data = task_data.replace("{uid}",uid)
    task_data = task_data.replace("{content}",content)
    cookie_path = "cookies"+os.sep+email
    result = curl.post(url, task_data, cookie_path)
    print result
 


