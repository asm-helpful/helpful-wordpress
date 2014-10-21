# TODO: test if running these two lines is necessary and avoid running them when is not
mysqladmin -uroot password password 2>/dev/null || true
mysqladmin create wordpress -uroot -ppassword 2>/dev/null || true

mysql -uroot -ppassword -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'password' WITH GRANT OPTION;"
