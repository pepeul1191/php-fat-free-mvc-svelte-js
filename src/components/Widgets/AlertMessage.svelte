<script>
  // https://getbootstrap.com/docs/5.0/components/alerts/
  // primary, secondary, success, danger, warning, info, light, dark
  import { afterUpdate } from 'svelte';
  export let message = '';
  export let type;
  export let timeOut = false;

  afterUpdate(() => {
    if(message != ''){
      if(timeOut != false){
        setTimeout(clearMessage, timeOut);
      }
    } 
  });

  const clearMessage = () => {
    message = '';
  };
</script>

{#if message != ''}
<div class="row" style="padding-top:0px;padding-right: 0px;">
  <div class="col-md-12" style="padding-right: 0px;">
    <div class="alert alert-{type}" role="alert">
      {message}
    </div>
  </div>
</div>
{/if}

<style>
  .row{
    padding-top:20px;
  }

  .alert{
    border-radius: 0;
    padding: 0.5rem 1rem;
  }
</style>