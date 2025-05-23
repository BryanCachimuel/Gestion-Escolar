@extends('layouts.main')

@section('titulo', $titulo)
    
@section('contenido')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Reportes de Productos con cantidad 1 o 0</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Reportes de Productos con cantidad 1 o 0</h5>

            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <tr class="text-start">
                 <th>Categoría</th>
                 <th>Proveedor</th>
                 <th>Nombre</th>
                 <th>Imagen</th>
                 <th>Descripción</th>
                 <th>Cantidad</th>
                 <th>Venta</th>
                 <th>Compra</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                <tr>
                  <td>{{ $item->nombre_categoria }}</td>
                  <td>{{ $item->nombre_proveedor }}</td>
                  <td>{{ $item->nombre }}</td>
                  <td>
                    <img src="{{ asset('storage/'.$item->imagen_producto) }}" width="80px" height="80px" alt="">
                  </td>
                  <td>{{ $item->descripcion }}</td>
                  <td class="text-center">{{ $item->cantidad }}</td>
                  <td class="text-center">$ {{ $item->precio_compra }}</td>
                  <td class="text-center">$ {{ $item->precio_venta }}</td>
                </tr>
                @endforeach
              </tbody>
             
            </table>
            <!-- End Table with stripped rows -->
             <div class="text-center mt-3">
                <a href="{{ route('reportes_productos') }}" class="btn btn-outline-danger"><i class="fa-solid fa-circle-xmark"></i> Cancelar</a>
             </div>
          </div>
        </div>

      </div>
    </div>
  </section>

</main>
@endsection