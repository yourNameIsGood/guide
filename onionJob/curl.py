import pycurl
import os.path
import time

def downl(num, filepath, url):
    url = url + str(num) + ".jpg"
    print('downloading to '+filepath)
    print('url is '+url)
    global failcount
    print('fail count = '+ str(failcount))
    with open(filepath, 'wb') as f:
        c = pycurl.Curl()
        c.setopt(c.URL, url)
        c.setopt(c.WRITEDATA, f)
        c.perform()

        statusCode = c.getinfo(c.RESPONSE_CODE)
        print('status code: %d' % statusCode)
        if(statusCode != 200):
            os.unlink(filepath)
            if(failcount>=2):
                print("Reaching amount of 5 missing target, quit this episode")
                return False
                #os._exit(1)
            failcount += 1
        c.close()
        return True

f = open ("episode",'r')
e = f.read()
f.close()
episode=int(e)

def makeDir(path):
    try:
        os.stat(path)
    except:
        os.mkdir(path)
    

while episode<1702901:
    dirpath='hanghaiwang/'+str(episode)+'/'
    makeDir(dirpath)
    url='http://mhdtestks3.1391.com/migu/171694/'+str(episode)+'/'
    failcount = 0
    num = 1
    while num < 40:
        fp = dirpath + str(num) + ".jpg"
        if os.path.isfile(fp):
            print("existsed:"+fp)
        else:
            ret = downl(num, fp, url)
            if ret == False:
                break;
        num+=1 
        time.sleep(2)
    episode+=1 
    f = open ("episode",'w')
    f.write(str(episode))
    f.close()
