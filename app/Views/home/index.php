<?php include_once(VIEW_PATH . '/partials/blank_header.php') ?>

<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
  <a class="navbar-brand" href="#">PDFs a Correos</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <!--
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
  -->
</nav>
<!-- end-nav -->
<div class="container-fluid" id="app">
  <br>
  <h5>Aplicación Para Enviar Certificados</h5>
  <br>
  <div class="row">
    <div class="col-md-12 no-height" id="alertRow">
      <div class="alert" role="alert" id="alertMessage"></div>
    </div>
    <div class="col-md-3">
      <div class="form-group" style="padding-top: 25px;">
        <label for="">Tipo de Certificado</label>
        <select id="slcType" class="form-control">
          <option ></option>
          <option value="certified">Diplomado</option>
          <option value="course"><!--Curso de Cortesía-->Curso Grabado | Cortesía</option>
          <option value="free-course"><!--Curso Libre-->Curso en Vivo | Libre</option>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group d-none">
        <label for="inputFilePDF">Archivo PDF Base</label>
        <input type="file" class="form-control-file" id="inputFilePDF">
      </div>
      <div class="form-group" style="padding-top: 25px;">
        <label for="">Seleccionar PDF</label>
        <button class="btn btn-primary my-1" onclick="document.getElementById('inputFilePDF').click();"><i class="fa fa-search" aria-hidden="true"></i>Seleccionar PDF</button>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group d-none">
        <label for="inputFileCSV">Archivo de Alumnos</label>
        <input type="file" class="form-control-file" id="inputFileCSV">
      </div>
      <div class="form-group" style="padding-top: 25px;">
        <label for="">Seleccionar Archivo CSV</label>
        <button class="btn btn-primary my-1" onclick="document.getElementById('inputFileCSV').click();"><i class="fa fa-search" aria-hidden="true"></i>Buscar Archivo</button>
        <button class="btn btn-success my-1" id="btnLoadCSV"><i class="fa fa-upload" aria-hidden="true"></i>Cargar Archivo</button>
      </div>
    </div>
    <div class="col-md-1" style="padding-top: 28px;">
      <div class="form-group">
        <label for="txtId">Evento ID</label>
        <input type="text" class="form-control" id="txtId">
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group" style="padding-top: 35px;">
        <label for=""></label>
        <button class="btn btn-success my-1" id="btnSend"><i class="fa fa-send" aria-hidden="true"></i>Enviar Constancias</button>
      </div>
    </div>
  </div>
  <div class="row">
    <table class="table table-striped" id="studentTable">
    </table>
  </div>
</div>

<?php include_once(VIEW_PATH . '/partials/blank_footer.php') ?>