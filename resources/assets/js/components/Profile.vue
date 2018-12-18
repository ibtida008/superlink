<template>
	<div class="row">
		<div class="col-sm-2">
			<div class="row center">
				<img id="profile-picture" :src="user.profile_picture" class="img-responsive" style="height:auto; width:100%;">
				<h2>{{user.username}}</h2>
				<h4>{{user.role}}</h4>
				<button class="btn btn-success" v-if="!showUpload" @click="showUpload = !showUpload">Change Photo</button>
				<div class="row center" v-if="showUpload">

					<form class="image-form" ref="uploadForm" enctype="multipart/form-data" v-on:submit.prevent>
						<div class="form-group" style="margin-top:10px; padding-right:5px;">
							<input name="profile_picture" type="file" @change="upload" class="form-control">
						</div>
						<h6>(Upload a square image for Perfection)</h6>
						<button class="btn btn-success" @click="uploadPhoto">Upload Photo</button>
						<button class="btn btn-danger" @click="showUpload = !showUpload">Cancel</button>
					</form>
				</div>
			</div>	
		</div>
		<div class="col-sm-8">
			<div class="panel panel-default">
				<div class="panel-body" style="padding-right:50px; padding-left:50px;">
					<div class="row">
						<h2>Profile Information</h2>

						<button class="btn btn-primary" v-if="!formShow" @click="showForm"><i class="fa fa-pencil" style="margin-right:5px;"></i>Edit Profile</button>
					</div>
					<hr>
					<div class="row">
						<div class="col-sm-6">
							<p v-if="user.first_name && !formShow">First Name</p>
							<p class="profile-info-text" v-if="!formShow">{{user.first_name}}</p>

							<div class="form-group input_personal" v-if="formShow">
								<label>First Name</label>
								<input type="text" class="form-control" v-model="user.first_name" placeholder="Your First Name">
							</div>
							<p v-if="user.last_name && !formShow">Last Name</p>
							<p class="profile-info-text" v-if="!formShow">{{user.last_name}}</p>

							<div class="form-group input_personal" v-if="formShow">
								<label>Last Name</label>
								<input type="text" class="form-control" v-model="user.last_name" placeholder="Your Last Name">
							</div>
							<p v-if="!formShow && user.email">Email</p>
							<p class="profile-info-text" v-if="!formShow">{{user.email}}</p>

							<p v-if="user.bio && !formShow">Bio</p>
							<p class="profile-info-text" v-if="!formShow">{{user.bio}}</p>

							<div class="form-group input_personal" v-if="formShow">
								<label>Bio</label>
								<textarea style="resize:vertical" type="text" class="form-control" v-model="user.bio" placeholder="Write about you"></textarea>
							</div>
							<p v-if="user.city && !formShow">City</p>
							<p class="profile-info-text" v-if="!formShow">{{user.city}}</p>

							<div class="form-group input_personal" v-if="formShow">
								<label>City</label>
								<input type="text" class="form-control" v-model="user.city" placeholder="Enter Your City">
							</div>
							<p v-if="user.state && !formShow">State</p>
							<p class="profile-info-text" v-if="!formShow">{{user.state}}</p>

							<div class="form-group input_personal" v-if="formShow">
								<label>State</label>
								<input type="text" class="form-control" v-model="user.state" placeholder="Enter Your State">
							</div>
							<p v-if="user.country && !formShow">Country</p>
							<p class="profile-info-text" v-if="!formShow">{{user.country}}</p>
							
							<div class="form-group input_personal" v-if="formShow">
								<label>Country</label>
								<input type="text" class="form-control" v-model="user.country" placeholder="Enter Your Country">
							</div>
							<p v-if="user.video_link && !formShow">Video Link</p>
							<iframe :src="user.video_link" width="400px" height="225px" v-if="!formShow && user.video_link"></iframe>
							<div class="form-group input_personal" v-if="formShow">
								<label>Video Link<br><span><small>(Youtube Embed URL)</small></span></label>
								<input type="text" class="form-control" v-model="user.video_link" placeholder="Example : www.youtube.com/embed/xxxxxxxx">
							</div>
							<button class="btn btn-success" v-if="formShow" @click="saveProfile">Save</button>
						</div>
						<div class="col-sm-6">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<style>
	
</style>

<script>
	
	import swal from 'sweetalert';
	export default{
		data(){
			return{
				formData : null,
				showUpload : false,
				formShow : false,
				user : {
					username : '',
					role: '',
					user_id : '',
					email : '',
					first_name : '',
					last_name : '',
					city : '',
					state : '',
					country : '',
					bio : '',
					video_link : '',
					profile_picture : ''
				},
			}
		},
		created(){
			this.fetchCurrentUser();
		},
		methods : {
			fetchCurrentUser(){
				axios.get('current/user').then(response => {
					this.user.user_id = response.data.id;
					this.user.role = response.data.role;
					this.user.username = response.data.username;
					this.user.email = response.data.email;
					this.fetchUserInfo();
				});
				
			},
			fetchUserInfo(){
				axios.get('user/info/get/' + this.user.user_id).then(response => {
					this.user.first_name = response.data.first_name;
					this.user.last_name = response.data.last_name;
					this.user.city = response.data.city;
					this.user.state = response.data.state;
					this.user.country = response.data.country;
					this.user.bio = response.data.bio;
					this.user.video_link = response.data.video_link;
					this.user.profile_picture = response.data.profile_picture;
				});
			},
			showForm(){
				this.formShow = true;
			},
			saveProfile(){
				axios.post('user/info/post', this.user).then(response => {
					console.log(response);
					swal("Great!", "Your profile has been updated", "success");
					this.formShow = false;
				});
			},
			upload() {
				this.formData = new FormData(this.$refs.uploadForm);
				console.log(this.$refs.uploadForm, this.formData);
				
			},
			uploadPhoto(){
				axios.post('user/photo/upload', this.formData).then(response => {
					if(response.data.errors) {
						console.log('error', response.data.errors);
						swal("Oops!", "Please upload an image file", "error");
					} else {
						console.log('success', response);
						this.user.profile_picture = response.data.image_file;
						swal("Great!", "Your profile picture is uploaded successfully", "success");
						this.showUpload = false;
					}
				});
			},
		}
	}
</script>