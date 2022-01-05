<script>
	import 'bootstrap/dist/css/bootstrap.min.css';
	import 'font-awesome/css/font-awesome.min.css';
  import '../../stylesheets/styles.css';
  import '../../stylesheets/login.css';
  import { onMount } from 'svelte';
	import { Router, Route } from 'svelte-routing';
  import Index from '../Pages/Login/Index.svelte';
  import SignIn from '../Pages/Login/SignIn.svelte';
  import Redirect404 from '../Pages/Error/Redirect404.svelte';
  import ResetPassword from '../Pages/Login/ResetPassword.svelte';
  export let url = '';
  export let basepath = '/login';

  onMount(() => {
		console.log('login');
	});
</script>

<Router url="{url}" basepath="{basepath}">
  <div>
    <Route path="/" component="{Index}" />
    <Route path="/sign-in" component="{SignIn}" />
    <Route path="/reset-password" component="{ResetPassword}" />
    <Route path="/*" component="{Redirect404}" />
  </div>
</Router>

<style>

</style>