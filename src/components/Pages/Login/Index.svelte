<script>
  import { navigate } from 'svelte-routing';
  import { onMount } from 'svelte';
  import queryString from 'query-string';
  import { CSRF } from '../../Stores/csrf.js';
  export let location;
  let message = '';
  let messageColor = '';
  let queryParams;
  $: queryParams = queryString.parse(location.search);

  onMount(() => {
		// console.log('index');  
    // console.log(CSRF);
    // console.log(queryParams);
    if(queryParams.error == 'csrf-mismatch'){
      message = 'Error de autenticación CSRF';
      messageColor = 'text-danger';
    }else if(queryParams.error == 'user-pass-mismatch'){
      message = 'Usuario y contraseña incorrectos';
      messageColor = 'text-danger';
    }else{
      message = '';
      messageColor = '';
    }
	});
</script>

<svelte:head>
	<title>Bienvenido</title>
</svelte:head>

<form class="form-signin" action="/login" method="post" id="login">
  <h1 class="h3 mb-3 font-weight-normal">Bienvenido</h1>
  <span class="extraData"></span>
  <!--USER -->
  <label for="user" class="sr-only">User</label>
  <input type="text" id="user" class="form-control" placeholder="Usuario" required="" autofocus="" name="user">
  <!--CSRF -->
  <input type="hidden" id="csrf" class="form-control" required="" autofocus="" name="{CSRF.key}" value="{CSRF.value}">
  <!--PASS -->
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required="" name="password">
  <!--MESSAGE-->
  <p class="message {messageColor}" style="margin-top:10px;" id="message">{message}</p>
  <!--BUTTON -->
  <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-bottom: 1.5px;">
    Ingresar
  </button>
  <button class="btn btn-lg btn-success btn-block" type="submit" disabled>
    <i class="fa fa-google" aria-hidden="true"></i>
    Ingresar con Google
  </button>
  <!--FooTER LOGIN NAV -->
  <div class="link-login">
    <a class="" href="/login/sign-in" on:click|preventDefault={() => {navigate('/login/sign-in')}}>
      Registrarse
    </a>
    <a id="forgotpassword" class="pull-right" href="/login/reset-password"  on:click|preventDefault={() => {navigate('/login/reset-password')}}>
      Olvidó su Contraseña
    </a>
  </div>
  <p class="mt-5 mb-3 text-muted">Powered By <a href="http://softweb.pe/"> Softtware Web Perú</a> © 2017-2018</p>
</form>

<style>
.mt-5 {
  margin-top: 1.5rem !important;
}
</style>