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

		var sql = 'select * from test where id = ? limit ?,1';

		con.query(sql,[1,0],function(error, result){

			if(error) throw error;
			
			console.log(result);

			
			
		});

	});
