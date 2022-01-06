<script>
  import { onMount } from 'svelte';
	import { alertMessage as alertMessageStore} from '../../Stores/alertMessage.js';
  import DataTable from '../../Widgets/DataTable.svelte';
  let alertMessage = null;
  let alertMessageProps = {};
  let dataTableSystem;
  let baseURL = BASE_URL;

  onMount(() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    dataTableSystem.list();
  });
</script>

<svelte:head>
	<title>Gestión de Sistemas</title>
</svelte:head>

<div class="container">
	<div class="row">
		<svelte:component this={alertMessage} {...alertMessageProps} />
		<div class="col-lg-12 page-header">
			<h2>Gestión de Sistemas</h2>
		</div>
  </div>
  <div class="row">
		<div class="col-md-8">
      <br>
      <DataTable bind:this={dataTableSystem} 
				urlServices={{ 
					list: `${baseURL}system/list`, 
					save: `${baseURL}system/save` 
				}}
				buttonSave={true}
				buttonAddRecord={'/system/new'}
				rows={{
					id: {
						style: 'color: red; display:none;',
						type: 'id',
					},
					name:{
						type: 'td',
					},
          repository:{
						type: 'td',
					},
          branch:{
						type: 'td',
					},
					actions:{
						type: 'actions',
						buttons: [
              {
								type: 'link', 
								icon: 'fa fa-pencil', 
								style:'font-size:12px; margin-right:10px;',
								url: '/system/edit/',
                key: 'id',
							},
              {
								type: 'link', 
								icon: 'fa fa-users', 
								style:'font-size:12px; margin-right:10px;',
								url: '/system/user/',
                key: 'id',
							},
              {
								type: 'link', 
								icon: 'fa fa-list', 
								style:'font-size:12px; margin-right:10px;',
								url: '/system/permission/',
                key: 'id',
							},
							{
								type: 'delete',
							},
						],
						style: 'text-align:center;'
					},
				}}
				headers={[
					{
						caption: 'id',
						style: 'display:none',
					},
					{
						caption: 'Nombre',
					},
          {
						caption: 'Repositorio',
					},
          {
						caption: 'Rama',
					},
					{
						caption: 'Operaciones',
						style:'text-align: center;',
					},]}
        messages={{
          notChanges: 'No ha ejecutado cambios en la tabla de sistemas',
          list404: 'Rercuso no encontrado para listar los elmentos de la tabla de sistemas',
          list500: 'Ocurrió un error en listar los elementos de la tabla de sistemas',
          save404: 'Rercuso no encontrado para guardar los cambios de la tabla de sistemas',
          save500: 'Ocurrió un error para guardar los cambios de la table de sistemas',
          save200: 'Se han actualizado los registros de la tabla de sistemas',
        }}
        queryParams={{}}
			/>
		</div>
  </div>
</div>

<style>

</style>