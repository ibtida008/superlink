<template>
	<div class="row">
		<h2>All Users</h2>
		<hr>
		<div class="row">
			<div class="col-sm-2" v-for="user in users">
				<div class="panel panel-default">
					<div class="panel-body center">
						<img class="img-circle" style="height:100px; margin-bottom: 20px;" :src="user.profile_picture">
						<p>Username</p>
						<h4>{{user.username}}</h4>
						<button class="btn btn-default" v-show="user.id == currentUser.id" @click="goToMyProfile"><i class="fa fa-user" style="margin-right:10px;"></i>Admin</button>
						<button class="btn btn-danger" @click="unacceptUser(user.id)" v-show="user.id != currentUser.id">Unaccept</button>
						<button class="btn btn-danger" @click="deleteUser(user.id)" v-show="user.id != currentUser.id">Delete</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import swal from 'sweetalert';
	export default {
		data(){
			return{
				currentUser : {},
				users : {}
			}	
		},
		created(){
			this.fetchCurrentUser();
		},
		mounted(){
			this.fetchUsers();
		},
		methods: {
			fetchCurrentUser(){
				axios.get('current/user').then(response => {
					console.log(response);
					this.currentUser = response.data;
					console.log(this.currentUser.id);
				});
			},
			fetchUsers(){
				axios.get('users').then(response => {
					this.users = response.data;
				});
			},
			unacceptUser(id){
				axios.get('user/unaccept/' + id).then(response => {
					console.log(response);
					if(response.data.status == 200){
						swal("Great!", "The user is now in the pending list", 'success');
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
						swal("Great!", "The user is deleted successfully", 'success');
					}else{
						swal("Oops!", 'Something went wrong. Please try again', 'error');
					}
					this.fetchUsers();
				});
			},
			goToMyProfile(){
				this.$router.push('/');
			}
		}
	}
</script>