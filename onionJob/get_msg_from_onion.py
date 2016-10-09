from StringIO import StringIO
import pycurl
import curl
import json

if __name__ == "__main__":
    #for i in range(1,290):
    for i in range(1,3):
        url = "https://coding.net/api/tweet_topic/"+str(i)
        res = curl.get(url)
        data = json.loads(res)
        if data.code == 0 :
            user_list = data['data']['user_list']
            filename = "slogan"
            for i in user_list:
                slogan = i['slogan']
                if slogan:
                    os.system(" echo \" " + slogan + "\" >> " + filename)
