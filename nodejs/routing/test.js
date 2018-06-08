var express = require('express');

var app = express();

app.get('/',function(req,res){

	console.log('Home page using GET METHOD');

	res.end('Home page using GET METHOD');

});

app.post('/',function(req,res){

	console.log('Home page using POST METHOD');

	res.end('Home page using POST METHOD');

});

app.delete('/del_user',function(req,res){

	console.log('DELETE Method demo');

	res.end('DELETE Method demo');

});

app.get('/ab*cd',function(req,res){

	console.log('ab*cd pattern matched');

	res.end('ab*cd pattern matched');

});

var server = app.listen(8000,function(){
		var host = server.address().address;
		var port = server.address().port;

		console.log('Ready to listen http://%s:%s',host,port);
		
});
