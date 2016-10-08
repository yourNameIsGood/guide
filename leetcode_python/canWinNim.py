def canWinNim(n):
    if n == 4:
        return False
    if n < 4:return True
    if n%3==0:
        x = n/3
        return True if x%2==0 else False
    elif (n-1) % 3==0:
        x = (n-1)/3
        return True if x%2==0 else False
    else:
        x = (n+1)/3
        return True if x%2==0 else False

print(canWinNim(4))

