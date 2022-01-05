<svelte:options accessors={true} />
<script>
  import { afterUpdate, onMount,createEventDispatcher } from 'svelte';
  import axios from 'axios';
  import AlertMessage from './AlertMessage.svelte';
  import random from '../Helpers/random.js';
  import { alertMessage as alertMessageStore} from '../Stores/alertMessage.js';
  export let inputFileId;
  export let url = 'upload';
  export let urlFile = 'E';
  export let fileName = 'file';
  export let table = false;
  export let baseUrlFile = '/';
  export let tableKeyURL = 'url';
  export let label = 'Seleccionar Archivo';
  export let disabled = false;
  export let tableRecordId = null;
  export let tableRecordKey = null;
  export let validationSize = {
    size: 3, // MB, (MB = B / 1024^2) ... https://www.to-convert.com/en/computer/convert-byte-to-mb.php
    message: 'Archivo del tamaño supera el máximo permitido'
  }; 
  export let validationExtension = {
    allowed: ['image/jpeg', 'image/png', 'image/jpg', ], 
    message: 'Extensión del archivo no es válida'
  }; 
  export let valid = false;
  export let chooserButton= {
    label: 'Buscar', 
    icon: 'fa-search', 
    class: 'btn-primary'
  };
  export let uploadButton= {
    label: 'Subir', 
    icon: 'fa-upload', 
    class: 'btn-success'
  };
  export let viewButton= {
    label: 'Ver', 
    icon: 'fa-picture-o', 
    class: 'btn-secondary',
    display: 'true',
  };
  export let validationMessage = '';
  export let validationMessageClass = '';
  export let disabledUpload = true;
  export let disabledView = true;
  let inputFile;
  const dispatch = createEventDispatcher();

  afterUpdate(() => {
    if(urlFile != 'E'){
      disabledUpload = false;
      disabledView = false;
    }
  });

  const launchAlert = (props) => {
    alertMessageStore.set({
      component: AlertMessage,
      props: props
    })
  };

  onMount(() => {    
    inputFileId = random(20);
    if(table){
      chooserButton.class = 'btn-upload-table';
      uploadButton.class = 'btn-upload-table';
      viewButton.class = 'btn-upload-table';
    }else{
      chooserButton.class = `btn ${chooserButton.class}`;
      uploadButton.class = `btn ${uploadButton.class}`;
      viewButton.class = `btn ${viewButton.class}`;
    }
  });

  const clearMessage = () => {
    validationMessage = '';
    validationMessageClass = '';
  };

  const selectFile = () => {
    const el = document.getElementById(inputFileId);
    el.click();
  };

  const onFileSelected =(e)=>{
    inputFile = document.getElementById(inputFileId).files[0];
    if((inputFile.size / Math.pow(1024,2)) < validationSize.size){
      if(validationExtension.allowed.includes(inputFile.type)){
        disabledUpload = false;
        validationMessageClass = '';
        validationMessage = '';
      }else{
        console.error(`Archivo seleccionado no es de extensión ${validationExtension.allowed}`);
        if(table){
          launchAlert({
            message: validationExtension.message,
            type: 'danger',
            timeOut: 5000
          });
        }else{
          validationMessage = validationExtension.message;
          validationMessageClass = 'text-danger';
          setTimeout(clearMessage, 5000);
        }
        valid = false;
        disabledUpload = true;
      }
    }else{
      console.error(`Archivo seleccionado pesa ${(inputFile.size / Math.pow(1024,2)).toFixed(2)} MB, el máximo es ${validationSize.size} MB`);
      if(table){
        launchAlert({
          message: validationSize.message,
          type: 'danger',
          timeOut: 5000
        });
      }else{
        validationMessage = validationSize.message;
        validationMessageClass = 'text-danger';
        setTimeout(clearMessage, 5000);
      }
      valid = false;
      disabledUpload = true;
    }
  }

  const uploadFile = () => {
    var formData = new FormData();
    formData.append(`${fileName}`, inputFile);
    axios.post(`${url}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    }).then(function (response) {
      // handle success
      // console.log(response);
      urlFile = response.data;
      if(table){
        launchAlert({
          message: 'Se cargó el archivo con éxito',
          type: 'success',
          timeOut: 5000
        });
        dispatch('fileUploaded', {
          urlFile: urlFile,
          key: tableKeyURL,
          tableRecordId: tableRecordId,
          tableRecordKey: tableRecordKey,
        });
      }else{
        validationMessage = 'Se cargó el archivo con éxito';
        validationMessageClass = 'text-success';
        setTimeout(clearMessage, 5000);
      }
      valid = true;
      disabledView = false;
    })
    .catch(function (error) {
      // handle error
      console.error(error);
      if(table){
        launchAlert({
          message: 'Ocurrió un error en subir el archivo',
          type: 'danger',
          timeOut: 5000
        });
      }else{
        validationMessage = 'Ocurrió un error en subir el archivo';
        validationMessageClass = 'text-danger';
      }
      setTimeout(clearMessage, 5000);
      valid = false;
    });
  };

  const viewFile = () => {
    var win = window.open(`${baseUrlFile}${urlFile}`, '_blank');
    if (win) {
      win.focus();
    } else {
      alert('Please allow popups for this website');
    }
  };

</script>

{#if !table}
<label for="file" class="{validationMessageClass != 'text-success' ? validationMessageClass : ''}">{label}</label>
{/if}
<div>
  <button class="{chooserButton.class}" on:click="{selectFile}" disabled={disabled} >
    <i class="fa {chooserButton.icon}" aria-hidden="true"></i>{chooserButton.label}
  </button>
  <button class="{uploadButton.class}" on:click="{uploadFile}" disabled={disabled || disabledUpload} >
    <i class="fa {uploadButton.icon}" aria-hidden="true"></i>{uploadButton.label} 
  </button>
  {#if viewButton.display}
  <a class="{viewButton.class}" href={`${baseUrlFile}${urlFile}`} rel="noopener noreferrer" target="_blank" disabled={disabled || disabledView} >
    <i class="fa {viewButton.icon}" aria-hidden="true"></i>{viewButton.label} 
  </a>
  {/if}
</div>
<input type="file" class="" id={inputFileId} name="file" on:change={(e)=>onFileSelected(e)} bind:this={inputFile}>
{#if validationMessage != false}
<div class="col-sm-12 validation-message">
  <small id="validationHelp" class="{validationMessageClass}">
    {validationMessage}
  </small>
</div>
{/if}

<style>
  input[type="file"] {
		display: none;
	}

  .btn-upload-table{
    border: 0px;
    background: transparent;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
  }

  a{
    text-decoration: none;
  }

  .btn-upload-table:hover{
    cursor: pointer;
  }

  .btn-upload-table:disabled, .btn-upload-view:disabled{
    color:#8895a1;
  }

  .btn-upload-table i{
    margin-right:7px;
  }

  div .btn:not(:first-child) {
    margin-left: 10px;
  }

  label{
    margin-bottom:7px;
  }
</style>