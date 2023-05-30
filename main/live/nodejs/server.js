const app	= require("express")()
const cors	= require('cors')
app.use(cors());

// DB Connection
const mysql = require('mysql');
const dbconfig = require('./config.js')
const connection = mysql.createConnection(dbconfig)

// Axios
const axios = require('axios')
const url = "http://54.180.86.106/main/ajax"

const fs = require('fs')
const opts = {
	/*//ca: fs.readFileSync('/etc/httpd/conf/server.crt'),
	key: fs.readFileSync('/etc/httpd/conf/server.key'),
	cert: fs.readFileSync('/etc/httpd/conf/server.crt'),
	passphrase: 'gjqm6953'*/
}

var server = require("http").createServer(opts);
//var server = require("http").createServer(app)
var io = require("socket.io")(server, {
	allowEIO3: true,
	cors:{
		origin: 'http://54.180.86.106',
		methods:["GET", "POST"],
		credentials: true
	}
});

// data
var id_arr = new Array();
id_arr[1] = new Array();
id_arr[2] = new Array();
id_arr[3] = new Array();
id_arr[4] = new Array();
id_arr[5] = new Array();

io.on("connection",function(socket){

	socket.emit('connection_complete', socket.id);

	socket.on('set_place', function(data) {
		var place_idx = Number(data.place_idx);
		id_arr[place_idx].push(socket.id);
	});

	// alert_chat
	socket.on('alert_chat', function(data) {
		try{
			var place_idx = Number(data.place_idx);
			id_arr[place_idx].forEach(function(el){
				if (el != "" && el != socket.id) {
					socket.to(el).emit('get_chat_list');
				}
			});
		} catch(err){
			console.log('place_idx', place_idx);
			console.log(err);
		}
	});

	// force client disconnect from server
	socket.on('forceDisconnect', function() {
		socket.disconnect();
	});

	socket.on('disconnect', function() {
		id_arr.forEach(function(ids, index){
			id_arr[index] = id_arr[index].filter(function(el) {
				return el !== socket.id;
			});
		});
	});
})

// Node JS Socket Server 3000 Port
server.listen(3000, function(){
	//console.log("__dirname : "+__dirname);
	//console.log("Socket IO server listening on port 3000")
})