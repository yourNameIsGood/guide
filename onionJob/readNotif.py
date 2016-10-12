import json
import account


def bueatify(email,t):
    t = "<p>"+t+"</p>"
    return t

def putwrap(email,t):
    title = "<h3>"+email+"</h3>"
    text = title + t
    return text


if __name__ == "__main__":
    acc = account.test_account
    htmlfile = "notif.html"
    for a in acc:
        uid = str(a)
        email = acc[a]
        with open("notif/"+email, 'r') as f:
            data = f.readlines()
            for i in data:
                text += bueatify(i)
            t = putwrap(title , text)
            os.system(" echo \"" + str(t) + "\" >> " + htmlfile) 

    
