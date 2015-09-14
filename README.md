# BalloonFusenSystem
Amazon Linux AMI 2015.03.1 (HVM), SSD Volume Typeを使用

```
sudo yum update
sudo yum install git php56 php56-mysqlnd mysql55-server
sudo service httpd start
sudo service mysqld start
git clone git@github.com:hasipon/BalloonFusenSystem.git
cd BalloonFusenSystem/
mysql -u root < create_db.sql
mysql -u root bfs < schema.sql
sudo ./deploy
```
