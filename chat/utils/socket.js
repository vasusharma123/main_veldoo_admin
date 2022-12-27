/**
* Real Time chatting app
* @author Himanshu kumar
*/
'use strict';

const path = require('path');
const helper = require('./helper');

class Socket{

    constructor(socket){
        this.io = socket;
    }
    
    socketEvents(){

        this.io.on('connection', (socket) => {
			//var socketid = request.query.socket_id;
           console.log('A user connected');
		  /*  console.log(socket.handshake.query.socket_id);
		   var ridedata = "testing";
		   this.io.to(socket.id).emit(`ride-data-response`, ridedata); */
			var room_name = '';
            const safeJoin = currentId => {
                socket.leave(room_name);
                socket.join(currentId);
                room_name = currentId;
				console.log('entered into room '+room_name);
            };
			
			 console.log('CAPTURE FINISHED');
          // socket on
            (async () => {
			    console.log("Remaining Drivr");

				var getRideData = await helper.getlatestRide();
			 
                var arrDriverId=[];
                var arr=[];
                var remainingDrivr=[];
				
				if(getRideData && getRideData[0]){
					console.log('test'+getRideData[0]['id']);
			 			var rideHistoryDriver=await helper.getRideHistoryData(getRideData[0]['id']);
			 			rideHistoryDriver.forEach(async(driverid,index) => {
			 		        arrDriverId.push(driverid['driver_id']);
			 			});
                    console.log('drivers'+arrDriverId)
			 			remainingDrivr=await helper.getRemainingDrivers(arrDriverId,getRideData[0]['pick_lat'],getRideData[0]['pick_lng']);
                    //   console.log('driverData'+remainingDrivr[0])
                       
                    if(remainingDrivr){
			 		   remainingDrivr.forEach(async(driver_id,index) => {

			 		   	var driverdata = await helper.DriverData(driver_id['id']);
                   // var userdata = await helper.DriverData(ridedatanew[0]['user_id']);
					var driverdatanew = JSON.parse(JSON.stringify(driverdata));
					console.log("driverdatanew 0 "+driverdatanew[0]); 
					var driversocketid = driverdatanew[0]['socket_id'];
					console.log("driversocketid "+driversocketid);

			 			 arr.push({
	    			          title:'New Booking', 
	             		 	  message:'You Received new booking!',
	             			  type:1,
	             			  ride_data:(getRideData)?getRideData[0]:{},
                             });	
		                console.log('driverRemainng'+arr)  
			 			// response.send(arr);	
					  this.io.to(driversocketid).emit(`remaining-notification-response`,arr);
				
			 		   });
			 	     }


			 		
			 	}
			     console.log("If you like it, show it");
			})();

			(async () => {
			    console.log("Master Driver Notification");
			      
				var rideData = await helper.sendMasterNotification();
				var masterDriverList= await helper.masterDriverList();
				var arr=[];	
		  
			 arr.push({
	             title:'No Driver Found', 
	             message:'Sorry No driver found at this time for your booking',
	             type:9,
	             ride_data:(rideData !='')?rideData[0]:{},
                     });
                masterDriverList.forEach(async(driver_id,index) => {

			 		   	var driverdata = await helper.DriverData(driver_id['id']);
              // var userdata = await helper.DriverData(ridedatanew[0]['user_id']);
					var driverdatanew = JSON.parse(JSON.stringify(driverdata));
					console.log("driverdatanew 0 "+driverdatanew[0]); 
					var driversocketid = driverdatanew[0]['socket_id'];
					console.log("getMasterNotification "+arr);
     	        
     	          this.io.to(driversocketid).emit(`master-driver-notification-response`, arr);
                }); 
              
			    console.log("If you like it, show it");
			})();


		  
           socket.on('update_user', async (data) => {
				let obj = JSON.parse( data );
				let socketid = obj.socket_id;
				if (obj.user_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`User id required`); 

                } else if (obj.socket_id === '') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Socket id required`); 

                } else if (obj.lat === '') {
                    this.io.to(socketid).emit(`user-message-response-error`,`lat required`); 

                } 
				else if (obj.lng === '') {
                    this.io.to(socketid).emit(`user-message-response-error`,`lng required`); 
				}
				else {
					const response = await helper.addSocketId(obj.user_id, obj.socket_id,obj.lat,obj.lng);
	/* 				safeJoin(obj.group_id);
					if(response){
						this.io.to(room_name).emit('login-response',{
						   error : false,
						   data : socket.id
						});
					} */
					
					/* let room_name = Math.random();
					socket.join(room_name, () => {
						let rooms = Object.keys(socket.rooms);
						console.log(rooms); 
						console.log('user updated');
					}); */
					console.log("user connected");
					 this.io.to(socketid).emit(`user-message-response`, 'user updated successfully');
				
					
				}
           });
		    socket.on('send_driverdata_touser', async (data) => {
			   console.log(data);
				let obj = JSON.parse( data );
				let socketid = obj.socket_id;
				if (obj.user_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`User id required`); 

                } else if (obj.socket_id === '') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Socket id required`); 

                } 
				else if (obj.driver_id === '') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Driver id required`); 

                } 
				else {
					console.log("user_id is: "+obj.user_id);
					//console.log("user_id2 is: "+data.user_id);
					const userdata = await helper.userSocketId(obj.user_id);
					//let userdata2 = JSON.parse( JSON.stringify(userdata) );
					console.log("userdata is :"+JSON.parse( JSON.stringify(userdata) ));
				let socketid = userdata[0].socket_id;
					// this.io.to(socketid).emit(`user-message-response`, 'user updated successfully');
					  this.io.to(socketid).emit(`user-driverdata-message-response`, data);
				}
           });
		   socket.on('send_ridedata_touser', async (data) => {
			   console.log(data);
				let obj = JSON.parse( data );
				let socketid = obj.socket_id;
				if (obj.user_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`User id required`); 

                } else if (obj.socket_id === '') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Socket id required`); 

                } 
				else if (obj.drop_location === '') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Drop Location required`); 

                } 
				else if (obj.drop_lat === '') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Drop Latitute required`); 

                } 
				else if (obj.drop_long === '') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Drop Location required`); 

                } 
				else {
					console.log("user_id is: "+obj.user_id);
					//console.log("user_id2 is: "+data.user_id);
					const userdata = await helper.userSocketId(obj.user_id);
					//let userdata2 = JSON.parse( JSON.stringify(userdata) );
					console.log("userdata is :"+JSON.parse( JSON.stringify(userdata) ));
				let socketid = userdata[0].socket_id;
					// this.io.to(socketid).emit(`user-message-response`, 'user updated successfully');
					  this.io.to(socketid).emit(`user-ridedropdata-message-response`, data);
				}
           });
		   socket.on('home_location', async (data) => {	
				
				let obj = JSON.parse(JSON.stringify(data));
				let socketid = obj.socket_id;
				console.log("home location socketid is: "+socketid);
				if (obj.user_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`User id required`); 

                } else if (obj.socket_id === '') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Socket id required`); 

                } else if (obj.driver_id === '') {
                    this.io.to(socketid).emit(`user-message-response-error`,`driver List required`); 

                } 
				
				else {
					console.log("Home Location event calling");
					var homedata = [];
					const driverlist = obj.driver_id;
						console.log("driverlist are: "+driverlist);
						if (driverlist.indexOf(',') > -1) { 
						
						const array = driverlist.split(',');
						console.log("driverlist ids are: "+array);
									for (let i = 0; i < array.length; i++) {
							 var driverdata = await helper.DriverData(array[i]);
							 console.log("driverdata is "+driverdata[0]['current_lat']);
							 var current_lat = driverdata[0]['current_lat'];
							 var current_lng = driverdata[0]['current_lng'];
							 homedata.push({ lat: current_lat, lng: current_lng });  
							 //homedata.push = driverdata[0]['current_lat']; 
							 //homedata.push = driverdata[0]['current_lng']; 
							}	
						}
						else
						{
							 var driverdata = await helper.DriverData(driverlist);
							 console.log("driverdata is "+driverdata[0]['current_lat']);
							 var current_lat = driverdata[0]['current_lat'];
							 var current_lng = driverdata[0]['current_lng'];
							 homedata.push({ lat: current_lat, lng: current_lng }); 
						}
						
						
			
					
					
			homedata = JSON.stringify(homedata);
			console.log("homedata are: "+homedata);
			console.log("socketid data sent here: "+socketid);
					this.io.to(socketid).emit(`home-data-response`, homedata);
					
				}
           });
            /**
            * send the messages to the user
            */
            socket.on('test-message-old', async (datas) => {
				console.log(12);
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
			});
            socket.on('test-message', async (datas) => {
                let data = JSON.parse( datas );
				// const room_name = data.group_id;
				room_name = data.group_id;
				// console.log(data.socket_id);
				console.log(room_name);
				this.io.to(room_name).emit(`test-message-response`,`Job id required`); 
				// this.io.to(data.socket_id).emit(`test-message-response`,`Job id required`); 
			});
            socket.on('user-typing', async (datas) => {
                let data = JSON.parse( datas );
				// const room_name = data.group_id;
				room_name = data.group_id;
				// console.log(data.socket_id);
				console.log(room_name);
				this.io.to(room_name).emit(`user-typing-response`,data); 
				// this.io.to(data.socket_id).emit(`test-message-response`,`Job id required`); 
			});
			
            socket.on('add-message', async (datas) => {
                let data = JSON.parse( datas );
                const room_name = data.group_id;
				if (data.user_id=='') {
                    this.io.to(socketid).emit(`add-message-response-error`,`User id required`); 
					return false;
                }
				const userdata = await helper.userSocketId(data.user_id);
				let socketid = userdata[0].socket_id;
                 
                if (data.job_id=='') {
                    this.io.to(socketid).emit(`add-message-response-error`,`Job id required`); 

                } else if (data.message === '' && data.file === '') {
                    this.io.to(socketid).emit(`add-message-response-error`,`Message cant be empty`); 

                }else if(data.group_id === ''){
                    
                    this.io.to(socketid).emit(`add-message-response-error`,`Unexpected error, Login again.`); 

                } else {
								
					const isRoom = await helper.isRoom({operation_id:data.job_id, type:1});
					
					if (isRoom=='') {
						this.io.to(socketid).emit(`add-message-response-error`,`Invalid room`);
						return false;
					}
					const isRoomUser = await helper.groupUser(data.user_id, data.group_id);
					if (isRoomUser=='') {
						this.io.to(socketid).emit(`add-message-response-error`,`Invalid room user`);
						return false;
					}
										
					if(userdata[0].online == 1){
						const sqlResult = await helper.insertMessages({
							group_id: data.group_id,
							user_id: data.user_id,
							file: data.file,
							type: data.type,
							message: data.message,
							time: data.time_in_stamp,
							read: 1
						});
					}else{
						const sqlResult = await helper.insertMessages({
							group_id: data.group_id,
							user_id: data.user_id,
							file: data.file,
							type: data.type,
							message: data.message,
							time: data.time_in_stamp,
							read: 0
						});
					}
                    
                    this.io.to(room_name).emit(`add-message-response`, data);
                }
            });

            /**
            * sending the disconnected user to all socket users. 
            */
