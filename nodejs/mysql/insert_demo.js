var mysql = require('mysql');
var con = mysql.createConnection({
		host:"localhost",
		user:"root",
		password:"root",
		database:"mydbs",
	});

con.connect(function(error){

	if(error) throw error;

    console.log('connected');

	var sql = "insert into test(name) value('two'),('three'),('four') ";

	con.query(sql, function(error, result){

		if(error) throw error;

		console.log('one record inserted');
		
	});

});

