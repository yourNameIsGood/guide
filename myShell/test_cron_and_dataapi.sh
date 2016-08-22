st=1470882396
et=1470885996
cd ~/work/code/soc_portal/soc_portal/trunk/www
php crontab.php backup_dataapi/starttime/${st}/endtime/${et}/interval/1min
sleep 3
php crontab.php test_cache_backup/data_origin/cloud/spe_gid/5/starttime/${st}/endtime/${et}/interval/1min  > /tmp/cache.json && python -m json.tool /tmp/cache.json > /tmp/2 
curl http://logapi.intra.nexqloud.net:8002/webapi/ -d '''{ "jsonrpc": "2.0", "method": "spe_mitigation_traffic", "params": ["5","", "cloud", 1470882396, 1470885996, "1min"], "id": "aSUjSDRsmws6Fju1"}''' > /tmp/api.json && sleep 1 && python -m json.tool /tmp/api.json > /tmp/1
sed -i 's/\.0//' /tmp/1
vimdiff /tmp/1 /tmp/2 
