<script>
  import UploadFile from './../Widgets/UploadFile.svelte';
</script>

<div class="modal-header">
  <h5 class="modal-title" id="modalLabel">Modal BAR</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <UploadFile />
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
  <button type="button" class="btn btn-primary">Save changes</button>
</div>

<style>

</style>