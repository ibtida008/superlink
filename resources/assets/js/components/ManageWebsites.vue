<template>
	<div class="row">
		<div class="col-sm-3">
			<button class="btn btn-primary" v-if="!formShow" @click="formShow = !formShow">Create New Website</button>
			<div class="panel panel-default" v-if="formShow">
				<div class="panel-body">
					<h4>Create New Website</h4>
					<hr>
					<div class="form-group">
						<label>Website Name</label>
						<input type="text" class="form-control" v-model="website.website_name">
					</div>
					<div class="form-group">
						<label>URL Address</label>
						<small>(Example : www.your_website.com)</small>
						<input type="text" class="form-control" v-model="website.website_url">
					</div>
					<form class="image-form" ref="uploadForm" enctype="multipart/form-data" v-on:submit.prevent>
							<div class="form-group" style="margin-top:10px; padding-right:5px;">
								<label>Upload Logo</label>
								<input name="website_logo" type="file" @change="upload" class="form-control">
							</div>
						</form>
					<button class="btn btn-success" @click="postWebsite">Submit</button>
					<button class="btn btn-danger" @click="formShow = !formShow">Cancel</button>
				</div>
			</div>
		</div>
		<div class="col-sm-9">
			<h4>Website List</h4>
			<hr>
			<div class="row">
				<div class="col-sm-12 center" v-if="websites.length == 0">
					<h4>No Websites Available</h4>
					<h1>Hurry! Create New Website</h1>
				</div>
				<div class="col-sm-3" v-for="website in websites">
					<div class="panel panel-default">
						<div class="panel-body center">
							<img :src="website.website_logo" class="img-thumbnail" style="height:100px; margin-bottom: 20px;">
							<h4>{{website.website_name}}</h4>
							<h5 v-if="website.website_url"><a :href="'https://' + website.website_url" target="_blank">Go to Website</a></h5>
							<h5 v-if="!website.website_url"><a :href="'https://www.google.com/search?q=' + website.website_name" target="_blank">Search in Google</a></h5>
							<button class="btn btn-danger" @click="deleteWebsite(website.id)">Delete</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		data(){
			return{
				formShow : false,
				formData : null,
				websites : {},
				website : {
					id : '',
					website_name : '',
					website_url : ''
				}
			}
		},
		created(){
			this.fetchWebsites();
		},
		methods : {
			fetchWebsites(){
				axios.get('websites').then(response => {
					console.log(response);
					this.websites = response.data;
				});
			},
			upload() {
				this.formData = new FormData(this.$refs.uploadForm);
				console.log(this.$refs.uploadForm, this.formData);
				
			},
			postWebsite(){
				console.log(this.formData);
				axios.post('website/logo/upload', this.formData).then(response => {
					console.log(response);
					if(!response.data.id){
						swal("Oops!", "Please upload a valid image", 'error');
					}
					this.website.id = response.data.id;
					console.log(this.website.id);
					this.postWebsiteData();
				});
			},
			postWebsiteData(){
				console.log(this.website);
				axios.post('website/post', this.website).then(response => {
					console.log(response);
					if(response.data.errors){
						swal("Oops", "Website name is required", 'error');
					}else{
						swal("Great", 'Website has been added successfully', 'success');
						this.website.id = '';
						this.website.website_name = '';
						this.website.website_url = '';
						this.formData = null;
						this.formShow = false;
						this.fetchWebsites();
					}
					
				});
			},
			deleteWebsite(id){
				axios.get('website/delete/' + id).then(response => {
					console.log(response);
					if(response.data.status == 200){
						swal("Great!", "The website has been deleted", 'success');
					}else{
						swal("Oops!", 'Something went wrong. Please try again', 'error');
					}
					this.fetchWebsites();
				});
			},
		}
	}
</script>

<style>
	a:link {
		text-decoration: none;
	}
</style>