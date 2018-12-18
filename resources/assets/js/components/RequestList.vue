<template>
	<div class="row">
		<h2>Requests</h2>
		<hr>
		<div class="row">
			<div class="col-sm-12 center" v-if="users.length == 0">
					<h4>No Pending Requests</h4>
					<h1>Relax Admin!</h1>
				</div>
			<div class="col-sm-2" v-for="user in users">
				<div class="panel panel-default">
					<div class="panel-body center">
						<img class="img-circle" style="height:100px; margin-bottom: 20px;" :src="user.profile_picture">
						<p>Username</p>
						<h4>{{user.username}}</h4>
						<button class="btn btn-success" @click="acceptUser(user.id)">Accept</button>
						<button class="btn btn-danger" @click="deleteUser(user.id)">Delete</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data(){
			return{
				users : {}
			}	
		},
		created(){
			this.fetchUsers();
		},
		methods: {
			fetchUsers(){
				axios.get('users/get/pending').then(response => {
					this.users = response.data;
				});
			},
			acceptUser(id){
				axios.get('user/accept/' + id).then(response => {
					console.log(response);
					if(response.data.status == 200){
						swal("Great!", "The user has been accepted", 'success');
					}else{
						swal("Oops!", 'Something went wrong. Please try again', 'error');
					}
					this.fetchUsers();
				});
			},
			deleteUser(id){
				axios.get('user/delete/' + id).then(response => {
					console.log(response);
					if(response.data.status == 200){
						swal("Great!", "The user deleted successfully", 'success');
					}else{
						swal("Oops!", 'Something went wrong. Please try again', 'error');
					}
					this.fetchUsers();
				});
			},
		}
	}
</script>