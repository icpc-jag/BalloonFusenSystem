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
import xml.etree.ElementTree

with open('contest.txt', 'r') as f:
    stands_url = f.readline().rstrip()

contest_standing = xml.etree.ElementTree.fromstring(urllib2.urlopen(stands_url).read())

with open('teams.tsv', 'w') as f:
    for user_id in [x.text for x in contest_standing.findall('standing/user/user_id')]:
        f.write('%s\t%s\n' % (user_id, user_id))
with open('ac.tsv', 'w') as f:
    for user in contest_standing.findall('standing/user'):
        user_id = user.find('user_id').text
        for problem in user.findall('problem_list/problem'):
            serial = problem.find('serial').text
            solved_time = int(problem.find('solved_time').text)
            if solved_time > 0:
                f.write('%s\t%s\n' % (user_id, serial))
with open('clar.txt', 'w') as f:
    pass
