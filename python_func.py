import os

def natsort(l):
    convert = lambda text: int(text) if text.isdigit() else text.lower()
    num_key = lambda key: [ convert(c) for c in re.split('([0-9]+)',key)]
    return sorted(l, key=num_key) # use num_key to every key of l



