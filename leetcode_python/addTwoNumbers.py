def addTwoNumbers(l1, l2):
    n1 = map(str,l1)
    n = ''.join(n1)
    n1 = int(n)
    n2 = map(str,l2)
    n = ''.join(n2)
    n2 = int(n)
    total = n1 + n2
    l = map(int, str(total))
    l = l[::-1]
    print l

l1 = [2,4,3]
l2 = [5,6,4]
addTwoNumbers(l1,l2)
