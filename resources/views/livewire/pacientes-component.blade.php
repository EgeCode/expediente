<div>
    <?php

    use Carbon\Carbon; ?>
    @push('title')
    Pacientes
    @endpush
    <div class="container mt-3">
        <div class="row">
            <!-- Nuevo paciente -->
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        @if ($editarRegistro)
                        <div class="card-title"><strong>Editar paciente</strong></div>
                        @else
                        <div class="card-title"><strong>Nuevo paciente</strong></div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column">
                            <label for="photo">
                                <input type="file" name="photo" id="photo" class="d-none" wire:model="photo">
                                @if ($photo)
                                <img title="Cambia la foto del paciente" src="{{ $photo->temporaryUrl() }}" alt="Imagen de foto" style="height: 96px; width:96px; cursor:pointer">
                                @else
                                <img title="Cambia la foto del paciente" src="{{asset('storage')}}/user-avatar.png" alt="Avatar" style="cursor: pointer;">
                                @endif
                            </label>
                            <div wire:loading wire:target="photo">
                                <img src="{{asset('storage')}}/loading.gif" style="width:25px;" alt="Cargando"> <span style="font-size:13px"> Cargando...</small>
                            </div>
                            @error('photo')
                            <small class="text-danger">{{$message}}</small>    
                            @enderror
                            
                        </div>
                        <div>
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" wire:model="nombre" autofocus>
                            @error('nombre')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="apellido">Apellido</label>
                            <input type="text" class="form-control" name="apellido" id="apellido" wire:model="apellido">
                            @error('apellido')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="fechaDeNacimiento">Fecha de nacimiento</label>
                            <input type="date" class="form-control" name="fechaDeNacimiento" id="fechaDeNacimiento" wire:model="fechaDeNacimiento">
                            @error('fechaDeNacimiento')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" id="telefono" wire:model="telefono">
                            @error('telefono')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="tipoDeSangre">Tipo de sangre</label>
                            <select name="tipoDeSangre" id="tipoDeSangre" class="form-select" wire:model="tipoDeSangre">
                                <option value="">---Selecciona una opción---</option>
                                @foreach ($tipos as $item)
                                <option>{{$item}}</option>
                                @endforeach
                            </select>
                            @error('tipoDeSangre')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <label class="mt-2">Enfermedades cronicas </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="chkDiabetico" name="chkDiabetico" wire:model="diabetico">
                            <label class="form-check-label" for="flexCheckDefault">
                                Diabetico
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="chkHiper" name="chkHiper" wire:model="hipertenso">
                            <label class="form-check-label" for="flexCheckDefault">
                                Hipertenso
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="chkCovid" name="chkCovid" wire:model="covid">
                            <label class="form-check-label" for="flexCheckDefault">
                                Ha padecido COVID-19
                            </label>
                        </div>
                        @if ($editarRegistro)
                        <button class="btn btn-success mt-2" wire:click="update"><i class="fa fa-save"></i> Guardar</button>
                        <button class="btn btn-secondary mt-2" wire:click="clear"><i class="fa fa-save"></i> Cancelar</button>
                        @else
                        <button class="btn btn-success mt-2" wire:click="store"><i class="fa fa-save"></i> Guardar</button>
                        @endif

                    </div>

                </div>
            </div>
            <!-- ./nuevo -->

            <!-- Tabla pacientes -->
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><strong> Pacientes registrados</strong></div>
                    </div>
                    <div class="card-body" style="max-height: fit-content">
                        <input type="search" name="search" id="search" class="form-control form-control-sm" wire:model="search" placeholder="Buscar...">
                        @if (count($pacientes)>0)
                        <div class="table-container" style="max-height: 65vh; overflow:auto;">
                            <table class="table table-sm small">
                                <thead class="sticky-top bg-primary text-white">
                                    <th>Nombre</th>
                                    <th>Edad</th>
                                    <th>Teléfono</th>
                                    <th>Tipo de sangre</th>
                                    <th>Diabetico</th>
                                    <th>Hipertenso</th>
                                    <th>Padeció COVID-19</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($pacientes as $item)
                                    <tr>
                                        <td>{{$item->nombre.' '.$item->apellido}}</td>
                                        <td>{{Carbon::parse($item->fecha_nac)->age}}</td>
                                        <td>{{$item->tel}}</td>
                                        <td>{{$item->tipo_sangre}}</td>
                                        <td>
                                            @if ($item->diabetico)
                                            <span><i class="fa fa-check"></i></span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->hipertenso)
                                            <span><i class="fa fa-check"></i></span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->covid)
                                            <span><i class="fa fa-check"></i></span>
                                            @endif
                                        </td>
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
                        {{$pacientes->links()}}
                    </div>
                </div>
            </div>
            <!--./tabla pacientes -->
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