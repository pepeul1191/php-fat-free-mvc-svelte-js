<script>
  import { onMount } from 'svelte';
  import DataTable from '../../Widgets/DataTable.svelte';
  import AlertMessage from '../../Widgets/AlertMessage.svelte';
  import { alertMessage as alertMessageStore} from '../../Stores/alertMessage.js';
  export let id;
  export let disabled = false;
  let imagesBranchDataTable;
  let disabledInCreate = true;
  let title = '';
  let alertMessage = null;
  let alertMessageProps = {};

  onMount(() => {    
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    // ajax
    if(id === undefined){
      title = 'Crear Sede';
      id = 'E';
      disabledInCreate = true;
    }else{
      title = 'Editar Sede';
      disabledInCreate = false;
    }
    // branch image table
    imagesBranchDataTable.urlServices.list = `branch/image/list?branch_id=${id}`;
    imagesBranchDataTable.list();
    imagesBranchDataTable.extraData.branch_id = id;
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
  
</script>

<svelte:head>
	<title>{title}</title>
</svelte:head>

<div class="container">
	<div class="row">
		<div class="col-lg-12 page-header">
			<h2>{title}</h2>
		</div>
  </div>
  <div class="row">
    <svelte:component this={alertMessage} {...alertMessageProps} />
    <div class="col-md-6">
      <br>
      <h6>Especialidades del Dentista</h6>
      <DataTable bind:this={imagesBranchDataTable} 
				urlServices={{ 
					list: `${BASE_URL}branch/image/list`, 
					save: `${BASE_URL}branch/image/save` 
				}}
				buttonSave={true},
        buttonAddRow={true},
				rows={{
					id: {
						style: 'color: red; display:none;',
						type: 'id',
					},
					alt:{
						type: 'input[text]',
					},
          url:{
						type: 'upload',
            style: 'text-align: center',
            tableKeyURL: 'url',
            tableRecordKey: 'id',
					},
          actions:{
						type: 'actions',
						buttons: [
							{
								type: 'delete',
							},
						],
						style: 'text-align:center;'
					},
				}}
				headers={[
					{
						caption: 'codigo',
						style: 'display:none;',
					},
					{
						caption: 'Nombre ALT',
					},
          {
						caption: 'Imágenes de la Sede',
            style: 'text-align: center',
					},
          {
						caption: 'Operaciones',
						style:'text-align: center;',
					},
				]}
				messages={{
					notChanges: 'No ha ejecutado cambios en la tabla de imágenes de la sede',
					list404: 'Rercuso no encontrado para listar los elmentos de la tabla de imágenes de la sede',
					list500: 'Ocurrió un error en listar los elementos de la tabla de imágenes de la sede',
					save404: 'Rercuso no encontrado para guardar los cambios de la tabla de imágenes de la sede',
					save500: 'Ocurrió un error para guardar los cambios de la table de imágenes de la sede',
					save200: 'Se han actualizado los registros de la tabla de imágenes de la sede',
				}}
        disabled={disabledInCreate & disabled}
			/>
    </div>
  </div>
</div>

<style>

</style>