<template>
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="row center">
				<h3>Search User</h3>
				<hr>
				<div class="form-group">
					<input type="text" class="form-control" v-model="username">
				</div>
				<button class="btn btn-primary" @click="searchUser">Search</button>
			</div>
		</div>
		<hr>
	</div>
</template>

<script>
	export default{
		data(){
			return{
				showProfile : false,
				username : '',
				user : {},
				links : {}
			}
		},
		methods: {
			searchUser(){
				this.$router.push('user/' + this.username);
				// axios.get('search/user/' + this.username).then(response => {
				// 	console.log(response);
				// 	this.showProfile = true;
				// 	this.user = response.data;
				// 	this.fetchLinks();
				// });
			},

			fetchLinks(){
				axios.get('links/get/' + this.user.id).then(response => {
					console.log(response);
					this.links = response.data;
				});
			}
		}
	}
</script>

<style>
	a:link{
		text-decoration: none;
	}
</style>