import requests

while True:
    r = requests.post('./select.php')

    if r.status_code == 200:
        print(r.text)
        break