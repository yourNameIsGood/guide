
import account

if __name__ == "__main__":
    f = open('today_done_account','r')
    today_done_account = f.readlines()
    f.close()
    acc = account.all_account
    for a in acc:
        uid = str(a)
        email = acc[a]
        if email in today_done_account:
            print str(email) + " is done already "
            continue
        else:
            login_res = job.login(email)
            if not login_res:
                print "login ERROR !!!"
                break;
            topic = "#" + "" + "#"
            con = slogan.pop()
            content = topic  + con
            print email,content
            time.sleep(10)
            mp = job.maopao(email, content) 

