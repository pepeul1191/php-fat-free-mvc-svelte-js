<script>
  import { navigate } from 'svelte-routing';
  import { onMount } from 'svelte';

  let user;
  let email;

  onMount(() => {
		console.log('sign in');
	});
</script>

<svelte:head>
	<title>Crear Usuario</title>
</svelte:head>

<form class="form-signin" action="/login/create-account" method="post" id="sign-in">
  <h1 class="h3 mb-3 font-weight-normal">Crear Cuenta</h1>
  <input type="hidden" name="key" value="value">
  <span class="extraData"></span>
  <!--USER -->
  <label for="user" class="sr-only">User</label>
  <input type="text" id="user" class="form-control" placeholder="Usuario" required="" autofocus="" name="user" bind:value={user}>
  <!--EMAIL -->
  <label for="email" class="sr-only">email</label>
  <input type="email" id="email" class="form-control" placeholder="Correo" required="" autofocus="" name="email" bind:value={email}>
  <!--CSRF -->

  <!--PASS -->
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required="" name="password">
  <!--PASS -->
  <label for="inputPassword2" class="sr-only">Password</label>
  <input type="password" id="inputPassword2" class="form-control" placeholder="Repetir Contraseña" required="" name="password2">
  <!--MESSAGE-->
  <p class="message" style="margin-top:10px;" id="message"></p>
  <!--BUTTON -->
  <button class="btn btn-lg btn-primary btn-block" type="submit">
    Crear Usuario
  </button>
  <!--FooTER LOGIN NAV -->
  <div class="link-login">
    <a class="" href="/login?user={user}&email={email}" on:click|preventDefault={() => {navigate(`/login?user=${user}&email=${email}`)}}>
      Ingresar
    </a>
    <a id="forgotpassword" class="pull-right" href="/login/reset-password" on:click|preventDefault={() => {navigate('/login/reset-password')}}>
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