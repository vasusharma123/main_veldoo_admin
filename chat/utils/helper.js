/**
* Real Time chatting app
* @author Shashank Tiwari
*/

'user strict';
const DB = require('./db');

class Helper{
	
	constructor(app){
		this.db = DB;
	}
	/* select `users`.*, 3959 * acos(cos(radians(36.71))
* cos(radians(users.lat))
* cos(radians(users.lng) - radians(76.71))
+ sin(radians(36.71))
* sin(radians(users.lat))) AS distance from `users` where `user_type` = ? having `distance` < ? order by `distance` asc */
	async driverlist(lat,lng){
		
				try {
					
			//return await this.db.query(`SELECT * FROM users where user_type = 2`);
			return await this.db.query(`SELECT
  id,current_lat,current_lng, (
    3959 * acos (
      cos ( radians(?) )
      * cos( radians( users.current_lat ) )
      * cos( radians( users.current_lng ) - radians(?) )
      + sin ( radians(?) )
      * sin( radians( users.current_lat ) )
    )
  ) AS distance FROM users where user_type = 2 and availability = 1 HAVING distance < 30 ORDER BY distance LIMIT 0 , 20`,[lat,lng,lat]);
		} catch (error) {
			return null;
		}
	}
	async driverlistTest(){

		try {
			return await this.db.query(`SELECT * FROM users where user_type = 2`);
		} catch (error) {
			return null;
		}
	}
	async masterDriverList(){

		try {
			return await this.db.query(`SELECT * FROM users where user_type = 2 and is_master = 1`);
		} catch (error) {
			return null;
		}
	}
	async RideData(ride_id){

		try {
			return await this.db.query(`SELECT * FROM rides where id = ?`,[ride_id]);
		} catch (error) {
			return null;
		}
	}
	async DriverRideData(d_id){

		try {
			return await this.db.query(`Select * from rides WHERE FIND_IN_SET(?,driver_id) and status = 0 order by id desc limit 1`,[d_id]);
		} catch (error) {
			return error;
		}
	}
	async DriverData(driver_id){

		try {
			return await this.db.query(`SELECT * FROM users where id = ?`,[driver_id]);
		} catch (error) {
			return null;
		}
	}
	async DriverCarData(driver_id){

		try {
			var cardata = await this.db.query(`SELECT * FROM driver_choose_cars where user_id = ?`,[driver_id]);
			var cardatanew = JSON.parse(JSON.stringify(cardata));
					var car_id = cardatanew[0]['car_id'];
				return await this.db.query(`SELECT * FROM vehicles where id = ?`,[car_id]);
		} catch (error) {
			return null;
		}
	}
	
	async groupUser(userId,groupId){

		try {
			return await this.db.query(`SELECT * FROM group_users WHERE user_id = ? AND group_id = ?`, [userId, groupId]);
		} catch (error) {
			return null;
		}
	}
	async userSocketId(userId,groupId){

		try {
			return await this.db.query(`SELECT * FROM users WHERE id = ?`, [userId]);
		} catch (error) {
			return null;
		}
	}
	async userNameCheck (username){
		return await this.db.query(`SELECT count(email) as count FROM users WHERE LOWER(email) = ?`, `${username}`);
	}
	async isRoom (parameters){
		try {
			return await this.db.query(`SELECT id FROM chat_groups WHERE id = ?`, [group_id]);
		} catch (error) {
			return null;
		}
		
	}
	
	async addSocketId(userId, userSocketId,current_lat,current_lng){
		try {
			console.log('userId, userSocketId,current_lat,current_lng',userId, userSocketId,current_lat,current_lng);
			// return await this.db.query(`UPDATE group_users SET socket_id = ?, online = ? WHERE group_id=? AND user_id = ?`, [userSocketId,1,group_id,userId]);
			return await this.db.query('UPDATE users SET socket_id = ?, current_lat = ?,current_lng = ? WHERE id = ?', [userSocketId,current_lat,current_lng,userId]);
		} catch (error) {
			console.log(error);
			return error;
		}
	}

	async isUserLoggedOut(userSocketId){
		try {
			return await this.db.query(`SELECT online FROM users WHERE socket_id = ?`, [userSocketId]);
		} catch (error) {
			return null;
		}
	}

	async leaveUser(userSocketId){
		// return await this.db.query(`UPDATE group_users SET socket_id = ?, online= ? WHERE socket_id = ?`, ['','0',userSocketId]);
		return await this.db.query(`UPDATE users SET socket_id = ?, online= ? WHERE socket_id = ?`, ['','0',userSocketId]);
	}
	
	async logoutUser(userSocketId){
		return await this.db.query(`UPDATE users SET socket_id = ?, online= ? WHERE socket_id = ?`, ['','0',userSocketId]);
	}

    async compare (from,to){
        if(from > to){
            return from+'_'+to;
        }else{
            return to+'_'+from;
        }
     }
	  
	async insertMessages(params){
		try {
			var d = new Date();
            var n = d.getTime();

			var currentdate = new Date(); 
			var timestamp = currentdate.getTime();
            var datetime = currentdate.getFullYear() + "-"
                + (currentdate.getMonth()+1)  + "-" 
                + currentdate.getDate() + " "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();
			var createddate = datetime;
			return await this.db.query(
				"INSERT INTO chats (`group_id`,`user_id`,`message`,`file`,`type`,`time_in_stamp`,`created_at`,`updated_at`,`read_status`) values (?,?,?,?,?,?,?,?,?)",
				[params.group_id, params.user_id, params.message, params.file,  params.type, timestamp,createddate,createddate, params.read]
			); 
		} catch (error) {
			console.warn(error);
			return null;
		}
	}
	async sendMasterNotification(){
		try {
			return await this.db.query('SELECT * FROM rides WHERE status= -4 AND request_time IS NOT null ORDER BY id desc limit 1');
		} catch (error) {
			console.log(error);
			return error;
		}
	}
	async getRideData(ride_id){

		try {
			return await this.db.query(`SELECT * FROM rides where id = ?`,[ride_id]);
		} catch (error) {
			return null;
		}
	}
	async getlatestRide(){

		try {
			return await this.db.query(`SELECT * FROM rides WHERE status=0 ORDER BY id desc limit 1`);
		} catch (error) {
			return null;
		}
	}
	async getRideHistoryData(ride_id){

		try {
			return await this.db.query(`SELECT driver_id FROM ride_history WHERE ride_id = ? AND status IN ('0','1','2')`,[ride_id]);
		} catch (error) {
			return null;
		}
	}
	async getRemainingDrivers(ids,lat,long){

		try {
			return await this.db.query('SELECT users.*,current_lat,current_lng, (3959 * acos (      cos ( radians('+lat+') )      * cos( radians( users.current_lat ) )      * cos( radians( users.current_lng ) - radians('+long+') )      + sin ( radians('+lat+') )      * sin( radians( users.current_lat ) )    )) AS distance FROM users WHERE user_type=2 AND id NOT IN('+ids+') AND availability = 1 HAVING distance < 100 ORDER BY distance');
		} catch (error) {
			return null;
		}
	}
	async lastDriverActivity(d_id){
		try {
			return await this.db.query(`Select * from driver_stay_active_notifications WHERE driver_id = ? limit 1`,[d_id]);
		} catch (error) {
			return error;
		}
	}

	async rideAddress(r_id) {
		try {
			return await this.db.query(`Select id,pick_lat,pick_lng,pickup_address,dest_lat,dest_lng,dest_address from rides WHERE id = ? limit 1`, [r_id]);
		} catch (error) {
			return error;
		}
	}

}
module.exports = new Helper();