/*             socket.on('disconnect',async ()=>{
                console.log('A user disconnected');
                const isLoggedOut = await helper.logoutUser(socket.id);
                setTimeout(async ()=>{
                    const isLoggedOut = await helper.isUserLoggedOut(socket.id);
                    if (isLoggedOut && isLoggedOut !== null) {
                        socket.broadcast.emit('chat-list-response', {
                            error: false,
                            userDisconnected: true,
                            socketId: socket.id
                        });
                    }
                },1000);
            }); */
          
            socket.on('logout', async (obj) => {
				const isLoggedOut = await helper.logoutUser(socket.id);
				this.io.to(socket.id).emit('logout-response',{
					error : false,
					data: socket.id
				});
                socket.disconnect();
            });

            socket.on('disconnect',async ()=>{
				const isLoggedOut = await helper.logoutUser(socket.id);
				this.io.to(socket.id).emit('logout-response',{
					error : false,
					data: socket.id
				});
            });
			/*  socket.on('testsocket', async (datas) => {
				 console.log(rooms); 
						console.log('test socket');
						response.send('food fix socket working');
              
			}); */
			socket.on('driver_list', async (datas) => {
				
						//console.log('test socket');
						//response.send('food fix socket working');
               let data = JSON.parse( datas );
				var lat = data.lat;
				var lng = data.lng;
				var socketid = data.socket_id;
				console.log('socket id: '+socketid);
				//room_name = data.group_id;
				// console.log(data.socket_id);
				//console.log(room_name);
				//this.io.to(room_name).emit(`user-typing-response`,data); */ 
				// this.io.to(data.socket_id).emit(`test-message-response`,`Job id required`); 
				if (data.user_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`User id required`); 
					return false;
                }
				if (data.lat=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`lat required`); 
					return false;
                }
				if (data.lng=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`lng required`); 
					return false;
                }
				var driverlist = await helper.driverlist(lat,lng);
				console.log("latnew is "+lat);
		console.log("lngnew is "+lng);
					driverlist = JSON.stringify(driverlist);
					console.log("driverlist is "+driverlist);
					this.io.to(socketid).emit(`driver-list-response`, driverlist);
			});
			
			socket.on('ride_data', async (datas) => {
				
						//console.log('test socket');
						//response.send('food fix socket working');
               let data = JSON.parse( datas );
				var ride_id = data.ride_id;
				var driver_id = data.driver_id;
				//var lng = data.lng;
				var socketid = data.socket_id;
				console.log('socket id: '+socketid);
				//room_name = data.group_id;
				// console.log(data.socket_id);
				//console.log(room_name);
				//this.io.to(room_name).emit(`user-typing-response`,data); */ 
				// this.io.to(data.socket_id).emit(`test-message-response`,`Job id required`); 
				if (data.ride_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Ride Id required`); 
					return false;
                }
				if (data.driver_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Driver Id required`); 
					return false;
                }
				
				var ridedata = await helper.RideData(ride_id);
					
					/* var driverdata = await helper.DriverData(driver_id);
					driverdata = JSON.stringify(driverdata);
					ridedata['driver_data'] = driverdata;  */
					
			var driverdata = await helper.DriverData(driver_id);
					//driverdata = JSON.stringify(driverdata);
					ridedata[0]['driver_data'] = driverdata[0]; 
			ridedata = JSON.stringify(ridedata);
					this.io.to(socketid).emit(`ride-data-response`, ridedata); 
			}); 
		/*	
			socket.on('driver-new-ride', async (datas) => {
				
						//console.log('test socket');
						//response.send('food fix socket working');
               let data = JSON.parse( datas );
				var ride_id = data.ride_id;
				//var driver_id = data.driver_id;
				//var lng = data.lng;
				//var socketid = data.socket_id;
				//console.log('socket id: '+socketid);
				//room_name = data.group_id;
				// console.log(data.socket_id);
				//console.log(room_name);
				//this.io.to(room_name).emit(`user-typing-response`,data); */ 
				// this.io.to(data.socket_id).emit(`test-message-response`,`Job id required`); 
			/*	if (data.ride_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Ride Id required`); 
					return false;
                }
				/* if (data.driver_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Driver Id required`); 
					return false;
                } */
			/*	
				var ridedata = await helper.RideData(ride_id);
			console.log("ridedata "+ridedata);
			
			var ridedatanew = JSON.parse(JSON.stringify(ridedata));
			console.log("ridedatanew "+ridedatanew);
				var driver_ids = ridedatanew.driver_id;
				console.log("driver_ids"+driver_ids);
				var driver_idsarray = driver_ids;
				console.log("here working");
				driver_idsarray.forEach(async(driverid,index) => {
					console.log("foreach "+index);
					
						 console.log("async works ");
   var driverdata = await helper.DriverData(driverid);
   var userdata = await helper.DriverData(ridedatanew[0]['user_id']);
					var driverdatanew = JSON.parse(JSON.stringify(driverdata));
					var driversocketid = driverdatanew[0]['socket_id'];
					console.log("driversocketid "+driversocketid);
					ridedata[0]['user_data'] = userdata[0]; 
			//ridedata = JSON.stringify(ridedata);
					this.io.to(driversocketid).emit(`ride-data-response`, ridedata);
			
				});
			});
		*/	
			socket.on('driver-accept-send-user', async (datas) => {
				
						//console.log('test socket');
						//response.send('food fix socket working');
               let data = JSON.parse( datas );
				var ride_id = data.ride_id;
				var driver_id = data.driver_id;
				//var lng = data.lng;
				//var socketid = data.socket_id;
				//console.log('socket id: '+socketid);
				//room_name = data.group_id;
				// console.log(data.socket_id);
				//console.log(room_name);
				//this.io.to(room_name).emit(`user-typing-response`,data); */ 
				// this.io.to(data.socket_id).emit(`test-message-response`,`Job id required`); 
				if (data.ride_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Ride Id required`); 
					return false;
                }
				if (data.driver_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Driver Id required`); 
					return false;
                }
				
				var ridedata = await helper.RideData(ride_id);
			console.log("ridedata "+ridedata);
			
			var ridedatanew = JSON.parse(JSON.stringify(ridedata));
			
			   var userdata = await helper.DriverData(ridedatanew[0]['user_id']);
			   var driver_data = await helper.DriverData(driver_id);
					
					var usersocketid = userdata[0]['socket_id'];
					console.log("usersocketid "+usersocketid);
					ridedata[0]['driver_data'] = driver_data[0]; 
					var car_data = await helper.DriverCarData(driver_id);
					ridedata[0]['car_data'] = car_data[0];
			//ridedata = JSON.stringify(ridedata);
					this.io.to(usersocketid).emit(`ride-data-accept-user`, ridedata);
			
			});
			socket.on('driver-start-send-user', async (datas) => {
				
						//console.log('test socket');
						//response.send('food fix socket working');
               let data = JSON.parse( datas );
				var ride_id = data.ride_id;
				var driver_id = data.driver_id;
				//var lng = data.lng;
				//var socketid = data.socket_id;
				//console.log('socket id: '+socketid);
				//room_name = data.group_id;
				// console.log(data.socket_id);
				//console.log(room_name);
				//this.io.to(room_name).emit(`user-typing-response`,data); */ 
				// this.io.to(data.socket_id).emit(`test-message-response`,`Job id required`); 
				if (data.ride_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Ride Id required`); 
					return false;
                }
				if (data.driver_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Driver Id required`); 
					return false;
                }
				
				var ridedata = await helper.RideData(ride_id);
			console.log("ridedata "+ridedata);
			
			var ridedatanew = JSON.parse(JSON.stringify(ridedata));
			
   var userdata = await helper.DriverData(ridedatanew[0]['user_id']);
   var driver_data = await helper.DriverData(driver_id);
					
					var usersocketid = userdata[0]['socket_id'];
					console.log("usersocketid "+usersocketid);
					ridedata[0]['driver_data'] = driver_data[0]; 
					var car_data = await helper.DriverCarData(driver_id);
					ridedata[0]['car_data'] = car_data[0];
			//ridedata = JSON.stringify(ridedata);
					this.io.to(usersocketid).emit(`ride-data-start-user`, ridedata);
			
			});
			socket.on('driver-complete-send-user', async (datas) => {
				
						//console.log('test socket');
						//response.send('food fix socket working');
               let data = JSON.parse( datas );
				var ride_id = data.ride_id;
				var driver_id = data.driver_id;
				//var lng = data.lng;
				//var socketid = data.socket_id;
				//console.log('socket id: '+socketid);
				//room_name = data.group_id;
				// console.log(data.socket_id);
				//console.log(room_name);
				//this.io.to(room_name).emit(`user-typing-response`,data); */ 
				// this.io.to(data.socket_id).emit(`test-message-response`,`Job id required`); 
				if (data.ride_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Ride Id required`); 
					return false;
                }
				if (data.driver_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Driver Id required`); 
					return false;
                }
				
				var ridedata = await helper.RideData(ride_id);
			console.log("ridedata "+ridedata);
			
			var ridedatanew = JSON.parse(JSON.stringify(ridedata));
			
   var userdata = await helper.DriverData(ridedatanew[0]['user_id']);
   var driver_data = await helper.DriverData(driver_id);
					
					var usersocketid = userdata[0]['socket_id'];
					console.log("usersocketid "+usersocketid);
					ridedata[0]['driver_data'] = driver_data[0]; 
					var car_data = await helper.DriverCarData(driver_id);
					ridedata[0]['car_data'] = car_data[0];
			//ridedata = JSON.stringify(ridedata);
					this.io.to(usersocketid).emit(`ride-data-complete-user`, ridedata);
			
			});
			socket.on('driver-accept-send-alldrivers', async (datas) => {
				
               let data = JSON.parse( datas );
				var ride_id = data.ride_id;
				var driver_id = data.driver_id;
				
				if (data.ride_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Ride Id required`); 
					return false;
                }
				 if (data.driver_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Driver Id required`); 
					return false;
                } 
				
				var rideData = await helper.getRideData(ride_id);

				var driverlist =  await helper.driverlistTest();
				 

				driverlist.forEach(async(driverid,index) => {
                     if(driverid['id'] != driver_id){

                     	var driverdata = await helper.DriverData(driverid['id']);
				 var driverdatanew = JSON.parse(JSON.stringify(driverdata));
					console.log("driverdatanew 0 "+driverdatanew[0]); 
					var driversocketid = driverdatanew[0]['socket_id'];

                     	console.log("rideData"+rideData);
                      this.io.to(driversocketid).emit(`ride-data-accept-alldrivers`, rideData);
                     }
				});

					
					
				});
			
			socket.on("user-cancel-send-alldrivers", async (datas) => {
                console.log("driver-accept-send-alldrivers");
                console.log("datas " + datas);
                //response.send('food fix socket working');
                let data = JSON.parse(datas);
                var ride_id = data.ride_id;
                var driver_id = data.driver_id;
                //var lng = data.lng;
                //var socketid = data.socket_id;
                //console.log('socket id: '+socketid);
                //room_name = data.group_id;
                // console.log(data.socket_id);
                //console.log(room_name);
                //this.io.to(room_name).emit(`user-typing-response`,data); */
                // this.io.to(data.socket_id).emit(`test-message-response`,`Job id required`);
                if (data.ride_id == "") {
                    this.io
                        .to(socketid)
                        .emit(
                            `user-message-response-error`,
                            `Ride Id required`
                        );
                    return false;
                }
                /* if (data.driver_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Driver Id required`); 
					return false;
                } */

                var ridedata = await helper.RideData(ride_id);
                console.log("ridedata " + ridedata);

                var ridedatanew = JSON.parse(JSON.stringify(ridedata));
                console.log("ridedatanew " + ridedatanew);
                var driver_ids = ridedatanew[0]["all_drivers"] || "";
                console.log("driver_ids" + driver_ids);
                var driver_idsarray = driver_ids.split(",");
                console.log("here working");
                driver_idsarray.forEach(async (driverid, index) => {
                    console.log("foreach " + index);
                    console.log("driverid " + driverid);
                    if (driverid) {
                        console.log("async works ");
                        var driverdata = await helper.DriverData(driverid);
                        var userdata = await helper.DriverData(
                            ridedatanew[0]["user_id"]
                        );
                        var driverdatanew = JSON.parse(
                            JSON.stringify(driverdata)
                        );
                        console.log("driverdatanew 0 " + driverdatanew[0]);
                        var driversocketid = driverdatanew[0]["socket_id"];
                        console.log("driversocketid " + driversocketid);

                        //ridedata[0]['user_data'] = userdata[0];
                        //ridedata = JSON.stringify(ridedata);
                        this.io
                            .to(driversocketid)
                            .emit(`ride-data-cancel-alldrivers`, ridedata);
                    }
                });
            });
			socket.on('master-driver-update', async (datas) => {
				
						console.log('master-driver-rides');
						console.log('datas '+datas);
						//response.send('food fix socket working');
               let data = JSON.parse( datas );
				
				var ride_id = data.ride_id;
				
				/* if (data.type=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Type required`); 
					return false;
                } */
				if (data.ride_id=='') {
                    this.io.to(socketid).emit(`user-message-response-error`,`Driver Id required`); 
					return false;
                }
				
			var master_drivers = await helper.masterDriverList();
				
				master_drivers.forEach(async(driverid,index) => {
					
					console.log("foreach "+index);
					console.log("driverid "+driverid['id']);
					
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
			
					this.io.to(driversocketid).emit(`master-driver-response`, ridedata);
					
				});
			});

			socket.on('get-remaining-driver-notification', async (datas) => {
				var getRideData = await helper.getlatestRide();
			 
                var arrDriverId=[];
                var arr=[];
                var remainingDrivr=[];
				
				if(getRideData && getRideData[0]){
					console.log('test'+getRideData[0]['id']);
			 			var rideHistoryDriver=await helper.getRideHistoryData(getRideData[0]['id']);
			 			rideHistoryDriver.forEach(async(driverid,index) => {
			 		        arrDriverId.push(driverid['driver_id']);
			 			});
                    console.log('drivers'+arrDriverId)
			 			remainingDrivr=await helper.getRemainingDrivers(arrDriverId,getRideData[0]['pick_lat'],getRideData[0]['pick_lng']);
                       console.log('driverData'+remainingDrivr[0])
                       
                    if(remainingDrivr){
			 		   remainingDrivr.forEach(async(driver_id,index) => {

			 		   	var driverdata = await helper.DriverData(driver_id['id']);
  // var userdata = await helper.DriverData(ridedatanew[0]['user_id']);
					var driverdatanew = JSON.parse(JSON.stringify(driverdata));
					console.log("driverdatanew 0 "+driverdatanew[0]); 
					var driversocketid = driverdatanew[0]['socket_id'];
					console.log("driversocketid "+driversocketid);

			 			 arr.push({
	    			          title:'New Booking', 
	             		 	  message:'You Received new booking!',
	             			  type:1,
	             			  ride_data:(getRideData)?getRideData[0]:{},
                             });	
		                console.log('driverRemainng'+arr)  
			 			// response.send(arr);	
					  this.io.to(driversocketid).emit(`remaining-notification-response`,'test data ');
				
			 		   });
			 	     }


			 		
			 	}

		
			});

			socket.on('getMasterNotification', async (datas) => {
				
               
				var rideData = await helper.sendMasterNotification();
				var masterDriverList= await helper.masterDriverList();
				var arr=[];	
		  
			 arr.push({
	             title:'No Driver Found', 
	             message:'Sorry No driver found at this time for your booking',
	             type:9,
	             ride_data:(rideData !='')?rideData[0]:{},
                     });
                masterDriverList.forEach(async(driver_id,index) => {

			 		   	var driverdata = await helper.DriverData(driver_id['id']);
              // var userdata = await helper.DriverData(ridedatanew[0]['user_id']);
					var driverdatanew = JSON.parse(JSON.stringify(driverdata));
					console.log("driverdatanew 0 "+driverdatanew[0]); 
					var driversocketid = driverdatanew[0]['socket_id'];
					console.log("getMasterNotification "+arr);
     	        
     	          this.io.to(driversocketid).emit(`master-driver-notification-response`, arr);
                });
              
			});
			socket.on('', async (datas) => {
				console.log('----------------------');
               var rideData =  await helper.sendMasterNotification();
				var getDrivers= await helper.driverlistTest();

				console.log('rideNewData'+rideData[0])
				if(getDrivers){
	               getDrivers.forEach(async(driver_id,index) => {
	               	var newData= await helper.DriverData(driver_id['id']);
	               	var driverId=JSON.parse(JSON.stringify(newData));
	                var socket_id = driverId[0]['socket_id'];
	                console.log('socketID-test'+socket_id);
	                   this.io.to(socket_id).emit(`test-aug-response`,newData);
	               });

               }
			});
			socket.on("send_message_to_user_with_ride_id", async (datas) => {
                let data = JSON.parse(datas);
                if (data.user_id) {
					this.io.emit(`receive_message_by_driver_with_ride_id_${data.user_id}`, datas); 
                } else {
					console.log(`Error : There is no user id send from driver side`);
				}
            });
        });

    }
    
      

    socketConfig(){

        this.io.use( async (socket, next) => {
            //let userId = socket.request._query['userId'];
            //let roomId = socket.request._query['roomId'];
            //console.log(userId);
            let userSocketId = socket.id;   
            next();		
           // console.log("user socket id : "+userSocketId);			
            //const response = await helper.addSocketId( userId, userSocketId);
            //if(response &&  response !== null){
                
              //  next();
            //}else{
              //  console.error(`Socket connection failed, for  user Id ${userId}.`);
            //}
        });
        this.socketEvents();
    }
}
module.exports = Socket;