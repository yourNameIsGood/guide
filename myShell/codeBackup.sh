msg="$1"
if [ $# -eq 0 ]
    then
        msg=$(date)
fi

################################
# backup soc_portal crontab code  
################################
cp -f ~/work/code/soc_portal/soc_portal/trunk/App/Api/Action/CrontabAction.class.php ~/work/diary/backup/ng/
cp -rf ~/work/code/soc_portal/soc_portal/trunk/App/Api/Action/Dataproxy ~/work/diary/backup/ng/

# back up soc project
cd ~/work/code/soc_portal/soc_portal/trunk/App/Api/
cp -rf Model ~/work/diary/backup/ng/

# back up Project Data api
cd ~/work/code/data_api/trunk/
cp -rf l7datawebapi ~/work/diary/backup/ng/

cd ~/work/diary/
sh /home/randylin/work/code/guide/myShell/commit_and_push.sh "${msg}"

#####################################
#backup some config in Nexusguard
#####################################
cp -f ~/.bashrc ~/work/code/guide/myShell/nxgbak/.bashrc
cp -f ~/.vimrc ~/work/code/guide/myShell/nxgbak/.vimrc
cp -f ~/.tmux.conf ~/work/code/guide/myShell/nxgbak/.tmux.conf

cd ~/work/code/guide/
sh /home/randylin/work/code/guide/myShell/commit_and_push.sh "${msg}"
