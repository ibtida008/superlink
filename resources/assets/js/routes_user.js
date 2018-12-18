import VueRouter from 'vue-router';

let routes = [
	{
		path : '/',
		name : 'Profile',
		component : require('./components/Profile.vue'),
		props : true
	},
	{
		path : '/inbox',
		name : 'Inbox',
		component : require('./components/Inbox.vue'),
		props : true
	},
	{
		path : '/sent',
		name : 'Sent',
		component : require('./components/Sent.vue'),
		props : true
	},
	{
		path : '/createMessage',
		name : 'CreateMessage',
		component : require('./components/CreateMessage.vue'),
		props : true
	},
	{
		path : '/myLinks',
		name : 'My Links',
		component : require('./components/MyLinks.vue'),
		props : true
	},

];


export default new VueRouter ({
	routes
});