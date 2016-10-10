# -*- coding: UTF-8 -*-
import time
import curl
import sys
import os
import json

def login():
    url = "http://www.renren.com/ajaxLogin/login?1=1&uniqueTimestamp=201691102787"
    login_data = "email=jack20039%40hotmail.com&icode=&origURL=http%3A%2F%2Fwww.renren.com%2Fhome&domain=renren.com&key_id=1&captcha_type=web_login&password=58532506867d99a25fd614cf63e4a87ab853d2ddd1f5edcf4b9d863f9f719eb5&rkey=d0cf42c2d3d337f9e5d14083f2d52cb2&f=http%253A%252F%252Fwww.renren.com%252F352341419"
    store_path = "cookies/login_renren"
    res = curl.post(url, login_data, None, store_path)
    return res

def get_status(uid="352341419",curpage=0):
    url="http://status.renren.com/GetSomeomeDoingList.do?userId="+str(uid)+"&curpage=0&_jcb=jQuery1111016987169110463962_1476067968057&requestToken=-1018153720&_rtk=8f113362&_=1476067968058"
    url="http://status.renren.com/GetSomeomeDoingList.do?userId="+str(uid)+"&curpage="+str(curpage)+"&requestToken=-1018153720&_rtk=8f113362&_=1476067968058"
    cookie_path = "cookies/login_renren"
    res = curl.get(url,cookie_path)
    res = json.loads(res)
    datalist = []
    if 'doingArray' in res:
        data = res['doingArray']
        for i in data:
            datalist.append(i['content'])
    return datalist

if __name__ == "__main__":
    #res = login()
    uid = "352341419"
    for page in range(10,41):
        res = get_status(uid,page)
        for i in res:
            print i.encode('utf-8')
        time.sleep(3)
    
