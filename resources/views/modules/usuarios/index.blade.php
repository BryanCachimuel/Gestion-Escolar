@extends('layouts.main')

@section('titulo', $titulo)
    
@section('contenido')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Usuarios</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Administrar Usuarios</h5>
            <p>Administrar las cuentas y roles de los Usuarios</p>

            <a href="{{ route("usuarios.create") }}" class="btn btn-primary">
              <i class="fa-solid fa-user-plus"></i> Agregar Nuevo Usuario
            </a>
            <hr>
            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead class="text-center">
                <tr>
                 <th class="text-center">Correo</th>
                 <th class="text-center">Nombre</th>
                 <th class="text-center">Rol</th>
                 <th class="text-center">Cambio Contraseña</th>
                 <th class="text-center">Activo</th>
                 <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody id="tbody-usuarios">
                @include('modules.usuarios.tbody')
              </tbody>
            </table>
            <!-- End Table with stripped rows -->
          </div>
        </div>

      </div>
    </div>
  </section>

</main>
@include('modules.usuarios.modal_cambiar_password')
@endsection

@push('scripts')
    <script>

      function recargar_tbody(){
        $.ajax({
          type : "GET",
          url : "{{ route('usuarios.tbody') }}",
          success : function(respuesta){
            console.log(respuesta)
          } 
        });
      }

      // controlar el estado de los usuarios (activado, desactivado)
      function cambiar_estado(id, estado){
        $.ajax({
          type : "GET",
          url : "usuarios/cambiar-estado/" + id + "/" + estado,
          success : function(respuesta){
            if(respuesta == 1){
              Swal.fire({
                title: 'Exito',
                text: 'Cambio de estado exitoso',
                icon:'success',
                confirmButtonText: 'Aceptar'
              });
              recargar_tbody();
            }else{
              Swal.fire({
                title: 'Fallo',
                text: 'No se llevo acabo el cambio',
                icon:'error',
                confirmButtonText: 'Aceptar'
              });
            }
          }
        });
      }

      function agregar_id_usuario(id){
        $('#id_usuario').val(id);
      }

      function cambio_password(){
        let id = $('#id_usuario').val();
        let password = $('#password').val();

        $.ajax({
          type : "GET",
          url : "usuarios/cambiar-password/" + id + "/" + password,
          success : function(respuesta){
            if(respuesta == 1){
              Swal.fire({
                title: 'Exito',
                text: 'Cambio de contraseña exitoso',
                icon:'success',
                confirmButtonText: 'Aceptar'
              });
              $('#frmPassword')[0].reset();
            }else{
              Swal.fire({
                title: 'Fallo',
                text: 'Cambio de contraseña no exitoso',
                icon:'error',
                confirmButtonText: 'Aceptar'
              });
            }
          }
        });
        return false;
      }

      $(document).ready(function(){
        $('.form-check-input').on("change", function(){
          let id = $(this).attr("id");
          let estado = $(this).is(":checked") ? 1 : 0;
          cambiar_estado(id, estado);
        });
      });
    </script>
@endpush

