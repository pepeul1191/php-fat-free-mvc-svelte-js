<script>
  import { onMount } from 'svelte';
  import InputText from '../../Widgets/InputText.svelte';
  import TextArea from '../../Widgets/TextArea.svelte';
  import DataTable from '../../Widgets/DataTable.svelte';
  import AlertMessage from '../../Widgets/AlertMessage.svelte';
  import { alertMessage as alertMessageStore} from '../../Stores/alertMessage.js';
  import { getSystemById, saveSystemDetail } from '../../../services/system_service.js';
  export let id;
  export let disabled = false;
  let disabledInCreate = true;
  let title = '';
  let alertMessage = null;
  let alertMessageProps = {};
  let name = ''; let inputName; let nameValid = false;
  let description = ''; let inputDescription; let descriptionValid = false;
  let repository = ''; let inputRepository; let repositoryValid = false;
  let branch = ''; let inputBranch; let branchValid = false;
  let key = ''; let inputKey; let keyValid = false;
  let value = ''; let inputValue; let valueValid = false;
  
  onMount(() => {    
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    // ajax
    if(id === undefined){
      title = 'Crear Sistema';
      id = 'E';
      disabledInCreate = true;
    }else{
      title = 'Editar Sistema';
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
    inputName.validate();
    inputDescription.validate();
    inputRepository.validate();
    inputBranch.validate();
    inputKey.validate();
    inputValue.validate();
    // check if true
    if(nameValid && descriptionValid && repositoryValid && branchValid && keyValid && valueValid) {
      var params = {
        id: id,
        name: name,
        description: description,
        repository: repository,
        branch: branch,
        key: key,
        value: value,
      };
      saveSystemDetail(params).then((resp) => {
        var data = resp.data;
        if(data != ''){
          id = data;
          title = 'Editar Sistema';
          launchAlert(null, 'Se ha creado un nuevo sistema', 'success');
          disabledInCreate = false;
        }else{
          launchAlert(null, 'Se ha editado un sistema', 'success');
        }
      }).catch((resp) =>  {
        if(resp.status == 404){
          launchAlert(null, 'Recurso guardar detalle de sistema no existe en el servidor', 'danger');
        }else{
          launchAlert(null, 'Ocurrió un error en guardar los datos del sistema', 'danger');
        }
      })
    }
  };

  const loadDetail = (id) => {
    getSystemById(id).then((resp) => {
      var data = resp.data;
      description = data.description;
      repository = data.repository;
      branch = data.branch;
      key = data.key;
      name = data.name;
      value = data.value;
    }).catch((resp) =>  {
      disabled = true;
      if(resp.status == 404){
        launchAlert(null, 'Sistema a editar no existe', 'warning');
      }else{
        launchAlert(null, 'Ocurrió un error en obtener los datos del sistema', 'danger');
      }
    })
  };

  const generateKeys = () => {
    var characters = 'abcdefghijklmnopqrstuvwxyz';
    var charactersLength = characters.length;
    key = '';
    value = '';
    for ( var i = 0; i < 15; i++ ) {
      if (i < 10){
        key += characters.charAt(Math.floor(Math.random() * charactersLength));
      }
      value += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
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
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-12">
          <InputText 
            label={'Nombre'}
            bind:value={name}
            placeholder={'Nombre de sistema'} 
            disabled={disabled}
            validations={[
              {type:'notEmpty', message: 'Debe de ingresar un nombre'},
              {type:'maxLength', length: 25, message: 'Nombre máximo 25 letras'},
            ]}
            bind:valid={nameValid} 
            bind:this={inputName}
          />
        </div>
        <div class="col-md-12">
          <InputText 
            label={'Repositorio'}
            bind:value={repository}
            placeholder={'Repositorio de sistema'} 
            disabled={disabled}
            validations={[
              {type:'notEmpty', message: 'Debe de ingresar un repositorio'},
              {type:'maxLength', length: 50, message: 'Repositorio máximo 50 letras'},
            ]}
            bind:valid={repositoryValid} 
            bind:this={inputRepository}
          />
        </div>
        <br>
      </div>
      <div class="row">
        <div class="col-md-4">
          <InputText 
            label={'Rama'}
            bind:value={branch}
            placeholder={'Rama de sistema'} 
            disabled={disabled}
            validations={[
              {type:'notEmpty', message: 'Debe de ingresar una rama'},
              {type:'maxLength', length: 15, message: 'Rama máximo 15 letras'},
            ]}
            bind:valid={branchValid} 
            bind:this={inputBranch}
          />
        </div>
        <div class="col-md-4">
          <InputText 
            label={'Llave'}
            bind:value={key}
            placeholder={'Llave de sistema'} 
            disabled={true}
            validations={[
              {type:'notEmpty', message: 'Debe de ingresar un llave'},
              {type:'maxLength', length: 10, message: 'Llave máximo 10 letras'},
            ]}
            bind:valid={keyValid} 
            bind:this={inputKey}
          />
        </div>
        <div class="col-md-4">
          <InputText 
            label={'Valor de llave'}
            bind:value={value}
            placeholder={'Valor de llave de sistema'} 
            disabled={true}
            validations={[
              {type:'notEmpty', message: 'Debe de ingresar un v alor de llave'},
              {type:'maxLength', length: 15, message: 'Valor de llave máximo 15 letras'},
            ]}
            bind:valid={valueValid} 
            bind:this={inputValue}
          />
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-12">
          <TextArea 
            label={'Descripción'}
            bind:value={description}
            placeholder={'Descripción de sistema'} 
            disabled={disabled}
            validations={[
              {type:'notEmpty', message: 'Debe de ingresar una descripción'},
              {type:'maxLength', length: 25, message: 'Descripción máximo 100 letras'},
            ]}
            bind:valid={descriptionValid} 
            bind:this={inputDescription}
            rows=8
          />
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 pull-right">
      <button class="btn btn-success" disabled="{disabled}" on:click="{saveDetail}" style="margin-left:10px;"><i class="fa fa-check" aria-hidden="true"></i>
        {title}</button>
      <button class="btn btn-secondary" disabled="{disabled}" on:click="{generateKeys}"><i class="fa fa-random" aria-hidden="true"></i>
        Generar LLaves</button>
    </div>
  </div>
</div>

<style>
  .row > .col-md-12{
    margin-bottom: 10px;
  }

  .btn{
    float:right;
    margin-top:7px;
  }
</style>