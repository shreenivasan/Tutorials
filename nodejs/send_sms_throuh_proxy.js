var http = require('http');
var rawData = '';
var messageEncode = encodeURI('<text_message>', "UTF-8");
var numberEncode = encodeURI('<mobile_numbers>', "UTF-8");
var url = 'http://push3.maccesssmspush.com/servlet/com.aclwireless.pushconnectivity.listeners.TextListener?userId=fgfafi&pass=fgfafi18&appid=fgfafi&subappid=fgfafi&contenttype=1&to=${numberEncode}&from=FGFAFI&text=${messageEncode}&selfid=true&alert=1&dlrreq=true';
var auth = 'Basic ' + Buffer.from('<proxy_username>:<proxy_pwd>').toString('base64');
var host = 'push3.maccesssmspush.com';
var options = {
method: 'GET',
        port: <proxy_host>,
        host: '<proxy_ip>',
        path: url,
        headers: {
        Host: host,
                'Proxy-Authorization': auth
        }
};
var request = http.request(options, function (response) {

response.on('data', (chunk) => {
    rawData+=chunk;
});
        response.on('end', ()=> {
            try {
                var result = rawData;
                    //callback(null, 'OTP send successfully');
            } catch (e) {
            var err = new Error(e);
                    // callback(err, null);
            }
        });
});
request.end();
request.on('error', function (e) {
var err = new Error(e);
        // callback(err, null);
});
