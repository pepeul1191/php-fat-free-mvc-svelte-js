<script>
	import { onMount } from 'svelte';
	import { alertMessage as alertMessageStore} from '../../Stores/alertMessage.js';
  import DataTable from '../../Widgets/DataTable.svelte';
	import Autocomplete from './../../Widgets/Autocomplete.svelte';
  let alertMessage = null;
  let alertMessageProps = {};
  let departmentDataTable;
  let provinceDataTable;
  let districtDataTable;

	onMount(() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    departmentDataTable.list();
  });
</script>

<svelte:head>
	<title>Gestipón de Ubicaciones del Perú</title>
</svelte:head>

<div class="container">
	<div class="row">
		<svelte:component this={alertMessage} {...alertMessageProps} />
		<div class="col-lg-12 page-header">
			<h2>Ubiaciones del Perú</h2>
		</div>
		<div class="col-md-4">
			<DataTable bind:this={departmentDataTable} 
				urlServices={{ 
					list: `${BASE_URL}department/list`, 
					save: `${BASE_URL}department/save` 
				}}
				buttonAddRow={true},
				buttonSave={true},
				buttonAddRecord={'/department/add'}
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
							{
								type: 'custom', 
								icon: 'fa fa-chevron-right', 
								style:'font-size:12px; margin-left:5px;',
								customFunction: (record) => {
									var departmentId = record.id;
									provinceDataTable.urlServices.list = `${BASE_URL}province/list/${departmentId}`;
									provinceDataTable.list();
									provinceDataTable.extraData.department_id = departmentId;
									districtDataTable.display = false;
								},
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
						caption: 'Operaciones',
						style:'text-align: center;',
					},]}
					messages={{
						notChanges: 'No ha ejecutado cambios en la tabla de departamentos',
						list404: 'Rercuso no encontrado para listar los elmentos de la tabla de departamentos',
						list500: 'Ocurrió un error en listar los elementos de la tabla de departamentos',
						save404: 'Rercuso no encontrado para guardar los cambios de la tabla de departamentos',
						save500: 'Ocurrió un error para guardar los cambios de la table de departamentos',
						save200: 'Se han actualizado los registros de la tabla de departamentos',
					}}
			/>
		</div>
		<div class="col-md-4">
			<DataTable bind:this={provinceDataTable} 
				urlServices={{ 
					list: `${BASE_URL}province/list/:id_department`, 
					save: `${BASE_URL}province/save` 
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
							{
								type: 'custom', 
								icon: 'fa fa-chevron-right', 
								style:'font-size:12px; margin-left:5px;',
								customFunction: (record) => {
									var provinceId = record.id;
									districtDataTable.urlServices.list = `${BASE_URL}district/list/${provinceId}`;
									districtDataTable.list();
									districtDataTable.extraData.province_id = provinceId;
								},
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
						caption: 'Operaciones',
						style:'text-align: center;',
					},]}
					messages={{
						notChanges: 'No ha ejecutado cambios en la tabla de provincias',
						list404: 'Rercuso no encontrado para listar los elmentos de la tabla de provincias',
						list500: 'Ocurrió un error en listar los elementos de la tabla de provincias',
						save404: 'Rercuso no encontrado para guardar los cambios de la tabla de provincias',
						save500: 'Ocurrió un error para guardar los cambios de la table de provincias',
						save200: 'Se han actualizado los registros de la tabla de provincias',
					}}
			/>
		</div>
		<div class="col-md-4">
			<DataTable bind:this={districtDataTable} 
				urlServices={{ 
					list: `${BASE_URL}district/list/:id_province`, 
					save: `${BASE_URL}district/save` 
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
						style: 'display:none',
					},
					{
						caption: 'Nombre',
					},
					{
						caption: 'Operaciones',
						style:'text-align: center;',
					},]}
					messages={{
						notChanges: 'No ha ejecutado cambios en la tabla de distritos',
						list404: 'Rercuso no encontrado para listar los elmentos de la tabla de distritos',
						list500: 'Ocurrió un error en listar los elementos de la tabla de distritos',
						save404: 'Rercuso no encontrado para guardar los cambios de la tabla de distritos',
						save500: 'Ocurrió un error para guardar los cambios de la table de distritos',
						save200: 'Se han actualizado los registros de la tabla de distritos',
					}}
			/>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 page-header">
			<h2>Autocompletar - Ubiaciones del Perú</h2>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<Autocomplete url={`${BASE_URL}district/search`} />
				<br>
			</div>
		</div>
	</div>
</div>

<style>

</style>