
'use strict';
const fs = require('fs');
const express = require("express");
const cors = require('cors')
//const https = require('http');
const https = require('http');
const socketio = require('socket.io');
const bodyParser = require('body-parser');

const socketEvents = require('./utils/socket'); 
const routes = require('./utils/routes'); 
const config = require('./utils/config'); 

//const privateKey = fs.readFileSync( 'private.key' ); 
//const certificate = fs.readFileSync( 'certificate.crt' );
//const credentials = {key: privateKey, cert: certificate};
//app.set('socketio', io);


class Server{

    constructor(){
        this.port =  process.env.PORT || 3000;
		//this.host = `174.138.27.136`;
        // this.host = `172.31.22.57`;
		//this.host = `174.138.27.136`;
        
        this.app = express();
		this.app.use(function (req, res, next) {
			res.setHeader('Access-Control-Allow-Origin', '*');
			res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
			res.setHeader('Access-Control-Allow-Headers', 'Content-Type');
			res.setHeader('Access-Control-Allow-Credentials', true);
			next();
		});
		//this.http = https.Server(credentials,this.app);
		this.http = https.Server(this.app);
        this.socket = socketio(this.http);
    }

    appConfig(){        
        this.app.use(
            bodyParser.json()
        );
		this.app.use(
            cors()
        );
        new config(this.app);
    }

    /* Including app Routes starts*/
    includeRoutes(){
        new routes(this.app).routesConfig();
        new socketEvents(this.socket).socketConfig();
    }
    /* Including app Routes ends*/  

    appExecute(){

        this.appConfig();
        this.includeRoutes();

        this.http.listen(this.port, () => {
            console.log(`Listening on ${this.port}`);
        });
    }

}

const app = new Server();

app.appExecute();
