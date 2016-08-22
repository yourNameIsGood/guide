#! /bin/bash
cd /home/randylin/work/diary

git fetch && sleep 20
git merge origin/master && sleep 20

git add . 
msg=$(date)
git commit -m "${msg}"
git push origin master
