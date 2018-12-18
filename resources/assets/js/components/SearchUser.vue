<template>
	<div class="row">
		
		<div class="col-sm-12" style="padding-top:30px" v-if="showProfile">
			<h2>User Profile</h2>
			<hr>
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row" style="padding:40px;">
							<div class="col-sm-2">
								<img :src="user.profile_picture" class="img-responsive" style="height:auto; width:100%;">
							</div>
							<div class="col-sm-4">
								<p v-if="user.first_name">First Name</p>
								<p class="profile-info-text" >{{user.first_name}}</p>

								<p v-if="user.last_name">Last Name</p>
								<p class="profile-info-text" >{{user.last_name}}</p>

								
								<p v-if="user.email">Email</p>
								<p class="profile-info-text" >{{user.email}}</p>

								<p v-if="user.bio">Bio</p>
								<p class="profile-info-text" >{{user.bio}}</p>

								
								<p v-if="user.city">City</p>
								<p class="profile-info-text" >{{user.city}}</p>

								
								<p v-if="user.state">State</p>
								<p class="profile-info-text" >{{user.state}}</p>

								
								<p v-if="user.country">Country</p>
								<p class="profile-info-text" >{{user.country}}</p>
								
								
								<p v-if="user.video_link">Video Link</p>
								<iframe :src="user.video_link" width="400px" height="225px" v-if="user.video_link"></iframe>
								
							</div>
							<div class="col-sm-6">
								<h4>Links</h4>
								<hr>
								<div class="row">
									<div class="col-sm-12" v-for="link in links">
										<div class="row">
											<div class="col-sm-2">
												<img :src="link.website_logo" class="img-responsive" style="height:auto; width:100%;">
											</div>
											<div class="col-sm-3">
												<p>Website</p>
												<h5>{{link.website_name}}</h5>
											</div>
											<div class="col-sm-3">
												<p>Title</p>
												<h5>{{link.title}}</h5>
											</div>
											<div class="col-sm-4">
												<p>Link</p>
												<h5>{{link.url}}</h5>
												<h5><a :href="'https://' + link.url" target="_blank" @click="updateHits(link.id)">Go to Link</a></h5>
											</div>
										</div>	
									</div>
								</div>
							</div>
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
		props : ['username'],
		data(){
			return{
				showProfile : false,
				//username : '',
				user : {},
				links : {}
			}
		},
		mounted(){
			this.searchUser();
		},
		methods: {
			searchUser(){
				axios.get('search/user/' + this.username).then(response => {
					console.log(response);
					this.showProfile = true;
					if(response.status){
						if(response.status == 404){
							swal('Sorry', 'No user was found', 'error');
							this.showProfile = false;
						}
					}else{

					}
					
					this.user = response.data;
					this.fetchLinks();
				});
			},

			fetchLinks(){
				axios.get('links/get/' + this.user.id).then(response => {
					console.log(response);
					this.links = response.data;
				});
			},
			updateHits(id){
				axios.get('link/update/hits/' + id).then(response => {
					console.log(response);
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