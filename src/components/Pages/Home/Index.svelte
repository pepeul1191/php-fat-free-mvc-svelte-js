<script>
	import DemoForm from './../../Forms/DemoForm.svelte';
  import { onMount, createEventDispatcher } from 'svelte';
	import Autocomplete from './../../Widgets/Autocomplete.svelte';
	import UploadFile from './../../Widgets/UploadFile.svelte';
  import Calendar from './../../Widgets/Calendar.svelte';
  import Bar from './../../Modals/Bar.svelte';
  import { modal } from '../../Stores/modal.js';
  import { alertMessage as alertMessageStore} from '../../Stores/alertMessage.js';
  import AlertMessage from '../../Widgets/AlertMessage.svelte';
  let alertMessage = null;
  let alertMessageProps = {};

  const dispatch = createEventDispatcher();

  onMount(() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
  });

  const showModal = () => {
    modal.set(Bar);
    dispatch('showModal', {
			param1: 'Hello!'
		});
  };

  const launchAlert = (event, type) => {
    alertMessage = null;
    alertMessage = AlertMessage;
    alertMessageProps = {
      message: 'hola mundo',
      type: type,
      timeOut: 3000
    }
  };
</script>

<svelte:head>
	<title>Home</title>
</svelte:head>

<div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
      <UploadFile 
        label={'Selecionar Archivo'}
        fileName={'file'} 
        url={`${BASE_URL}upload`} 
        baseUrlFile={`${BASE_URL}`}  
        chooserButton={
          {label: 'Search', icon: 'fa-grav', class: 'btn-danger'}
        }
        uploadButton={
          {label: 'Upload', icon: 'fa-shower', class: 'btn-danger'}
        }
        viewButton={
          {label: 'param3', icon: 'fa-vcard', class: 'btn-danger', display: false}
        } 
        validationSize={
          {size: 2.6, message: 'Máximo 2 MB'}
        }
        validationExtension={
          {allowed: ['application/pdf'], message: 'Sólo PDFs'}
        }
        />
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <UploadFile />
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <Autocomplete 
          label={'Buscar Distritos'} 
          placeholder={'Ingrese distrito'} 
          url={`${BASE_URL}district/search`} 
        />
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <Autocomplete 
          url={`${BASE_URL}district/search`} 
        />
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <button class="btn btn-info" on:click="{showModal}">Modal BAR</button>
      </div>
    </div>
    <div class="col-md-3">
      <Calendar />
    </div>
    <DemoForm />
    <div class="row" style="padding-top:20px;">
      <div class="col-md-4">
        <button class="btn btn-primary" on:click|preventDefault={(event) => launchAlert(event,'primary')}>Demo Alert Primary</button>
      </div>
      <div class="col-md-4">
        <button class="btn btn-secondary" on:click|preventDefault={(event) => launchAlert(event,'secondary')}>Demo Alert Secondary</button>
      </div>
      <div class="col-md-4">
        <button class="btn btn-danger" on:click|preventDefault={(event) => launchAlert(event,'danger')}>Demo Alert Danger</button>
      </div>
    </div>
    <AlertMessage message={'hola mundo'} type={'warning'} timeOut=5000 />
    <svelte:component this={alertMessage} {...alertMessageProps} />
  </div>
</div>

<style>
</style>