# backup soc_portal crontab code
cd ~/work/code/soc_portal/soc_portal/trunk/App/Api/Action 
cp -r CrontabAction.class.php ~/work/diary/backup

cd ~/work/code/soc_portal/soc_portal/trunk/App/Api/Action/
cp -rf Dataproxy ~/work/diary/backup/

# backup ~/.bashrc in Nexusguard
d=$(date +%F)
cp -f ~/.bashrc ~/work/diary/backup/.bashrc.from.NexusGuard.$d
