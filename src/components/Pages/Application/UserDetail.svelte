<script>
  import { onMount } from 'svelte';
  import InputText from '../../Widgets/InputText.svelte';
  import InputPassword from '../../Widgets/InputPassword.svelte';
  import UploadFile from '../../Widgets/UploadFile.svelte';
  import AlertMessage from '../../Widgets/AlertMessage.svelte';
  import { alertMessage as alertMessageStore} from '../../Stores/alertMessage.js';
  import { getUserById, saveUserDetail } from '../../../services/user_service.js';
  import random from '../../Helpers/random.js';
  export let id;
  export let disabled = false;
  let disabledInCreate = true;
  let title = '';
  let alertMessage = null;
  let alertMessageProps = {};
  let user = ''; let inputUser; let userValid = false;
  let password = ''; let inputPassword; let passwordValid = false;
  let email = ''; let inputEmail; let emailValid = false;
  let imageURL = 'E';
  let imageUploadFile = '';
  let baseURL = BASE_URL;
  let staticURL = STATIC_URL;
  
  onMount(() => {    
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    // ajax
    if(id === undefined){
      title = 'Crear Usuario';
      id = 'E';
      disabledInCreate = true;
    }else{
      title = 'Editar Usuario';
      loadDetail(id);
      disabledInCreate = false;
    }
  });

  const launchAlert = (event, message, type) => {
    alertMessage = null;
    alertMessage = AlertMessage;
    alertMessageProps = {
      message: message,
      type: type,
      timeOut: 5000
    }
  };

  const saveDetail = () => {
    // run validations
    inputUser.validate();
    inputPassword.validate();
    inputEmail.validate();
    // check image url
    if(imageURL == 'E'){
      imageURL = 'assets/img/default-user.png'
    }
    // check if true
    if(userValid && passwordValid && emailValid) {
      var params = {
        id: id,
        user: user,
        password: password,
        email: email,
        url_picture: imageURL,
      };
      saveUserDetail(params).then((resp) => {
        var data = resp.data;
        if(data != ''){
          id = data;
          title = 'Editar Usuario';
          launchAlert(null, 'Se ha creado un nuevo usuario', 'success');
          disabledInCreate = false;
        }else{
          launchAlert(null, 'Se ha editado un usuario', 'success');
        }
      }).catch((resp) =>  {
        if(resp.status == 404){
          launchAlert(null, 'Recurso guardar detalle de usuario no existe en el servidor', 'danger');
        }else{
          launchAlert(null, 'Ocurrió un error en guardar los datos del usuario', 'danger');
        }
      })
    }
  };

  const loadDetail = (id) => {
    getUserById(id).then((resp) => {
      var data = resp.data;
      user = data.user;
      email = data.email;
      password = random(20);
    }).catch((resp) =>  {
      disabled = true;
      if(resp.status == 404){
        launchAlert(null, 'Usuario a editar no existe', 'warning');
      }else{
        launchAlert(null, 'Ocurrió un error en obtener los datos del usuario', 'danger');
      }
    })
  };

  const generatePassword = () => {

  };

  const resendPassword = () => {

  };
  const reactivateAccount = () => {

  };
</script>

<svelte:head>
	<title>{title}</title>
</svelte:head>

<div class="container">
	<div class="row">
		<svelte:component this={alertMessage} {...alertMessageProps} />
		<div class="col-lg-12 page-header">
			<h2>{title}</h2>
		</div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <InputText 
        label={'Usuario'}
        bind:value={user}
        placeholder={'Nombre de usuario'} 
        disabled={disabled}
        validations={[
          {type:'notEmpty', message: 'Debe de ingresar un nombre usuario'},
          {type:'maxLength', length: 25, message: 'Nombre máximo 25 letras'},
        ]}
        bind:valid={userValid} 
        bind:this={inputUser}
      />
    </div>
    <div class="col-md-2">
      <InputPassword 
        label={'Contraseña'}
        bind:value={password}
        placeholder={'Contraseña de usuario'} 
        disabled={disabled}
        validations={[
          {type:'notEmpty', message: 'Debe de ingresar una contraseña de usuario'},
          {type:'maxLength', length: 15, message: 'Nombre máximo 15 letras'},
        ]}
        bind:valid={passwordValid} 
        bind:this={inputPassword}
      />
    </div>
    <div class="col-md-3">
      <InputText 
        label={'Correo'}
        bind:value={email}
        placeholder={'Correo de usuario'} 
        disabled={disabled}
        validations={[
          {type:'notEmpty', message: 'Debe de ingresar un correo de usuario'},
          {type:'email', message: 'Debe de ingresar un correo válido'},
          {type:'maxLength', length: 25, message: 'Correo máximo 30 letras'},
        ]}
        bind:valid={emailValid} 
        bind:this={inputEmail}
      />
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <UploadFile bind:this={imageUploadFile} 
          label={'Selecionar Archivo'}
          fileName={'file'} 
          url={`${baseURL}upload`} 
          baseUrlFile={`${staticURL}`}  
          validationSize={
            {size: 2.6, message: 'Máximo 2 MB'}
          }
          validationExtension={
            {allowed: ['image/png', 'image/jpg', 'image/jpeg'], message: 'Sólo Imágenes'}
          }
          disabled={disabled}
          bind:urlFile={imageURL}
        />
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 pull-right">
      <button class="btn btn-success btn-actions" disabled="{disabled}" on:click="{saveDetail}"><i class="fa fa-check" aria-hidden="true"></i>
        {title}</button>
      <button class="btn btn-secondary btn-actions m-right" disabled="{disabled}" on:click="{generatePassword}"><i class="fa fa-random" aria-hidden="true"></i>
        Generar Contraseña</button>
      <button class="btn btn-info btn-actions m-right" disabled="{disabled}" on:click="{resendPassword}"><i class="fa fa-star-half-o" aria-hidden="true"></i>
        Restablecer Contraseña </button>
      <button class="btn btn-warning btn-actions m-right" disabled="{disabled}" on:click="{reactivateAccount}"><i class="fa fa-undo" aria-hidden="true"></i>
          Reenviar Activación de Cuenta</button>
    </div>
  </div>
</div>

<style>
  .row > .col-md-12{
    margin-bottom: 10px;
  }

  .btn-actions{
    float:right;
    margin-top:15px;
  }

  .m-right{
    margin-right: 10px;
  }
</style>