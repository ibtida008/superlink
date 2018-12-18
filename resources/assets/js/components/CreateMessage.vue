<template>
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3>Create Message</h3>
					<hr>
					<div class="form-group">
						<label>To</label>
						<input type="text" class="form-control" placeholder="Email of the receiver" v-model="message.receiver_email">
					</div>
					<div class="form-group">
						<label>Title</label>
						<input type="text" class="form-control" placeholder="Enter a title" v-model="message.title">
					</div>
					<div class="form-group">
						<label>Message</label>
						<textarea rows="5" style="resize:vertical" type="text" class="form-control" placeholder="Write your message" v-model="message.body"></textarea>
					</div>
					<button class="btn btn-success" @click="sendMessage">Send</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import swal from 'sweetalert';
	export default{
		data(){
			return{
				message : {
					sender_id : '',
					receiver_email : '',
					title : '',
					body : ''
				}
			}
		},
		created(){
			this.fetchCurrentUser();
		},
		methods : {
			fetchCurrentUser(){
				axios.get('current/user').then(response => {
					console.log(response);
					this.message.sender_id = response.data.id;
				});
			},
			sendMessage(){
				axios.post('message/post', this.message).then(response => {
					console.log(response);
					if(response.data.errors){
						if(response.data.errors.receiver_email){
							swal('Oops!', 'Please Enter Receiver\'s Email', 'error');
						}else if(response.data.errors.title){
							swal('Oops!', 'Please Enter a Title for the Message', 'error');	
						}else if(response.data.errors.body){
							swal('Oops!', 'Your message is empty', 'error');	
						}
						
					}else if(response.data.status){
						if(response.data.status == 404){
							swal('Oops!', 'Receiver User not Found!', 'error');
						}else if(response.data.status == 200){
							swal('Great!', 'Your message is sent successfully', 'success');
						}
					}

					this.message.receiver_email=  '';
					this.message.title = '';
					this.message.body = '';
				});
			}
		}
	}
</script>