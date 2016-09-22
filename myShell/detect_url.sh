for((i = 0;i<10;i++));
do 
    echo -e "\n${i}"
    #sleep 1s
    log=$(curl "http://img0${i}.ishuhui.com")
    echo -e "\n${log}"
done
