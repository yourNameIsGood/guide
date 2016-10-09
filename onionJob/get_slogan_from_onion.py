# -*- coding: UTF-8 -*-

import pycurl
import curl
import json
import os
import sys

# topic: 1 ~ 288
def onion_slogan(i):
    url = "https://coding.net/api/tweet_topic/"+str(i)
    res = curl.get(url)
    data = json.loads(res)
    filename = "slogan"
    if data['code'] == 0 :
        user_list = data['data']['user_list']
        for i in user_list:
            slogan = i['slogan']
            if slogan:
                slogan = slogan.encode('utf-8')
                os.system(" echo \" " + str(slogan) + "\" >> " + filename)
        if 'hot_tweet' in data['data']:
            user_list = data['data']['hot_tweet']['comment_list']
            for i in user_list:
                slogan = i['owner']['slogan']
                if slogan:
                    slogan = slogan.encode('utf-8')
                    os.system(" echo \" " + str(slogan) + "\" >> " + filename) 

def firstline():
    url = "http://writingexercises.co.uk/php/firstline.php"
    res = curl.get(url)
    print res
    filename = "firstline"
    os.system(" echo \" " + str(res) + "\" >> " + filename) 
    return res

if __name__ == "__main__":
    for i in range(1,288):
        firstline()
