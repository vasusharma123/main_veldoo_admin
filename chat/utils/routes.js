/**
* Real Time chatting app
* @author Shashank Tiwari
*/

'use strict';

const helper = require('./helper');
const path = require('path');
const socketio = require('socket.io');
var io = require('socket.io')();

class Routes{

	constructor(app,socket){

		this.app = app;
		this.io = socket;
	}
	
	appRoutes(){
		this.app.get('/testchat',async (request,response) =>{
			// const data = await helper.userNameCheck('gouravkumar.webman@gmail.com');
			var timestamp = Math.floor(Date.now());
			let messagePacket = {
				"group_id": 10,
				"user_id": 12,
				"file": '',
				"message": "good",
				"time": timestamp.toString(),
				"read": 0,
				"type": 1
			};
			const data = await helper.insertMessages(messagePacket);
			// let parameters = {"operation_id":12};
			// const data = await helper.isRoom(parameters);
			// console.log(454);
			response.send('chat server working . 333ssss'+JSON.stringify(data));
		});
		this.app.get('/driverlist',async (request,response) =>{
			console.log("abbb");
			//const data = await helper.carlist(lat,lng);
			// let parameters = {"operation_id":12};
			// const data = await helper.isRoom(parameters);
			var datas = await helper.driverlist(30.2109933,74.9454733);
			datas = JSON.stringify(datas);
			//console.log(454);
			//console.log("data is: "+datas);
			
			response.send('chat server working . 2525'+datas);
		});
		this.app.get('/ridedata',async (request,response) =>{
			console.log("abbb");
			var ride_id = 71;
			var driver_id = 113;
			//const data = await helper.carlist(lat,lng);
			// let parameters = {"operation_id":12};
			// const data = await helper.isRoom(parameters);
			var datas = await helper.RideData(ride_id);
			
			var driverdata = await helper.DriverData(driver_id);
					//driverdata = JSON.stringify(driverdata);
					datas[0]['driver_data'] = driverdata[0]; 
			datas = JSON.stringify(datas);
			
			//console.log(454);
			console.log("driverid is: "+driver_id);
			
			//response.send('chat server working . driverid'+driver_id+'data is'+datas);
			response.send(datas);
		});
		this.app.get('/masterdriverlist',async (request,response) =>{
			var master_drivers = await helper.masterDriverList();
				
				master_drivers.forEach(async(driverid,index) => {
					
					console.log("foreach "+index);
					
					console.log("master driverid2 "+driverid['id']);
					
						 console.log("async works ");
   var driverdata = await helper.DriverData(driverid['id']);
  // var userdata = await helper.DriverData(ridedatanew[0]['user_id']);
					var driverdatanew = JSON.parse(JSON.stringify(driverdata));
					console.log("driverdatanew 0 "+driverdatanew[0]); 
					var driversocketid = driverdatanew[0]['socket_id'];
					console.log("driversocketid "+driversocketid);
					//ridedata[0]['user_data'] = userdata[0]; 
			//ridedata = JSON.stringify(ridedata);
				var ridedata = await helper.RideData(ride_id);
			console.log("ridedata "+ridedata);
			
					//this.io.to(driversocketid).emit(`master-driver-response`, ridedata);
					
				});
				response.send(master_drivers);
			
		});
			this.app.get('/driverridedata',async (request,response) =>{
				response.setHeader('Access-Control-Allow-Origin', '*');
			console.log("abbb");
			var ride_id = 1474;
			var driver_id = request.query.driver_id;
			var socketid = request.query.socket_id;
			//const data = await helper.carlist(lat,lng);
			// let parameters = {"operation_id":12};
			// const data = await helper.isRoom(parameters);
			var datas = await helper.DriverRideData(driver_id);
			console.log("datas is: "+datas);
			var driverdata = await helper.DriverData(driver_id);
					//driverdata = JSON.stringify(driverdata);
					//datas[0]['driver_data'] = driverdata[0]; 
			datas = JSON.stringify(datas);
			
			//console.log(454);
			console.log("driverid is: "+driver_id);
			console.log("socketid is: "+socketid);
			console.log("test 444 is: ");
			
			var ridedata = await helper.RideData(ride_id);
			/* console.log("ridedata "+ridedata);
			
			var ridedatanew = JSON.parse(JSON.stringify(ridedata));
			console.log("ridedatanew "+ridedatanew);
				var driver_ids = ridedatanew[0]['driver_id'];
				console.log("driver_ids"+driver_ids);
				var driver_idsarray = driver_ids.split(",");
				driver_idsarray.forEach(function (driverid, index) {
					 (async () => {
   var driverdata = await helper.DriverData(driverid);
					var driverdatanew = JSON.parse(JSON.stringify(driverdata));
					var driversocketid = driverdatanew[0]['socket_id'];
					console.log("driversocketid "+driversocketid);
		   //this.io.to(socket_id).emit(`ride-data-response`, datas);
})();
					
  
}); */
				
				
					/* var driverdata = await helper.DriverData(driver_id);
					driverdata = JSON.stringify(driverdata);
					ridedata['driver_data'] = driverdata;  */
					//ridedata = JSON.stringify(ridedata);
			var driverdata = await helper.DriverData(driver_id);
					//driverdata = JSON.stringify(driverdata);
					ridedata[0]['driver_data'] = driverdata[0]; 
					var car_data = await helper.DriverCarData(driver_id);
					ridedata[0]['car_data'] = car_data[0];
					response.send(ridedata);
			//ridedata = JSON.stringify(ridedata);
					//this.io.to(socketid).emit(`ride-data-response`, ridedata);
			//response.send(datas);
		});
			this.app.get('/driverupdate',async (request,response) =>{
			console.log("abbb");
			//const data = await helper.carlist(lat,lng);
			// let parameters = {"operation_id":12};
			// const data = await helper.isRoom(parameters);
			const responsenew = await helper.addSocketId(111,"g5I2BjxIg",30.7174919,76.7105766);
			//console.log(454);
			//console.log("data is: "+datas);
			
			response.send('chat server working . 2525'+responsenew);
		});
  //                this.app.get('/getMasterNotification',async (request,response) =>{
		// 	var master_drivers = await helper.sendMasterNotification();

		// 	var arr=[];	
		 
		// 	 arr.push({
	 //             title:'No Driver Found', 
	 //             message:'Sorry No driver found at this time for your booking',
	 //             type:9,
	 //             ride_data:(master_drivers !='')?master_drivers[0]:{},
  //                    });	
		// 		response.send(arr);
			
		// });	

		  this.app.get('/get-remaining-driver-notification',async (request,response) =>{
			
			 	var getRideData = await helper.getlatestRide();
			 
                console.log('test'+getRideData[0]['id']);

                var arrDriverId=[];
                var arr=[];
                var remainingDrivr=[];
			 	
                if(getRideData){
			 		
			 			var rideHistoryDriver=await helper.getRideHistoryData(getRideData[0]['id']);
			 			rideHistoryDriver.forEach(async(driverid,index) => {
			 		        arrDriverId.push(driverid['driver_id']);
			 			});
                    console.log('drivers'+arrDriverId)
			 			remainingDrivr=await helper.getRemainingDrivers(arrDriverId,getRideData[0]['pick_lat'],getRideData[0]['pick_lng']);
                       console.log('driverData'+remainingDrivr[0])
                       
                    if(remainingDrivr){
			 		   remainingDrivr.forEach(async(driver_id,index) => {
			 			 arr.push({
	    			          title:'New Booking', 
	             		 	  message:'You Received new booking!',
	             			  type:1,
	             			  ride_data:(getRideData)?getRideData[0]:{},
                             });	
		
			 		   response.send(arr);	
			 		   });
			 	     }


			 		
			 	}
               
			 
		});

		this.app.get('/', (req, res) => {
			res.sendFile(__dirname + '/index.html');
		});

		this.app.get('*',(request,response) =>{
			response.send('chat server working . veldoo server');
		});
                		
	}

	routesConfig(){
		this.appRoutes();
		//this.socketEvents();
	}
}
module.exports = Routes;
//module.exports = io;