fp=/tmp/

# valuable return data
st=1470882396
et=1470885996

# test again
#st=1470882700
#et=1470920000

interval=1min
api=spe_netflow_overview

moid=c9190cfb

cd ~/work/code/soc_portal/soc_portal/trunk/www
php crontab.php backup_dataapi/starttime/${st}/endtime/${et}/interval/${interval} && sleep 1  # get all the data from data-api and store them into mongodb

# query one data from mongodb, using my function
php crontab.php test_cache_backup/api/${api}/moid/${moid}/spe_gid/10/starttime/${st}/endtime/${et}/interval/${interval}  > ${fp}cache.json && python -m json.tool ${fp}cache.json > ${fp}2 

# query one data from data-api
curl http://logapi.intra.nexqloud.net:8002/webapi/ -d '''{ "jsonrpc": "2.0", "method": "'''${api}'''", "params": ["'''${moid}'''","10","", "cloud", '''${st}''','''${et}''', "'''${interval}'''"], "id": "aSUjSDRsmws6Fju1"}''' > ${fp}api.json && sleep 1 && python -m json.tool ${fp}api.json > ${fp}1
# get rid of .0 in return of data-api
sed -i 's/\.0//' ${fp}1
php ~/work/code/guide/myShell/nxgbak/treatapi.php && python -m json.tool ${fp}1 > ${fp}jsontmp && cat ${fp}jsontmp > ${fp}1
vimdiff ${fp}1 ${fp}2 
