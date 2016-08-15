
cd /c/windows/System32/ && echo inetcpl.cpl | cmd


t=$(date +%s)
echo "http://127.0.0.1:16823/proxy_on.pac?"$t"123456789"
