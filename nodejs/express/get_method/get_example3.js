var express = require('express');

var app = express();

app.get('/get_example3',function(req,res){

	var final_string = '';

	final_string +="First name : "+req.query['firstname'];
	final_string +="Last name : "+req.query['lastname'];
	final_string +="Password : "+req.query['password'];
	final_string +="Gender : "+req.query['sex'];
	final_string +="Description : "+req.query['aboutyou'];

	res.end(final_string);
});

var server = app.listen(8000,function(){

	var host = server.address().address;
	var port = server.address().port;

	console.log('Node listing http://%s:%s',host,port);

});
