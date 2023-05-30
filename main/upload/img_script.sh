DB_CON="mysql -u root -p"
DB_PASSWORD="Gjqm6953!@#$"

target=2020
path="/var/www/html/upload/icomes/$target"

for file in $path/*
do
    filename="$(basename "!$file")"
    $DB_CON"$DB_PASSWORD" icomes -e "INSERT INTO file (original_name,save_name,path,size,extension) VALUES ('$filename', '$filename', '$file', '$(du "$file" | cut -f 1)', '${file##*.}' );"
    echo "$(du "$file" | cut -f 1)"
    echo "$filename"
    echo "${file##*.}"
done
