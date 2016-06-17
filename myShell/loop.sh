for((i = 3;i<154;i++));
do 
    echo -e "\n${i}"
    #sleep 1s
    log=$(curl "http://hudong.pl.youku.com/QVideoPlugin/~ajax/shakeJoin?__ap=\{"%"22id_type"%"22:"%"22guid"%"22,"%"22id"%"22:"%"221461235780870${i}Mi9"%"22,"%"22cid"%"22:"%"221"%"22,"%"22limit"%"22:"%"225"%"22\}&__callback=Chat.imJoinCall&1461297888065" -H "Pragma: no-cache" -H "Accept-Encoding: gzip, deflate, sdch" -H "Accept-Language: zh-CN,zh;q=0.8,en;q=0.6,id;q=0.4,ja;q=0.2,nl;q=0.2,zh-TW;q=0.2" -H "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.76 Mobile Safari/537.36" -H "Accept: */*" -H "Referer: http://hudong.pl.youku.com/interact/userlive/get/room/u/UOTg3OTcwMA==" -H "Cookie: PHPSESSID=iljhcc1m5otb4cdgt80j0dvb96; ykss=42b01857a90a92c221cbac79; __ysuid=1461235780870Mi9; __ali=1461235780870u1c; __aliCount=1" -H "Connection: keep-alive" -H "Cache-Control: no-cache" --compressed)
done
