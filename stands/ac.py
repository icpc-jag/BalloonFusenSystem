# -*- coding: utf-8 -*-
import os
import sys
import re
import cookielib
import urllib
import urllib2
import json
import time
import hashlib

with open('contest.txt', 'r') as f:
    contest_url = f.readline().rstrip()
    contest_name = f.readline().rstrip()

cookie_path = 'cookie.txt'
login_url = contest_url + 'login'

cj = cookielib.LWPCookieJar()
if os.path.isfile(cookie_path): cj.load(cookie_path)
opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cj))

stands_url = contest_url + 'standings/json'

stands = json.loads(opener.open(stands_url).read())
task_name = [x['task_screen_name'].encode('utf-8') for x in stands['response'][0]['tasks']]
with open('teams.tsv', 'w') as f:
    for row in stands['response'][1:]:
        user_screen_name = row['user_screen_name'].encode('utf-8')
        user_name = row['user_name'].encode('utf-8')
        f.write('%s\t%s\n' % (user_screen_name, user_name))
with open('ac.tsv', 'w') as f:
    for row in stands['response'][1:]:
        user_screen_name = row['user_screen_name'].encode('utf-8')
        for i, col in enumerate(row['tasks']):
            if col['score'] > 0:
                f.write('%s\t%s\n' % (user_screen_name, task_name[i]))
with open('clar.txt', 'w') as f:
    body = opener.open(contest_url + 'clarifications').read()
    stripped = re.sub('server-current-time..20../../.. ..:..:..', '', body)
    f.write(hashlib.md5(stripped).hexdigest())
