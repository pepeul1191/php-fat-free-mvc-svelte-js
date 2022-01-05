<script>
	import 'bootstrap/dist/css/bootstrap.min.css';
	import 'font-awesome/css/font-awesome.min.css';
	import '../../stylesheets/styles.css';
  import { Modal } from 'bootstrap';
	import { onMount } from 'svelte';
	import { Router, Route } from 'svelte-routing';
  import Index from '../Pages/Home/Index.svelte';
	import Redirect404 from '../Pages/Error/Redirect404.svelte';
  import Navigation from './../Widgets/Navigation.svelte';
  import Footer from './../Widgets/Footer.svelte';
  import { modal } from '../Stores/modal.js';
  import Foo from '../Modals/Foo.svelte';
  import Department from '../Pages/Home/Department.svelte';
  import Location from '../Pages/MasterData/Location.svelte';
  import Specialism from '../Pages/MasterData/Specialism.svelte';
  import Dentist from '../Pages/Coa/Dentist.svelte';
  import DentistDetail from '../Pages/Coa/DentistDetail.svelte';
  import Branch from '../Pages/Coa/Branch.svelte';
  import BranchDetail from '../Pages/Coa/BranchDetail.svelte';
  export let url = '';
  export let basepath = '/';
  let modalComponent;
  let modalDOMStore;

  onMount(() => {
    console.log('home');
    modal.subscribe(value => {
      modalComponent = value;
    });
    modalDOMStore = new Modal(document.getElementById('modal'));
    document.getElementById('modal').addEventListener('hidden.bs.modal', function (event) {
      alert('=P');
    })
  });

  const modalOpen = () => {
    //myModal.toggle()
    modalComponent = Foo;
    // modalDOMStore.show();
    showModal(null);
  };

  function showModal(event) {
    if(typeof(event) !== "undefined" && event !== null){
      console.log(event.detail.param1);
    }
		modalDOMStore.show();
	}

</script>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <svelte:component this={modalComponent} />
    </div>
  </div>
</div>

<button class="btn btn-info d-none" on:click="{modalOpen}">Modal FOO</button>

<Navigation />

<Router url="{url}" basepath="{basepath}">
  <div>
    <Route path="/"><Index on:showModal={showModal}/></Route>
    <Route path="/department/add" component="{Department}" />
    <Route path="/master-data/location" component="{Location}" />
    <Route path="/master-data/specialism" component="{Specialism}" />
    <Route path="/coa/dentist" component="{Dentist}" />
    <Route path="/coa/dentist/add" component="{DentistDetail}" />
    <Route path="/coa/dentist/edit/:id" let:params><DentistDetail id={params.id}/></Route>
    <Route path="/coa/branch" component="{Branch}" />
    <Route path="/coa/branch/add" component="{BranchDetail}" />
    <Route path="/coa/branch/edit/:id" let:params><BranchDetail id={params.id}/></Route>
    <Route path="/*" component="{Redirect404}" />
  </div>
</Router>

<Footer />

<style>
</style>