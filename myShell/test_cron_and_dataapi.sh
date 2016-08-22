st=1470882396
et=1470885996
fpath=/tmp/

cd ~/work/code/soc_portal/soc_portal/trunk/www
php crontab.php backup_dataapi/starttime/${st}/endtime/${et}/interval/1min && sleep 3  # get all the data from data-api and write it into mongodb
# query one data from mongodb
php crontab.php test_cache_backup/data_origin/cloud/spe_gid/5/starttime/${st}/endtime/${et}/interval/1min  > ${fpath}cache.json && python -m json.tool ${fpath}cache.json > ${fpath}2 
# query one data from data-api
curl http://logapi.intra.nexqloud.net:8002/webapi/ -d '''{ "jsonrpc": "2.0", "method": "spe_mitigation_traffic", "params": ["5","", "cloud", '''${st}''','''${et}''', "1min"], "id": "aSUjSDRsmws6Fju1"}''' > ${fpath}api.json && sleep 1 && python -m json.tool ${fpath}api.json > ${fpath}1
# get rid of .0 in return of data-api
sed -i 's/\.0//' ${fpath}1
vimdiff ${fpath}1 ${fpath}2 
