fpath=/tmp/

# valuable return data
st=1470882396
et=1470885996

# test again
#st=1472028140
#et=1472039140

interval=10min

cd ~/work/code/soc_portal/soc_portal/trunk/www
#php crontab.php backup_dataapi/starttime/${st}/endtime/${et}/interval/${interval} # get all the data from data-api and write it into mongodb

# test param last_30_days
php crontab.php backup_dataapi/interval/${interval}/last_30_days/1 
