var envs = require('dotenv').config()

var mysql = require('mysql');

var conRead = mysql.createConnection({

	host:process.env.FE_READ_HOST,
	user:process.env.FE_READ_USER,
	password:process.env.FE_READ_PASSWORD,
	database:process.env.FE_READ_DBNAME,
});


var conWrite = mysql.createConnection({

	host:process.env.FE_WRITE_HOST,
	user:process.env.FE_WRITE_USER,
	password:process.env.FE_WRITE_PASSWORD,
	database:process.env.FE_WRITE_DBNAME,
});


conRead.connect(function(error){

	if(error) throw error;

	console.log('connected with read access');
});



conWrite.connect(function(error){

	if(error) throw error;

	console.log('connected with write access');
});
