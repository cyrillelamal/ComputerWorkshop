from urllib.parse import quote
from telnetlib import Telnet
import re

NAME = quote('Кирилл')
FNAME = quote('Косыгин')

EXPECTED_HEADER = 'X-Test'

METHOD = 'POST'
HOST = 'www.kodaktor.ru'
URI = '/api/req'

BODY = f'name={NAME}&fname={FNAME}'
CONTENT_LENGTH = len(BODY.encode('ascii'))

msg = f'{METHOD} {URI} HTTP/1.1\n'
msg += f'Host: {HOST}\n'
# msg += f'Content-Type: application/x-www-form-urlencoded\n'
msg += f'Content-Length: {CONTENT_LENGTH}\n\n'

msg += f'{BODY}'


msg = msg.encode('ascii')

tn = Telnet(HOST, 80)

tn.write(msg)
out = tn.read_all().decode('utf-8').lower()

if EXPECTED_HEADER.lower() in out:
    regex = f'{EXPECTED_HEADER}:'.lower()
    regex += r'( ){1,}(.+)?\n'
    m = re.search(regex, out)
    header_val = m.group(2)
    print(f'{EXPECTED_HEADER}: {header_val}')
else:
    print('Something went wrong')

tn.close()
