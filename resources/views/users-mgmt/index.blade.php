@extends('users-mgmt.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">Mostrar Empleado</h3>
        </div>
        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('user-management.create') }}"><i class="glyphicon glyphicon-plus-sign"></i> Nuevo Empleado</a>
        </div>
        @endif
    </div>
  </div>
  <!-- /.box-header -->
  @if (4 != Auth::user()->rol_id)
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('user-management.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Search'])
          @component('layouts.two-cols-search-row', ['items' => ['Nombre1', 'DPI'], 
          'oldVals' => [isset($searchingVals) ? $searchingVals['nombre1'] : '', isset($searchingVals) ? $searchingVals['dpi'] : '']])
          @endcomponent
        @endcomponent
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th width="30%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Puesto: activate to sort column ascending">Nombre</th>
                <th width="10%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Puesto: activate to sort column ascending">Puesto Encargado</th>
                <th width="10%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">DPI</th>
                <th tabindex="0" aria-controls="example2" rowspan="1" colspan="3" aria-label="Action: activate to sort column ascending">Opciones</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr role="row" class="odd">
                  <td class="sorting_1">{{ $user->nombre1 }} {{ $user->nombre2 }} {{ $user->nombre3 }} {{ $user->apellido1 }} {{ $user->apellido2 }} {{ $user->apellido3 }}</td>
                  <td class="hidden-xs">{{ $user->rols_nombre }}</td>
                  <td class="hidden-xs">{{ $user->dpi }}</td>
                  <td>
                    <form class="row" method="POST" action="{{ route('user-management.destroy', ['id' => $user->id]) }}" onsubmit = "return confirm('¿Está seguro que quiere eliminar a el registro?')">
                        
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
                        <a href="{{ route('user-management.edit', ['id' => $user->id]) }}" class="btn btn-warning col-sm-3 col-xs-2 btn-margin"><i class="fa fa-edit"></i> 
                          Actualizar
                        </a>
                        @endif
                        @if (4 != Auth::user()->rol_id)
                        <a href="{{ route('user-management.view', ['id' => $user->id]) }}" class="btn btn-default col-sm-3 col-xs-2 btn-margin" style="background-color:#009e0f"><i class="fa fa-eye"></i> 
                          Ver más
                        </a>
                        @endif
                        @if (1 == Auth::user()->rol_id)
                        @if ($user->username != Auth::user()->username)
                         <button type="submit" class="btn btn-danger col-sm-3 col-xs-2 btn-margin"><i class="fa fa-trash-o"></i> 
                          Eliminar
                        </button>
                        @endif
                        @endif
                    </form>
                  </td>
              </tr>
            @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th width="30%" rowspan="1" colspan="1">Nombre</th>
                <th width="10%" rowspan="1" colspan="1">Puesto Encargado</th>
                <th width="10%" rowspan="1" colspan="1">DPI</th>
                <th rowspan="1" colspan="3">Opciones</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Registros mostrados {{count($users)}}, registros existentes {{count($users)}}</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $users->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection