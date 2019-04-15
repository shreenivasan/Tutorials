var express = require('express');

var app = express();

var bodyParser = require('body-parser');

var urlencodedParser = bodyParser.urlencoded({extended:false});

app.use(express.static('public'));


app.post('/process_post',urlencodedParser,function(req,res){

	response = {
					firstname:req.body.firstname,
					lastname:req.body.lastname
			   };

	console.log(response);
	
	res.end(JSON.stringify(response));

});

    var server = app.listen(8000, function () {  
      var host = server.address().address  
      var port = server.address().port  
      console.log("Example app listening at http://%s:%s", host, port)  
    })  
