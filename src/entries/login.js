import Login from '../components/Layouts/Login.svelte';

const app = new Login({
	target: document.body,
	props: {
		name: 'world'
	}
});

export default app;