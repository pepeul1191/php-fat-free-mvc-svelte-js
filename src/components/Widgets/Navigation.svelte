<script>
	import { onMount } from 'svelte';
	import { navigate } from 'svelte-routing';
	import { getUser } from '../../services/user_service.js';
	export let items = [];
	export let user = {};
	let staticURL = STATIC_URL;
	let showUser = true;

	onMount(() => {
		items = [
			{name: 'Home', url: '/', active: true, items: []}, 
			{name: 'Datos Maestros', url: '#', active: true, items: [
				{name: 'Ubicaciones del Perú', url: '/master-data/location', active: true}, 
				{name: 'Espcialidades Clínicas', url: '/master-data/specialism', active: true}, 
				{name: 'Estados de Usuarios', url: '/master-data/state', active: true}, 
			]}, 
			{name: 'COA', url: '#', active: true, items: [
				{name: 'Gestión de Dentistas', url: '/coa/dentist', active: true}, 
				{name: 'Gestión de Sedes', url: '/coa/branch', active: true}, 
			]}, 
			{name: 'Sistemas', url: '/system', active: true, items: []}, 
			{name: 'Usuarios', url: '/user', active: true, items: []}, 
		];
		getUserInfo();
	});  

	const getUserInfo = () => {
		getUser().then((resp) => {
			(resp.data.name != null) ? user.name = resp.data.name : showUser = false;
			(resp.data.img != null) ? user.img = resp.data.img : user.img = `${staticURL}assets/img/default-user.png`;
			(resp.data.user != null) ? user.user = resp.data.user : user.user = null;
		}).catch((resp) =>  {
			showUser = false;
		});
	};
</script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Eighth navbar example">
	<div class="container">
		<a class="navbar-brand" href="/">Sistema de Accesos</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<!--
		<div class="collapse navbar-collapse" id="navbarsExample07">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link active" aria-current="page" href="#">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Link</a>
				</li>
				<li class="nav-item">
					<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-bs-toggle="dropdown" aria-expanded="false" >Dropdown</a>
					<ul class="dropdown-menu" aria-labelledby="dropdown07" id="">
						<li><a class="dropdown-item" href="#">Action</a></li>
						<li><a class="dropdown-item disabled" href="#">Another action</a></li>
						<li><a class="dropdown-item" href="#">Something else here</a></li>
					</ul>
				</li>
			</ul>
			<form>
				<input class="form-control" type="text" placeholder="Search" aria-label="Search">
			</form>
		</div>
	</div>
	-->
	<div class="collapse navbar-collapse" id="navbarsExample07">
		<ul class="navbar-nav me-auto mb-2 mb-lg-0">
			{#each items as item}
				{#if item.items !== undefined & item.items.length > 0}
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="dropdown07" data-bs-toggle="dropdown" aria-expanded="false" >{item.name}</a>
						<ul class="dropdown-menu" aria-labelledby="dropdown07" id="">
							{#each item.items as subItem}
								<li><a class="dropdown-item" on:click|preventDefault={() => {navigate(subItem.url)}} href="{subItem.url}">{subItem.name}</a></li>
							{/each}
						</ul>
					</li>
				{:else}
					<li class="nav-item">
						<a class="nav-link" on:click|preventDefault={() => {navigate(item.url)}} href="{item.url}" tabindex="-1">{item.name}</a>
					</li>
				{/if}
			{/each}
		</ul>
		{#if showUser}
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle user-dropdown" id="dropdown06" data-bs-toggle="dropdown" aria-expanded="false">
						<img src="{user.img}" class="rounded-circle img-fluid" width="20" height="20">
						&nbsp;&nbsp;&nbsp;{user.name}
					</a>
					<ul class="dropdown-menu" aria-labelledby="dropdown06" id="">
						<li><a class="dropdown-item" href="/user">Editar Datos</a></li>
						<li><a class="dropdown-item" href="#">Mensajes</a></li>
						<li><a class="dropdown-item" href="/log-out">Salir</a></li>
					</ul>
				</li>
			</ul>  
		{:else}
			<ul class="navbar-nav ml-auto">
				<li><a class="nav-link" href="/login">
					<i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Ingresar</a>
				</li>
			</ul>
		{/if}         
	</div>
</nav>

<style>
  nav{
    margin-bottom: 10px;  
  }

	.dropdown-toggle:hover{
		cursor: pointer;
	}

	.user-dropdown:after{
		display: none;
	}

	.dropdown-toggle::after {
    margin-left: 0.555em;
	}

	td > i, td > a{
		margin-left: 5px !important;
	}
</style>