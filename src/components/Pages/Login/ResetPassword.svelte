<script>
  import { navigate } from 'svelte-routing';
  import { onMount } from 'svelte';

  onMount(() => {
		console.log('reset password');
	});
</script>

<svelte:head>
	<title>Restablecer Constraseña</title>
</svelte:head>

<form class="form-signin" action="/reset-password" method="post" id="reset-password">
  <h1 class="h3 mb-3 font-weight-normal">Recuperar Contraseña</h1>
  <input type="hidden" name="key" value="value">
  <span class="extraData"></span>
  <!--EMAIL -->
  <label for="email" class="sr-only">email</label>
  <input type="text" id="email" class="form-control" placeholder="Correo" required="" name="email">
  <!--CSRF -->

  <!--MESSAGE-->
  <p class="message" style="margin-top:10px;" id="message"></p>
  <!--BUTTON -->
  <button class="btn btn-lg btn-primary btn-block" type="submit" disabled>
    Enviar Solicitud
  </button>
  <!--FooTER LOGIN NAV -->
  <div class="link-login">
    <a class="" href="/login" on:click|preventDefault={() => {navigate('/login')}}>
      Ingresar
    </a>
    <a class="pull-right" href="/login/sign-in" on:click|preventDefault={() => {navigate('/login/sign-in')}}>
      Registrarse
    </a>
    <a id="forgotpassword" class="pull-right" href="/login/reset-passwordsss"  on:click|preventDefault={() => {navigate('/login/reset-passwordssss')}}>
      Crear usuarios XD
    </a>
  </div>
  <p class="mt-5 mb-3 text-muted">Powered By <a href="http://softweb.pe/"> Softtware Web Perú</a> © 2017-2018</p>
</form>

<style>
.mt-5 {
  margin-top: 1.5rem !important;
}
</style>