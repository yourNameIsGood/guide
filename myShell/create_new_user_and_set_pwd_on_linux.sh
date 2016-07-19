#! /bin/bash

# sh create.sh Dick

/usr/sbin/useradd -d /home/.$1 $1&&
( echo "$1"
sleep 1
echo "$1")|passwd $1
