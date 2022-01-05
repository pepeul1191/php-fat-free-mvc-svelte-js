<script>
  import { onMount } from 'svelte';
  import InputText from '../../Widgets/InputText.svelte';
  import UploadFile from '../../Widgets/UploadFile.svelte';
  import DataTable from '../../Widgets/DataTable.svelte';
  import AlertMessage from '../../Widgets/AlertMessage.svelte';
  import { alertMessage as alertMessageStore} from '../../Stores/alertMessage.js';
  import { getDentistById, saveDentistDetail } from '../../../services/dentist_service.js';
  export let id;
  export let disabled = false;
  let disabledInCreate = true;
  let title = '';
  let alertMessage = null;
  let alertMessageProps = {};
  let dentistSpecialismDataTable;
  let dentistBranchDataTable;
  let imageUploadFile = '';
  let name = ''; let inputName; let nameValid = false;
  let cop = ''; let inputCOP; let copValid = false;
  let rne = ''; let inputRNE; let rneValid = true;
  let imageURL = 'E';
  
  onMount(() => {    
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    // ajax
    if(id === undefined){
      title = 'Crear Dentista';
      id = 'E';
      disabledInCreate = true;
    }else{
      title = 'Editar Dentista';
      loadDentist(id);
      disabledInCreate = false;
    }
    // dentist specialism table
    dentistSpecialismDataTable.urlServices.list = `dentist/specialism/list?dentist_id=${id}`;
    dentistSpecialismDataTable.list();
    dentistSpecialismDataTable.extraData.dentist_id = id;
    // dentist branch table
    dentistBranchDataTable.urlServices.list = `dentist/branch/list?dentist_id=${id}`;
    dentistBranchDataTable.extraData.dentist_id = id;
    dentistBranchDataTable.list();
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

  const loadDentist = (id) => {
    getDentistById(id).then((resp) => {
      var data = resp.data;
      name = data.name;
      rne = data.rne;
      cop = data.cop;
      imageURL = data.image;
    }).catch((resp) =>  {
      disabled = true;
      if(resp.status == 404){
        launchAlert(null, 'Dentista a editar no existe', 'warning');
      }else{
        launchAlert(null, 'Ocurrió un error en obtener los datos del dentista', 'danger');
      }
    })
  };

  const saveDetail = () => {
    // run validations
    inputName.validate();
    inputCOP.validate();
    inputRNE.validate();
    // check image url
    if(imageURL == 'E'){
      imageURL = 'assets/img/default-user.png'
    }
    // check if true
    if(nameValid && rneValid && copValid){
      var params = {
        id: id,
        name: name,
        cop: cop,
        rne: rne,
        image: imageURL,
      };
      saveDentistDetail(params).then((resp) => {
        var data = resp.data;
        if(data != ''){
          id = data;
          title = 'Editar Dentista';
          launchAlert(null, 'Se ha creado un nuevo dentista', 'success');
          disabledInCreate = false;
        }else{
          launchAlert(null, 'Se ha editado un dentista', 'success');
        }
      }).catch((resp) =>  {
        if(resp.status == 404){
          launchAlert(null, 'Recurso guardar detalle de dentista no existe en el servidor', 'danger');
        }else{
          launchAlert(null, 'Ocurrió un error en guardar los datos del dentista', 'danger');
        }
      })
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
    <div class="col-md-4">
      <InputText 
        label={'Nombre Completo'}
        bind:value={name}
        placeholder={'Ingrese nombre'} 
        disabled={disabled}
        validations={[
          {type:'notEmpty', message: 'Debe de ingresar un nombre'},
          {type:'maxLength', length: 50, message: 'Nombre máximo 50 letras'},
        ]}
        bind:valid={nameValid} 
        bind:this={inputName}
      />
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <UploadFile bind:this={imageUploadFile} 
          label={'Selecionar Archivo'}
          fileName={'file'} 
          url={`${BASE_URL}upload`} 
          baseUrlFile={`${BASE_URL}`}  
          chooserButton={
            {label: 'Buscar', icon: 'fa-grav', class: 'btn-info'}
          }
          uploadButton={
            {label: 'Subir', icon: 'fa-shower', class: 'btn-secondary'}
          }
          viewButton={
            {label: 'Ver', icon: 'fa-vcard', class: 'btn-primary', display: true}
          } 
          validationSize={
            {size: 2.6, message: 'Máximo 2 MB'}
          }
          validationExtension={
            {allowed: ['image/png', 'image/jpg', 'image/jpeg'], message: 'Sólo Imágenes'}
          }
          disabled={disabled}
          bind:urlFile={imageURL}
        />
      </div>
    </div>
    <div class="col-md-1">
      <InputText 
        label={'COP'}
        bind:value={cop}
        placeholder={'COP'} 
        disabled={disabled}
        validations={[
          {type:'notEmpty', message: 'Debe de ingresar un nombre'},
          {type:'maxLength', length: 5, message: 'COP máximo 5 letras'},
        ]}
        bind:valid={copValid} 
        bind:this={inputCOP}
      />
    </div>
    <div class="col-md-1">
      <InputText 
        label={'RNE'}
        bind:value={rne}
        placeholder={'RNE'} 
        disabled={disabled}
        validations={[
          {type:'emptyOrMaxLength', length: 5, message: 'RNE máximo 5 letras'},
        ]}
        bind:valid={rneValid} 
        bind:this={inputRNE}
      />
    </div>
    <div class="col-md-2" style="padding-top:27px;">
      <button class="btn btn-success" disabled="{disabled}" on:click="{saveDetail}"><i class="fa fa-search" aria-hidden="true"></i>
        Guardar</button>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <br>
      <h6>Especialidades del Dentista</h6>
      <DataTable bind:this={dentistSpecialismDataTable} 
				urlServices={{ 
					list: `${BASE_URL}dentist/specialism/list`, 
					save: `${BASE_URL}dentist/specialism/save` 
				}}
				buttonSave={true},
				rows={{
					id: {
						style: 'color: red; display:none;',
						type: 'id',
					},
					name:{
						type: 'td',
					},
          exist:{
						type: 'input[check]',
            style: 'text-align: center',
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
						caption: 'Especialidad',
            style: 'text-align: center',
					},
				]}
				messages={{
					notChanges: 'No ha ejecutado cambios en la tabla de especialidades del dentista',
					list404: 'Rercuso no encontrado para listar los elmentos de la tabla de especialidades del dentista',
					list500: 'Ocurrió un error en listar los elementos de la tabla de especialidades del dentista',
					save404: 'Rercuso no encontrado para guardar los cambios de la tabla de especialidades del dentista',
					save500: 'Ocurrió un error para guardar los cambios de la table de especialidades del dentista',
					save200: 'Se han actualizado los registros de la tabla de especialidades del dentista',
				}},
        disabled={disabledInCreate & disabled}
			/>
    </div>
    <div class="col-md-6">
      <br>
      <h6>Sedes Donde Labora</h6>
      <DataTable bind:this={dentistBranchDataTable} 
				urlServices={{ 
					list: `${BASE_URL}dentist/branch/list`, 
					save: `${BASE_URL}dentist/branch/save` 
				}}
				buttonSave={true},
        buttonAddRow={true},
				rows={{
					id: {
						style: 'color: red; display:none;',
						type: 'id',
					},
					'branch_name::branch_id':{
						type: 'autocomplete',
            url: 'branch/search',
            recordValue: 'branch_name',
            recordId: 'branch_id',
            rowId: 'id',
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
				]}
				messages={{
					notChanges: 'No ha ejecutado cambios en la tabla de sedes del dentista',
					list404: 'Rercuso no encontrado para listar los elmentos de la tabla de sedes del dentista',
					list500: 'Ocurrió un error en listar los elementos de la tabla de sedes del dentista',
					save404: 'Rercuso no encontrado para guardar los cambios de la tabla de sedes del dentista',
					save500: 'Ocurrió un error para guardar los cambios de la table de sedes del dentista',
					save200: 'Se han actualizado los registros de la tabla de sedes del dentista',
				}}
        disabled={disabledInCreate & disabled}
			/>
    </div>
  </div>
</div>

<style>

</style>