import VueRouter from 'vue-router';

let routes = [
	{
		path : '/',
		name : 'Search',
		component : require('./components/Search.vue'),
		props : true
	},
	{
		path : '/user/:username',
		name : 'SearchUser',
		component : require('./components/SearchUser.vue'),
		props : true
	},
	

];


export default new VueRouter ({
	routes
});