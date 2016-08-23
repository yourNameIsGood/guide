#! /bin/bash
cd /home/randylin/work/diary

git fetch && sleep 20
git merge origin/master && sleep 20

git add . 
msg="$1"
if [ $# -eq 0 ]
    then 
        msg=$(date)
fi
git commit -m "${msg}"
git push origin master
