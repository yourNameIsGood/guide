import json
import account

if __name__ == "__main__":
    acc = account.test_account
    for a in acc:
        uid = str(a)
        email = acc[a]
        with open("notif/"+email, 'r') as f:
            data = f.read()
            data = json.loads(data)
            if 'data' in data:
                data = data['data']
            if 'list' in data:
                data = data['list']
            print data

    
