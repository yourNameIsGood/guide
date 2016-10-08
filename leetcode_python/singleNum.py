def single(nums):
    for val in enumerate(nums):
        x = nums[0]
        del(nums[0])
        if x not in nums:
            return x

n = [1,0,1]
print single(n)
