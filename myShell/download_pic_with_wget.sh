cat url_list | while read LINE
do
    wget $LINE
done
