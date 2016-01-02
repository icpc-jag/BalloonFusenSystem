# BalloonFusenSystem

## 操作方法

http://itohjam.hatenablog.com/entry/2015/12/17/035829

[@itohjam](https://github.com/itohjam) さんが書いてくださいました。ありがとうございます。

## 設置方法

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
cd stands
```
atcoder
```
# edit contest.txt
# create passwd.txt
#   $ cat passwd.txt
#   id:pass
python login.py
./run.sh
```
aoj
```
# edit contest.txt
#   $ cat contest.txt
#   http://judge.u-aizu.ac.jp/onlinejudge/webservice/contest_standing?id=ACPC2015Day1
#   ACPC2015Day1
#   pass_code
#   staff_code
./run_aoj.sh
```
