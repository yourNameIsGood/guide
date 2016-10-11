# -*- coding: UTF-8 -*-
import os
import curl
import username
import random
from random import randint

def update_info(email,uid):
    tagslist =random.sample(xrange(1,77),randint(1,11))
    tags = ','.join(tagslist)
    return tags
    
    

def upload_avatar(email,avaurl):
    avadata = "avatar=http://"+avaurl+"?imageMogr2/auto-orient/format/jpeg/crop/!128x128a0a0"
    url = "https://coding.net/api/user/updateavatar"
    cookie_path = "cookies"+os.sep+email
    result = curl.post(url, avadata, cookie_path)
    return result

def maopao(email,content="hello from the other side"):
    maopao_data = "content="+content
    url = "https://coding.net/api/tweet"
    cookie_path = "cookies"+os.sep+email
    result = curl.post(url, maopao_data, cookie_path)
    return result
    
def like(email, like_id=99999):
    url = "https://coding.net/api/tweet/"+str(like_id)+"/like"
    cookie_path = "cookies"+os.sep+email
    result = curl.post(url, None, cookie_path)
    return result

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
    return result
