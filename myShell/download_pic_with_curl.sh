i=0
cat url_list | while read LINE
do
    ((i++))
    curl -o pic_${i}.jpeg $LINE
done
