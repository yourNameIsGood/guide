cat ${1} | while read LINE
do
    file=$(basename "$LINE")
    if [ ! -f "$file" ]; then
        wget $LINE
    else
        echo "$file is in current directory"
    fi
done
