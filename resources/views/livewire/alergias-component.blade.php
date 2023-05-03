<div>
    @push('title')
    Alergías
    @endpush
    <div class="container mt-3">
        <div class="row">
            <!-- nuevo o edit -->
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        @if ($editarRegistro)
                        <div class="card-title"><strong>Editar alergia</strong></div>
                        @else
                        <div class="card-title"><strong>Nueva alergia</strong></div>
                        @endif

                    </div>
                    <div class="card-body">
                        <div>
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" wire:model="nombre" autofocus>
                            @error('nombre')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        @if ($editarRegistro)
                        <button class="btn btn-success mt-2" wire:click="update"><i class="fa fa-save"></i> Guardar</button>
                        <button class="btn btn-secondary mt-2" wire:click="cancelEdit"><i class="fa fa-times"></i> Cancelar</button>
                        @else
                        <button class="btn btn-success mt-2" wire:click="store"><i class="fa fa-save"></i> Guardar</button>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><strong> Catálogo de alergias</strong></div>
                    </div>
                    <div class="card-body" style="max-height: fit-content">
                        <input type="search" name="search" id="search" class="form-control form-control-sm" wire:model="search" placeholder="Buscar...">
                        @if (count($alergias)>0)
                        <div class="table-container" style="max-height: 65vh; overflow:auto;">
                            <table class="table table-sm small">
                                <thead class="sticky-top bg-primary text-white">
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($alergias as $item)
                                    <tr>
                                        <td>{{$item->nombre}}</td>
                                        <td>
                                            <a href="#" title="Editar" wire:click.prevent="edit({{$item->id}})"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp; | &nbsp;&nbsp;
                                            <a href="#" title="Eliminar" class="text-danger deleteItem" data-id="{{$item->id}}"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        {{$alergias->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>




    @push('custom-scripts')
    <script>
        document.addEventListener('focus_name', function() {
            $('#nombre').focus()
        })

        document.addEventListener('scrolltop', function() {
            $(document).scrollTop(0)
        })

        $(document).on('click', '.deleteItem', function(e) {
            e.preventDefault()
            if (confirm('¿Estas seguro?')) {
                let id = $(this).data('id')
                Livewire.emit('delete', id);
            }
        })
    </script>
    @endpush
</div>