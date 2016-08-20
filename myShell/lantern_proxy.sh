
cd /c/windows/System32/ && echo inetcpl.cpl | cmd

cd /c/Users/hp/Desktop/ && echo Lantern.lnk | cmd

t=$(date +%s)
echo " "
echo " "
#echo "\r"
echo "http://127.0.0.1:16823/proxy_on.pac?"$t"123456789"
