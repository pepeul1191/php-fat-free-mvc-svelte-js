<script>
  import axios from 'axios';
  import InputText from '../Widgets/InputText.svelte';
  import Autocomplete from '../Widgets/Autocomplete.svelte';
  let nameValid = true;
  let emailValid = true;
  let districtValid = false;
  let inputName, inputEmail, inputDistrict;

  const checkName = async (value) => {
    let response = await axios.get(`${BASE_URL}department/search`, {
      params: {
        name: value
      }
    });
    var valid = false;
    if(response.status == 200){
      if(response.data.length == 0){
        valid = true;
      }
    }
    return valid;
  };

  const saveForm = () => {
    // run validations
    inputName.validate();
    inputEmail.validate();
    inputDistrict.validate();
    // check if true
    if(nameValid && emailValid && districtValid){
      alert('seguimos!!!');
    }
  }
</script>

<div class="col-md-3">
  <InputText 
    label={'Nombre'}
    value={''}
    placeholder={'Ingrese su nombre'} 
    validations={[
      {type:'notEmpty', message: 'Debe de ingresar un nombre'},
      {type:'maxLength', length: 5, message: 'Nombre máximo 5 letras'},
      {type:'custom', message: 'Nombre ya tomado', func: checkName},
    ]}
    bind:valid={nameValid} 
    bind:this={inputName}
  />
</div>
<div class="col-md-3">
  <InputText 
    label={'Correo'}
    value={''}
    placeholder={'Ingrese su curreo'} 
    validations={[
      {type:'notEmpty', message: 'Debe de ingresar su correo'},
      {type:'email', message: 'Debe de ingresar un correo válido'},
    ]}
    bind:valid={emailValid}
    bind:this={inputEmail}
  />
</div>
<div class="col-md-3">
  <div class="form-group">
    <Autocomplete 
      label={'Buscar Distritos'} 
      placeholder={'Ingrese distrito'} 
      url={`${BASE_URL}district/search`} 
      notEmptyMessage={'Debe de seleccionar un distrito'}  
      bind:valid={districtValid}
      bind:this={inputDistrict}
    />
  </div>
</div>

<div class="col-md-3">
  <button class="btn btn-success" on:click="{saveForm}">Guardar Cambios</button>
</div>

<style>

</style>