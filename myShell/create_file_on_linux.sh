#! /bin/bash

DIR=/home/.${1}
echo $DIR

mkdir $DIR/project&&
echo "#! /bin/bash
cd /home/.$1/project/project_nim/&&
echo hehe >> invite.html&&
git add * &&
git commit -m 'edit invite by $2'&&
git push origin master" > $DIR/project/routine.sh

chmod 777 $DIR/project/routine.sh&&
chmod -R 777 $DIR/project&&
echo "11 6 * * * $DIR/project/routine.sh" > /var/spool/cron/$1&&
/etc/init.d/crond restart

#write .git* files
echo "[user]
	email = $2@$3.com
	name = $2
      [credential]
	helper = store
" > $DIR/.gitconfig
