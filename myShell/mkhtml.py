import os.path

def makehtml(fname):
    num = fname.split('.')
    str = num[0]
    str += " <p>"
    str += "<img src=\"" + fname + "\" />"
    str += "</p>\n"
    return str
    
def iterateDir(dp):
    html = ""
    for subdir, dirs, files in os.walk(dp):
        print("iterateDir " + subdir)
        for filename in files:
            if filename.endswith(".jpg"):
                html += makehtml(filename)
    return html

print(os.getcwd())
for subdir,dirs,files in os.walk(os.getcwd()):
    if "hanghaiwang/" in subdir:
        print(subdir)
        dp = subdir + "/"
        html = iterateDir(dp)
        output = dp+"tmp.html"
        f = open(output,'w')
        f.write(html)
        f.close()
        htmlpath = dp + "v.html"
        os.system(" cat " + output + " | sort -g > " + htmlpath)

