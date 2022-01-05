<script>
  import { onMount } from 'svelte';
	import { alertMessage as alertMessageStore} from '../../Stores/alertMessage.js';
  import DataTable from '../../Widgets/DataTable.svelte';
  let alertMessage = null;
  let alertMessageProps = {};
  let specialismDataTable;

  onMount(() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    specialismDataTable.list();
  });
</script>

<svelte:head>
	<title>Gestión de Especialidades</title>
</svelte:head>

<div class="container">
	<div class="row">
		<svelte:component this={alertMessage} {...alertMessageProps} />
		<div class="col-lg-12 page-header">
			<h2>Lista de Espcialidades</h2>
		</div>
		<div class="col-md-5">
			<DataTable bind:this={specialismDataTable} 
				urlServices={{ 
					list: `${BASE_URL}specialism/list`, 
					save: `${BASE_URL}specialism/save` 
				}}
				buttonAddRow={true},
				buttonSave={true},
				rows={{
					id: {
						style: 'color: red; display:none;',
						type: 'id',
					},
					name:{
						type: 'input[text]',
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
						caption: 'Nombre',
					},
					{
						caption: 'Operaciones',
						style:'text-align: center;',
					},]}
					messages={{
						notChanges: 'No ha ejecutado cambios en la tabla de especialidades',
						list404: 'Rercuso no encontrado para listar los elmentos de la tabla de especialidades',
						list500: 'Ocurrió un error en listar los elementos de la tabla de especialidades',
						save404: 'Rercuso no encontrado para guardar los cambios de la tabla de especialidades',
						save500: 'Ocurrió un error para guardar los cambios de la table de especialidades',
						save200: 'Se han actualizado los registros de la tabla de especialidades',
					}}
			/>
		</div>
	</div>
</div>

<style>

</style>