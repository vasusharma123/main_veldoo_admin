<html>
<head>
	<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script> 
	<script>
	// [{'id': '1475','pickup_address': 'test loc','dest_address': 'sec 7 chandigarh','price': '100','distance': '15'}]
		var socket = io.connect("http://3.140.176.203:3000?socket_id=<?php echo $_GET['socket_id'];?>&driver_id=<?php echo $_GET['driver_id'];?>&show=1&ride_data=<?php echo $_GET['ride_data']; ?>");
		//var ride_data = "<?php echo $_GET['ride_data']; ?>";
		//console.info(JSON.parse(JSON.stringify(ride_data)));
		//console.log('ride_data '+JSON.parse(JSON.stringify(ride_data)));
		socket.on('connect', function() {
			console.log('web socket connected');
			var getsocketid = socket.id;
			console.log('web socket id'+getsocketid);
			/* var getsocketid = socket.id;
		  
			var data = JSON.stringify({'socket_id':getsocketid,"user_id":"<?php echo $_GET['socket_id']; ?>","group_id":"<?php echo $_GET['driver_id']; ?>"});
			socket.emit('backend', data); 
			
			
			
			console.log("socket id"+socket.id+456); */
		});


		socket.on('driver-new-ride', function (data) {
          console.log("driver"+<?php echo $_GET['driver_id']; ?>);
		  
		 // var ridedata = await helper.DriverRideData(<?php echo $_GET['driver_id']; ?>);
				var socketid = "<?php echo $_GET['socket_id']; ?>";
					/* var driverdata = await helper.DriverData(driver_id);
					driverdata = JSON.stringify(driverdata);
					ridedata['driver_data'] = driverdata;  */
					
			//var driverdata = await helper.DriverData(driver_id);
					//driverdata = JSON.stringify(driverdata);
				//	ridedata[0]['driver_data'] = driverdata[0]; 
			//ridedata = JSON.stringify(ridedata);
					io.to(socketid).emit(`ride-data-response`, 'adf adfsdf');
		  
		});	
		
		socket.on('backend3', function (data) {
			//console.log("socket"+<?php echo $_GET['socket_id']; ?>);
		});	
		 
	</script>	
</head>
<body>
</body>
</html>