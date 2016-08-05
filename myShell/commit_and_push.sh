#! /bin/bash

cd /home/randylin/work/diary
git add . 
msg=$(date)
git commit -m "${msg}"
git push origin master
