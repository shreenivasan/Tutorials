require('dotenv').config()

var express = require('express');

var app = express();
var bodyParser = require('body-parser');

app.use(express.static('public'));

var urlencodedParser = bodyParser.urlencoded({extended:false});

app.post('/loginPost',urlencodedParser,function(req,res){

	var username = req.body.username;
	var password = req.body.password;
	var sql = 'Select au.user_id,au.username,au.email,au.store_id , convert_tz(au.password_updated_on,\'+00:00\',\'+05:30\') as password_updated_on, ar.parent_id, concat(firstname," ",lastname) as name, au.extra,au.additional_permissions, au.category_meta,au.ameyo_user,au.ameyo_password from admin_user au left join admin_role ar on(au.user_id = ar.user_id) where username=? and password=? and is_active=1 limit 1';
	con.query(sql, function(error , result){
		console.log(JSON.stringify()d);
	});

	console.log(response);
	


});

var server = app.listen(8000,function(){

	var host = server.address().address;
	var port = server.address().port;
	
	console.log('connected with http://%s:%s',host,port);

});



