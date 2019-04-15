var express = require('express');
var cookieParser = require('cookie-parser');

var app = express();
app.use(cookieParser());

app.get('/',function(req,res){

	res.send('Home page visit');

});

app.get('/set_cookie',function(req,res){

	res.cookie('cookie_first_name','Shreenivas');
	res.cookie('cookie_last_name','Madagundi');

	res.status('200').send('Cookies set');

});

app.get('/get_cookie',function(req,res){
	res.status('200').send(req.cookies);

});

var server = app.listen(8000,function(){
		var host = server.address().address;
		var port = server.address().port;

		console.log('Ready to listen http://%s:%s',host,port);
		
});
