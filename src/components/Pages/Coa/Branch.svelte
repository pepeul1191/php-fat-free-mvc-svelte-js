<script>
  import { onMount } from 'svelte';
	import { alertMessage as alertMessageStore} from '../../Stores/alertMessage.js';
  import DataTable from '../../Widgets/DataTable.svelte';
  let alertMessage = null;
  let alertMessageProps = {};
  let branchDataTableLima;
  let branchDataTableProvince;

  onMount(() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    branchDataTableLima.list();
    branchDataTableProvince.list();
  });
</script>

<svelte:head>
	<title>Gestión de Sedes</title>
</svelte:head>

<div class="container">
	<div class="row">
		<svelte:component this={alertMessage} {...alertMessageProps} />
		<div class="col-lg-12 page-header">
			<h2>Gestión de Sedes de Lima</h2>
		</div>
  </div>
  <div class="row">
		<div class="col-md-12">
      <br>
			<DataTable bind:this={branchDataTableLima} 
				urlServices={{ 
					list: `${BASE_URL}branch/list_by_type`, 
					save: `${BASE_URL}branch/save` 
				}}
				buttonSave={true}
				buttonAddRecord={'/coa/branch/add'}
				rows={{
					id: {
						style: 'color: red; display:none;',
						type: 'id',
					},
					name:{
						type: 'td',
					},
          address:{
						type: 'td',
					},
					actions:{
						type: 'actions',
						buttons: [
              {
								type: 'link', 
								icon: 'fa fa-pencil', 
								style:'font-size:12px; margin-right:10px;',
								url: '/coa/branch/edit/',
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
						caption: 'codigo',
						style: 'display:none',
					},
					{
						caption: 'Nombre',
					},
          {
						caption: 'Direccion',
					},
					{
						caption: 'Operaciones',
						style:'text-align: center;',
					},]}
        messages={{
          notChanges: 'No ha ejecutado cambios en la tabla de sedes',
          list404: 'Rercuso no encontrado para listar los elmentos de la tabla de sedes',
          list500: 'Ocurrió un error en listar los elementos de la tabla de sedes',
          save404: 'Rercuso no encontrado para guardar los cambios de la tabla de sedes',
          save500: 'Ocurrió un error para guardar los cambios de la table de sedes',
          save200: 'Se han actualizado los registros de la tabla de sedes',
        }}
        queryParams={{
          branch_type_id: 1
        }}
			/>
		</div>
  </div>
  <div class="row">
		<div class="col-lg-12 page-header">
			<h2>Gestión de Sedes de Provincia</h2>
		</div>
  </div>
  <div class="row">
		<div class="col-md-12">
      <br>
			<DataTable bind:this={branchDataTableProvince} 
				urlServices={{ 
					list: `${BASE_URL}branch/list_by_type`, 
					save: `${BASE_URL}branch/save` 
				}}
				buttonSave={true}
				buttonAddRecord={'/coa/branch/add'}
				rows={{
					id: {
						style: 'color: red; display:none;',
						type: 'id',
					},
					name:{
						type: 'td',
					},
          address:{
						type: 'td',
					},
					actions:{
						type: 'actions',
						buttons: [
              {
								type: 'link', 
								icon: 'fa fa-pencil', 
								style:'font-size:12px; margin-right:10px;',
								url: '/coa/branch/edit/',
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
						caption: 'codigo',
						style: 'display:none',
					},
					{
						caption: 'Nombre',
					},
          {
						caption: 'Direccion',
					},
					{
						caption: 'Operaciones',
						style:'text-align: center;',
					},]}
        messages={{
          notChanges: 'No ha ejecutado cambios en la tabla de sedes de provincia',
          list404: 'Rercuso no encontrado para listar los elmentos de la tabla de sedes de provincia',
          list500: 'Ocurrió un error en listar los elementos de la tabla de sedes de provincia',
          save404: 'Rercuso no encontrado para guardar los cambios de la tabla de sedes de provincia',
          save500: 'Ocurrió un error para guardar los cambios de la table de sedes de provincia',
          save200: 'Se han actualizado los registros de la tabla de sedes de provincia',
        }}
        queryParams={{
          branch_type_id: 2
        }}
			/>
		</div>
  </div>
</div>

<style>

</style>