from StringIO import StringIO
import pycurl
import curl
import json

if __name__ == "__main__":
    url = "https://coding.net/api/tweet_topic/288"
    res = curl.get(url)
    print res
