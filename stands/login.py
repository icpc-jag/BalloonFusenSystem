# -*- coding: utf-8 -*-
import os
import re
import cookielib
import urllib
import urllib2

with open('contest.txt', 'r') as f:
    contest_url = f.readline().rstrip()

pwd = ''
cookie_path = pwd+'cookie.txt'
login_url = contest_url + 'login'

with open('passwd.txt', 'r') as f:
    name, password = f.readline().rstrip().split(':')

param = {}
param['name'] = name
param['password'] = password

cj = cookielib.LWPCookieJar()
if os.path.isfile(cookie_path): cj.load(cookie_path)
opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cj))
r = opener.open(login_url, urllib.urlencode(param))
cj.save(cookie_path)
