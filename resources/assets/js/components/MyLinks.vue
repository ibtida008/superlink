<template>
	<div class="row">
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<h4>Create New Link</h4>
					<hr>
					<div class="form-group">
						<label>Title</label>
						<input type="text" class="form-control" v-model="myLink.title">
					</div>
					<div class="form-group">
						<label>Website</label>
						<select type="text" class="form-control" v-model="myLink.website_id">
							<option v-for="website in websites" :value="website.id">{{website.website_name}}</option>
						</select>
					</div>
					<div class="form-group">
						<label>Link URL</label><br>
						<small>(Example : www.your_website.com/your_id)</small>
						<input type="text" class="form-control" v-model="myLink.url">
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea rows="4" style="resize:vertical" type="text" class="form-control" v-model="myLink.description"></textarea>
					</div>
					<button class="btn btn-success" @click="postLink">Submit</button>
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<h3>My Links</h3>
			<hr>
			<div class="row">
				<div class="col-sm-12 center" v-if="links.length == 0">
					<h4>No Links Available</h4>
				</div>
				<div class="row myLink" v-for="link in links" style="padding-left:20px; padding-right:40px;">
					<div class="col-sm-2">
						<img :src="link.website_logo" class="img-responsive" style="height:auto; width:50%; margin-bottom: 20px;">
					</div>
					<div class="col-sm-2">
						<h4>Title</h4>
						<p>{{link.title}}</p>
					</div>
					<div class="col-sm-2">
						<h4>Website</h4>
						<p>{{link.website_name}}</p>
					</div>
					<div class="col-sm-2">
						<h4>Link</h4>
						<p>{{link.url}}</p>
					</div>
					<div class="col-sm-2">
						<h4>Description</h4>
						<p>{{link.description}}</p>
					</div>
					<div class="col-sm-1">
						<h4>Hits</h4>
						<p>{{link.hits}}</p>
					</div>
					<div class="col-sm-1">
						<button class="btn btn-danger" @click="deleteThis(link.id)">Delete Link</button>
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
				websites : {},
				myLink : {
					user_id : '',
					title : '',
					website_id : '',
					url : '',
					description : '',
					hits: 0
				},
				links : {}
			}
		},
		created(){
			this.fetchCurrentUser();
		},
		mounted(){
			this.fetchWebsites();
		},
		methods: {
			fetchCurrentUser(){
				axios.get('current/user').then(response => {
					this.myLink.user_id = response.data.id;
				});
				
			},
			fetchWebsites(){
				axios.get('websites').then(response => {
					console.log(response);
					this.websites = response.data;
					this.fetchMyLinks();
				});
			},
			postLink(){
				axios.post('link/post', this.myLink).then(response => {
					console.log(response);
					if(response.data.errors){
						if(response.data.errors.url){
							swal('Oops!', 'Please enter your link URL', 'error');
						}else if(response.data.errors.website_id){
							swal('Oops!', 'Please Select a Website', 'error');
						}else{
							swal('Oops!', 'Other error', 'error');
						}
					}else{
						swal("Great!", "New link has been added", 'success');
					}
					this.myLink.title = '';
					this.myLink.webite_id = '';
					this.myLink.url = '';
					this.myLink.description = '';
					this.fetchMyLinks();
				});
			},
			fetchMyLinks(){
				axios.get('links/get/' + this.myLink.user_id).then(response => {
					console.log(response);
					this.links = response.data;
				});
			},
			deleteThis(link_id){
				axios.get('link/delete/' + link_id).then(response => {
					console.log(response);
					if(response.data.status == 200){
						swal("Great!", "Your link has been deleted", 'success');
					}else{
						swal("Oops!", 'Something went wrong. Please try again', 'error');
					}
					this.fetchMyLinks();
				});
			}
		}
	}
</script>

<style>
	.link-icons{
		font-size : 18px;
		padding-left: 5px;
		padding-top: 5px;
		cursor: pointer;
	}

	#link-icon-edit:hover{
		color:teal;
	}

	#link-icon-delete:hover{
		color:red;
	}

	.myLink{
		background-color: #f0ffff;
		margin-left: 15px;
		margin-right: 5px;
		padding: 15px;
		margin-bottom: 10px;
		border-radius: 10px;
	}
</style>