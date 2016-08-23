# backup soc_portal crontab code
cd ~/work/code/soc_portal/soc_portal/trunk/App/Api/Action 
cp -f CrontabAction.class.php ~/work/diary/backup/ng/
#cd ~/work/code/soc_portal/soc_portal/trunk/App/Api/Action/
cp -rf Dataproxy ~/work/diary/backup/ng/

cd ~/work/code/soc_portal/soc_portal/trunk/App/Api/
cp -rf Model ~/work/diary/backup/ng/

# backup ~/.bashrc in Nexusguard
#d=$(date +%F)
cp -f ~/.bashrc ~/work/diary/backup/ng/.bashrc.from.NexusGuard

sh /home/randylin/work/code/guide/myShell/commit_and_push.sh "$1"
