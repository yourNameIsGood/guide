import sys
import os
import re
import time

# TODO : not working well
def remove_tag_a(text):
    text = re.sub("<a*?>",'',text) # does not work fine 
    text = re.sub("</a>",'',text)
    return text

# get those unusual username
def uname(email_prefix):
    if email_prefix == "songchengxiann126" :
        email_prefix="songchengxiann"
    elif  email_prefix == "jack20039" :
        email_prefix="bananamonkey"
    elif  email_prefix == "981136838" :
        email_prefix="981136839"
    elif  email_prefix == "sungoesdown1993" :
        email_prefix="sungoesdown"
    elif  email_prefix == "qingsongxiongooo7" :
        email_prefix="tonystuck"
    elif  email_prefix == "losekarma" :
        email_prefix="yymm008"
    return email_prefix