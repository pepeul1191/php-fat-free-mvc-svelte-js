import App from '../components/Layouts/App.svelte';
import 'bootstrap/js/dist/util';
import 'bootstrap/js/dist/dropdown.js';

const app = new App({
	target: document.body,
	props: {
		name: 'world'
	}
});

export default app;