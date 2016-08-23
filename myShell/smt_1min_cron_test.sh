fpath=/tmp/

# valuable return data
st=1470882396
et=1470885996

# test again
#st=1470882700
#et=1470920000

interval=1min

cd ~/work/code/soc_portal/soc_portal/trunk/www
php crontab.php backup_dataapi/api/${api}/starttime/${st}/endtime/${et}/interval/${interval} && sleep 1  # get all the data from data-api and write it into mongodb
