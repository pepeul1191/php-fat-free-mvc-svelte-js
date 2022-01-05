<script>
  import { onMount } from 'svelte';
	import { alertMessage as alertMessageStore} from '../../Stores/alertMessage.js';
  import DataTable from '../../Widgets/DataTable.svelte';
  import InputText from '../../Widgets/InputText.svelte';
  let alertMessage = null;
  let alertMessageProps = {};
  let dentistDataTable;
  let inputName = '';
  let inputCop = '';
  let inputRne = '';

  onMount(() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    dentistDataTable.list();
  });

  const search = () => {
    // run validations
    dentistDataTable.queryParams = {
      name: inputName,
      cop: inputCop,
      rne: inputRne,
    };
    dentistDataTable.list();
  }
  
  const clean = () => {
    inputName = '';
    inputCop = '';
    inputRne = '';
    dentistDataTable.queryParams = {
      name: inputName,
      cop: inputCop,
      rne: inputRne,
    };
    dentistDataTable.list();
  };
</script>

<svelte:head>
	<title>Gestión de Dentistas</title>
</svelte:head>

<div class="container">
	<div class="row">
		<svelte:component this={alertMessage} {...alertMessageProps} />
		<div class="col-lg-12 page-header">
			<h2>Gestión de Dentistas</h2>
		</div>
  </div>
  <div class="row">
    <div class="col-md-5">
      <InputText 
        label={'Nombre'}
        bind:value={inputName}
        placeholder={'Ingrese nombre'} 
      />
    </div>
    <div class="col-md-2">
      <InputText 
        label={'COP'}
        bind:value={inputCop}
        placeholder={'Ingrese COP'} 
      />
    </div>  
    <div class="col-md-2">
      <InputText 
        label={'RNE'}
        bind:value={inputRne}
        placeholder={'Ingrese RNE'} 
      />
    </div>    
    <div class="col-md-3" style="padding-top:27px;">
      <button class="btn btn-warning" on:click="{clean}"><i class="fa fa-eraser" aria-hidden="true"></i>
        Limpiar</button>
      <button class="btn btn-success" on:click="{search}"><i class="fa fa-search" aria-hidden="true"></i>
        Buscar Dentistas</button>
    </div>
  </div>
  <div class="row">
		<div class="col-md-12">
      <br>
			<DataTable bind:this={dentistDataTable} 
				urlServices={{ 
					list: `${BASE_URL}dentist/list`, 
					save: `${BASE_URL}dentist/save` 
				}}
				buttonSave={true},
				buttonAddRecord={'/coa/dentist/add'}
				rows={{
					id: {
						style: 'color: red; display:none;',
						type: 'id',
					},
					name:{
						type: 'td',
					},
          cop:{
						type: 'td',
					},
          rne:{
						type: 'td',
					},
					actions:{
						type: 'actions',
						buttons: [
              {
								type: 'link', 
								icon: 'fa fa-pencil', 
								style:'font-size:12px; margin-right:10px;',
								url: '/coa/dentist/edit/',
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
						caption: 'COP',
					},
          {
						caption: 'RNE',
					},
					{
						caption: 'Operaciones',
						style:'text-align: center;',
					},]}
        messages={{
          notChanges: 'No ha ejecutado cambios en la tabla de dentistas',
          list404: 'Rercuso no encontrado para listar los elmentos de la tabla de dentistas',
          list500: 'Ocurrió un error en listar los elementos de la tabla de dentistas',
          save404: 'Rercuso no encontrado para guardar los cambios de la tabla de dentistas',
          save500: 'Ocurrió un error para guardar los cambios de la table de dentistas',
          save200: 'Se han actualizado los registros de la tabla de dentistas',
        }}
        pagination={{
          step: 10,
        }}
			/>
		</div>
  </div>
</div>

<style>

</style>