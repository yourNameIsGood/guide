account[161896]=3034663105@qq.com
account[195059]=losekarma@163.com
account[42615]=jack20039@hotmail.com
account[143929]=keviiiooo3@163.com
account[136034]=songchengxiann126@126.com
account[150875]=bluemarkery@163.com
account[150466]=jamesunter@163.com
account[139769]=qingsongxiongooo7@163.com
account[149388]=ottoducker@163.com
account[149326]=keviiiooo11@163.com
account[136367]=suzhelinn@126.com
account[136245]=songchuanshengg@126.com
account[146660]=keviiiooo10@163.com
account[136356]=yangzhongweii@126.com
account[136247]=liyunjiann@126.com
account[136019]=fujieyu126@126.com
account[114969]=yanhuashei@163.com
account[145223]=keviiiooo9@163.com
account[126136]=kxiaotianshik@tom.com
account[126134]=yesstate@tom.com
account[126366]=nihaonong@126.com
account[125615]=no_station@163.com
account[144846]=keviiiooo8@163.com
account[144595]=keviiiooo6@163.com
account[144594]=keviiiooo7@163.com
account[143961]=keviiiooo5@163.com
account[143928]=keviiiooo2@163.com
account[143931]=keviiiooo4@163.com
account[143906]=keviiiooo1@163.com
account[114983]=sungoesdown1993@163.com
account[114678]=desktop24699252@163.com
account[112988]=490578183@qq.com
account[139756]=qingsongxiongooo3@163.com
account[139748]=xiaofeixiaooo2@163.com
account[139767]=qingsongxiongooo6@163.com
account[139753]=qingsongxiongooo1@163.com
account[126224]=2816845621@qq.com
account[139765]=qingsongxiongooo5@163.com
account[139746]=xiaofeixiaooo1@163.com
account[139757]=qingsongxiongooo4@163.com
account[139754]=qingsongxiongooo2@163.com
account[139749]=xiaofeixiaooo3@163.com
account[128432]=niheishima@yeah.net
account[128431]=maxiaolinibang@163.com
account[114677]=desktop24699251@163.com
account[129396]=fulibin123@126.com
account[137805]=langyabangooo@163.com
account[137790]=majijiooo@163.com
account[137800]=majijiooo4@163.com
account[137806]=weisijieooo@163.com
account[137799]=majijiooo3@163.com
account[137794]=majijiooo2@163.com
account[137791]=majijiooo1@163.com
account[137801]=majijiooo5@163.com
account[137802]=majijiooo6@163.com
account[137126]=meichangsuu@126.com
account[137132]=xieyuyuyu@126.com
account[137134]=xiehouyee@126.com
account[136912]=xiaojinghuann@126.com
account[136361]=xieyanjiee@126.com
account[136760]=fangtianshuu@126.com
account[136763]=wangzhizhii@126.com
account[137136]=huaqianguuu@126.com
account[136242]=lujunyee@126.com
account[136352]=wanghaichuann@126.com
account[136103]=xieyuyueee@126.com
account[136038]=shijingshann@126.com
account[136086]=zhanggongzhuu@126.com
account[136029]=weiguoqiangg126@126.com
account[136079]=huangxiaomingm@126.com
account[126365]=nishuowoniyiqi@163.com
account[126152]=havebeenforlove@tom.com
account[126141]=fenzhongdeganjue@tom.com
account[126315]=nimahonghei@163.com
account[126214]=heinimahong@qq.com
account[126314]=nationyousuck@163.com
account[126213]=1102024015@qq.com
account[126156]=jjjjackjjj@tom.com
account[126161]=hahaonlylove@tom.com
account[126163]=huangwode@tom.com
account[126222]=hongnimahei@qq.com
account[125250]=yuchen2078@sina.com
account[114671]=981136838@qq.com
account[114680]=desktop24699255@163.com
account[114986]=one_stepclozer@163.com
account[114681]=desktop24699256@163.com
account[114825]=desktop24699254@163.com
account[114979]=hybirylilun@163.com
account[112990]=1075300136@qq.com
account[114971]=shijieyuandi@163.com

