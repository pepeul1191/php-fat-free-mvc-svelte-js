<svelte:options accessors={true} />
<script>
  import { onMount } from 'svelte';
  import random from '../Helpers/random.js';
  export let validationMessage = '';
  export let placeholder = '';
  export let value = '';
  export let valid = true;
  export let validations = [];
  export let label = '';
  export let disabled = false;
  let randId;
  let validationMessageClass = '';

  onMount(() => {
    randId = random(20);
    //console.log(randId)
  });

  export const validate = async () => {
    validations.forEach(validation => {
      if(validation.type == 'notEmpty'){
        // console.log('notEmpty')
        if(value == ''){
          var message = 'Este campo debe de estar lleno';
          if (typeof validation.message !== 'undefined'){
            message = validation.message;
          }
          validationMessage = message;
          valid = false;
          validationMessageClass = 'text-danger';
        }else{
          validationMessage = '';
          validationMessageClass = '';
          valid = true;
        }
      }
    });
  };
</script>

<label for="{randId}" class="form-label {validationMessageClass}">{label}</label>
<input type="text" class="form-control {(validationMessageClass == 'text-danger') ? 'is-invalid' : ''}" disabled={disabled} id="{randId}" placeholder="{placeholder}" bind:value={value} on:input="{validate}">
<small id="randIdHelp" class="{validationMessageClass}">
  {validationMessage}
</small>

<style>

</style>