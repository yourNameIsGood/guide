
import account

if __name__ == "__main__":
    f = open('today_done_account','r')
    today_done_account = f.readlines()
    f.close()
    acc = account.all_account
    for i in acc:
        if acc in today_done_account:
            continue