today=$(date +%Y-%m-%d)
for i in "${!account[@]}";
do
    path="/home/linzhen/mine/coding.net/script/cookies/"
    script_path="/home/linzhen/mine/coding.net/script/"
    email="${account[$i]}"
    email_prefix="${email%@*}"
    if [[ $email_prefix == "songchengxiann126" ]];
    then
        email_prefix="songchengxiann"
    elif [[ $email_prefix == "jack20039" ]];
    then 
        email_prefix="bananamonkey"
    elif [[ $email_prefix == "981136838" ]];
    then 
        email_prefix="981136839"
    elif [[ $email_prefix == "sungoesdown1993" ]];
    then 
        email_prefix="sungoesdown"
    elif [[ $email_prefix == "qingsongxiongooo7" ]];
    then 
        email_prefix="tonystuck"
    elif [[ $email_prefix == "losekarma" ]];
    then 
        email_prefix="yymm008"
    fi
    curl -D ${path}cookie_$email "https://coding.net/api/login" --data "password=403ce753c041efda97535bdfbcf836ea7d20215d&remember_me=false&email=$email" --compressed
    sleep 1s
    echo -e "\nowner_id:$i"
    echo -e "\nemail:$email"
    echo -e "\nemail_prefix:$email_prefix"

    echo -e "\ncreate task"
    curl --cookie ${path}cookie_$email "https://coding.net/api/user/${email_prefix}/project/project_nim/task" --data "owner_id=${i}&priority=1&content=heheh&description=v&deadline=&labels=&watchers=" --compressed
    echo -e "\n new a branch"
    echo ${path}cookie_$email
    echo ${email_prefix}
    new_branch_name=$(date +%Y%m%d%s)
    echo ${new_branch_name}
    curl --cookie ${path}cookie_$email "https://coding.net/api/user/${email_prefix}/project/project_nim/git/branches/create" --data "branch_name=${new_branch_name}" --compressed
    echo -e "\nget last commit id"
    result=$(curl --cookie ${path}cookie_$email "https://coding.net/api/user/${email_prefix}/project/project_nim/git/tree/${new_branch_name}" --compressed)
    sleep 1s
    echo $result > ${script_path}tmpLog
    cid=$(awk -F "\"" '{ i = 1; while ( i <= NF ) { if(length($i)==40){print $i;break}; i++}}' ${script_path}tmpLog)
    echo "lastCommitSha="$cid >> ${script_path}idLog

    file_title=$(date +%Y%m%d)
    echo -e "\n ${file_title}"
    curl --cookie ${path}cookie_$email "https://coding.net/api/user/${email_prefix}/project/project_nim/git/new/${new_branch_name}"%"252F" --data "title=${file_title}&content=111&message=new"%"20file"%"20sowhathisnext&lastCommitSha=${cid}" --compressed

    echo -e "\n create merge request6"
    curl --cookie ${path}cookie_$email "https://coding.net/api/user/${email_prefix}/project/project_nim/git/merge" --data "srcBranch=${new_branch_name}&desBranch=master&title=mmtomm&content="  --compressed

    sleep 2s
    echo -e "\n get balance"
    log=$(curl  --cookie ${path}cookie_$email "https://coding.net/api/point/points" --compressed)
    echo $log > ${script_path}tmpLog
    onlybalance=$(grep -onE "points_left\"\:[0-9]?\.[0-9]{1,2}" ${script_path}tmpLog | awk -F ":" '{print $3}')
    echo $onlybalance" "${email}>>${script_path}updatebalance${today}
    #echo $onlybalance>>${script_path}onlybalance${today}
done
#cat ${script_path}updatebalance${today} | sort -t ' ' -k1n | mail -s 'coding balance' 2003wangheyang@163.com
#cat ${script_path}updatebalance${today} | sort -t ' ' -k1n | mail -s 'coding balance' ottoducker@163.com
