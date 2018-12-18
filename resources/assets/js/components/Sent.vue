<template>
	<div class="row">
		<div class="col-sm-2">
			<button class="btn btn-primary" @click="createMessage">Write a Message</button>
		</div>
		<div class="col-sm-8">
			<h4>Sent Messages</h4>
			<hr>
			<div class="row center" v-if="sentMessages.length == 0">
				<h3>No Sent Messages</h3>
			</div>
			<div class="panel panel-default" v-for="message in sentMessages">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-8">
							<h4>Sender</h4>
							<p>{{message.receiver_email}}</p>
							<h4>Title</h4>
							<p>{{message.title}}</p>
							<h4>Message</h4>
							<p>{{message.body}}</p>	
						</div>
						<div class="col-sm-4" style="text-align:right">
							<p>Arrived {{message.time}}</p>
							<button class="btn btn-danger" @click="deleteThis(message.id)">Delete</button>
						</div>
					</div>
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
				currentUser : {},
				sentMessages : {}
			}
		},
		mounted(){
			this.fetchCurrentUser();
			
		},
		methods : {
			fetchCurrentUser(){
				axios.get('current/user').then(response => {
					console.log(response);
					this.currentUser = response.data;
					this.fetchSentMessages();
				});
			},

			fetchSentMessages(){
				axios.get('messages/sent/' + this.currentUser.id).then(response => {
					this.sentMessages = response.data;
					console.log(this.sentMessages);
				});
			},

			deleteThis(id){
				axios.get('messages/sender/delete/' + id).then(response => {
					console.log(response);
					if(response.status == 200){
						swal('Great!', 'Message deleted successfully', 'success');
					}else{
						swal('Oops!', 'Something went wrong. Please try again.', 'error');
					}
					this.fetchSentMessages();
				});
			},

			createMessage(){
				this.$router.push('createMessage');
			}
		}
	}
</script>