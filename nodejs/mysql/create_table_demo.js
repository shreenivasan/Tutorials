var mysql = require('mysql')

var con = mysql.createConnection({ 
	host:"localhost",
	user:"root",
	password:"root",
	database:"mydbs"
});

con.connect(function(error){
	
	if(error) throw error;

	console.log('connected');

	var sql = "create table test(id int auto_increment primary key, name varchar(20) )";

	con.query(sql,function(error,result){
		if(error) throw error;
		console.log('table created succesfully !');
	});

});


