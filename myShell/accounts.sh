account[114971]=seyuandi@163.com

today=$(date +%Y-%m-%d)
for i in "${!account[@]}";
do
    path="/home/dick/mine/coding.net/script/cookies/"
    script_path="/home/dick/mine/coding.net/script/"
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
