class ListNode(object):
    def __init__(self, x):
        self.val = x
        self.next = None

    # Define this to check if it works well
    def myPrint(self):
        if self.val != None:
            print(self.val)
        if self.next:
            self.next.myPrint()

class Solution(object):
    def addTwoNumbers(self, l1, l2):
        result = ListNode(0);
        cur = result;
        while l1 or l2:
           cur.val += self.addTwoNodes(l1, l2)
           if cur.val >= 10:
               cur.val -= 10
               cur.next = ListNode(1)
           else:
               # Check if there is need to make the next node
               if l1 and l1.next or l2 and l2.next:
                   cur.next = ListNode(0)
           cur = cur.next
           if l1:
               l1 = l1.next
           if l2:
               l2 = l2.next
           return result

    def addTwoNodes(self, n1, n2):
        if not n1 and not n2:
            # This cannot happen, ignore it
            None
        if not n1:
            return n2.val
        if not n2:
            return n1.val
        return n1.val + n2.val


if __name__ == "__main__":
    list1 = ListNode(5)
    list1.next = ListNode(8)
    l2 = ListNode(1)
    l2.next = ListNode(3)
    l2.next.next = ListNode(3)
    print(l2.myPrint())
    #print(Solution().addTwoNumbers(list1, l2).myPrint())
