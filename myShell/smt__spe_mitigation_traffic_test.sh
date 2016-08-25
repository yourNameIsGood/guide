fpath=/tmp/

# valuable return data
st=1470882396
et=1470885996

# test again
#st=1470882700
#et=1470920000

interval=1min
api=spe_mitigation_traffic

cd ~/work/code/soc_portal/soc_portal/trunk/www
php crontab.php backup_dataapi/api/${api}/starttime/${st}/endtime/${et}/interval/${interval} && sleep 1  # get all the data from data-api and write it into mongodb
# query one data from mongodb
php crontab.php test_cache_backup/api/${api}/data_origin/cloud/spe_gid/5/starttime/${st}/endtime/${et}/interval/${interval}  > ${fpath}cache.json && python -m json.tool ${fpath}cache.json > ${fpath}2 
# query one data from data-api
curl http://logapi.intra.nexqloud.net:8002/webapi/ -d '''{ "jsonrpc": "2.0", "method": "'''${api}'''", "params": ["5","", "cloud", '''${st}''','''${et}''', "'''${interval}'''"], "id": "aSUjSDRsmws6Fju1"}''' > ${fpath}api.json && sleep 1 && python -m json.tool ${fpath}api.json > ${fpath}1
# get rid of .0 in return of data-api
sed -i 's/\.0//' ${fpath}1
php ~/work/code/guide/myShell/nxgbak/treatapi.php && python -m json.tool ${fpath}1 > ${fpath}3 && cat ${fpath} > ${fpath}1
vimdiff ${fpath}1 ${fpath}2 
