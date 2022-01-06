<script>
  import { onMount } from 'svelte';
	import { alertMessage as alertMessageStore} from '../../Stores/alertMessage.js';
  import DataTable from '../../Widgets/DataTable.svelte';
  import InputText from '../../Widgets/InputText.svelte';
  let alertMessage = null;
  let alertMessageProps = {};
  let userDataTable;
  let inputUser = '';
  let inputEmail = '';
  let baseURL = BASE_URL;

  onMount(() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    userDataTable.list();
  });

  const search = () => {
    // run validations
    userDataTable.queryParams = {
      user: inputUser,
      email: inputEmail,
    };
    userDataTable.list();
  }
  
  const clean = () => {
    inputUser = '';
    inputEmail = '';
    userDataTable.queryParams = {
      user: inputUser,
      email: inputEmail,
    };
    userDataTable.list();
  };
</script>

<svelte:head>
	<title>Gestión de Dentistas</title>
</svelte:head>

<div class="container">
	<div class="row">
		<svelte:component this={alertMessage} {...alertMessageProps} />
		<div class="col-lg-12 page-header">
			<h2>Gestión de Usuarios</h2>
		</div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <InputText 
        label={'Nombre'}
        bind:value={inputUser}
        placeholder={'Ingrese nombre'} 
      />
    </div>
    <div class="col-md-3">
      <InputText 
        label={'Correo Electrónico'}
        bind:value={inputEmail}
        placeholder={'Ingrese Correo'} 
      />
    </div>   
    <div class="col-md-3" style="padding-top:27px;">
      <button class="btn btn-warning" on:click="{clean}"><i class="fa fa-eraser" aria-hidden="true"></i>
        Limpiar</button>
      <button class="btn btn-success" on:click="{search}"><i class="fa fa-search" aria-hidden="true"></i>
        Buscar Usuarios</button>
    </div>
  </div>
  <div class="row">
		<div class="col-md-7">
      <br>
			<DataTable bind:this={userDataTable} 
				urlServices={{ 
					list: `${baseURL}user/list`, 
					save: `${baseURL}user/save` 
				}}
				buttonSave={true},
				buttonAddRecord={'/user/new'}
				rows={{
					id: {
						style: 'color: red; display:none;',
						type: 'id',
					},
					user:{
						type: 'td',
            style: 'width:35%;',
					},
          email:{
						type: 'td',
            style: 'width:35%;',
					},
					actions:{
						type: 'actions',
						buttons: [
              {
								type: 'link', 
								icon: 'fa fa-pencil', 
								style:'font-size:12px; margin-right:10px;',
								url: '/user/edit/',
                key: 'id',
							},
							{
								type: 'delete',
							},
						],
						style: 'text-align:center;width:30%;'
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
						caption: 'Correo Electrónico',
					},
					{
						caption: 'Operaciones',
						style:'text-align: center;',
					},]}
        messages={{
          notChanges: 'No ha ejecutado cambios en la tabla de usuarios',
          list404: 'Rercuso no encontrado para listar los elmentos de la tabla de usuarios',
          list500: 'Ocurrió un error en listar los elementos de la tabla de usuarios',
          save404: 'Rercuso no encontrado para guardar los cambios de la tabla de usuarios',
          save500: 'Ocurrió un error para guardar los cambios de la table de usuarios',
          save200: 'Se han actualizado los registros de la tabla de usuarios',
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