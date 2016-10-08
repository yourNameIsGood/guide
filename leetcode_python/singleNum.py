def single(nums):
    for val in enumerate(nums):
        x = nums[0]
        print "nums"
        print nums
        del(nums[0])
        if x not in nums:
            print str(x) + ' not in !!'
            return x
        else:
            for i in range(0,len(nums)):
                print 'for loop ' + str(i)
                print nums
                print nums[i],x
                if nums[i]==x:
                    del(nums[i])

n = [1,0,1]

def sss(nums):
    for i in nums:
        if nums.count(i)==1:
            return i 
print sss(n)
