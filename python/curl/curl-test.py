import requests
import requests.auth

proxies = {
    "http" :"10.0.4.241:3128"
}
auth = HTTPProxyDigestAuth("460195", "India@123")

# HTTP
r = requests.post('http://push3.maccesssmspush.com/servlet/com.aclwireless.pushconnectivity.listeners.TextListener?pass=fvralt&alert=1&appid=fvralt&selfid=true&dlrreq=true&subappid=fvralt&from=EASYDY&to=9665419470"&text=msg&userId=fvralt&Key=Value&contenttype=1', proxies=proxies, auth=auth)
r.status_code # 200 OK

# HTTPS
r = requests.post('http://push3.maccesssmspush.com/servlet/com.aclwireless.pushconnectivity.listeners.TextListener?pass=fvralt&alert=1&appid=fvralt&selfid=true&dlrreq=true&subappid=fvralt&from=EASYDY&to=9665419470"&text=msg&userId=fvralt&Key=Value&contenttype=1', proxies=proxies, auth=auth)
r.status_code # 200 OK
