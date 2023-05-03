<div>
    <?php

    use Carbon\Carbon; ?>
    @push('title')
    Historia clínica
    @endpush
    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><strong>Paciente</strong></div>
                    </div>
                    <div class="card-body">
                        <label for="buscarPx">Buscar paciente</label>
                        <div class="input-group">
                            <input type="search" name="buscarPx" id="buscarPx" wire:model="searchPx" class="form-control" placeholder="Nombre o teléfono">
                            <button class="btn btn-primary" wire:click="buscaPx"><i class="fa fa-search"></i></button>
                        </div>
                        <hr>
                        @if (count($pacientes) > 0)
                        <label for="pacientes">Pacientes encontrados</label>
                        <select name="pacientes" id="pacientes" class="form-select" wire:change="selectPx" wire:model="pxSelect">
                            <option value="">---Selecciona una opción---</option>
                            @foreach ($pacientes as $item)
                            <option value="{{$item->id}}">{{$item->nombre.' '.$item->apellido}}</option>
                            @endforeach
                        </select>
                        @endif

                        @if ($paciente != '')
                        <div class="alert alert-info mt-2">
                            <h6>Paciente seleccionado</h6>
                            <hr>
                            <div><strong>Nombre:</strong> {{$paciente->nombre .' '.$paciente->apellido}}</div>
                            <div><strong>Edad:</strong> {{Carbon::parse($paciente->fecha_nac)->age}}</div>
                            <div><strong>Teléfono:</strong> {{$paciente->tel}}</div>
                            <div><strong>Tipo de sangre:</strong> {{$paciente->tipo_sangre}}</div>
                            <div><strong>Diabetico:</strong>
                                @if ($paciente->diabetico)
                                <span><i class="fa fa-check"></i></span>
                                @endif
                            </div>
                            <div><strong>Hipertenso:</strong>
                                @if ($paciente->hipertenso)
                                <span><i class="fa fa-check"></i></span>
                                @endif
                            </div>
                            <div><strong>Padeció COVID-19:</strong>
                                @if ($paciente->covid)
                                <span><i class="fa fa-check"></i></span>
                                @endif
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><strong>Antecedentes</strong></div>
                    </div>
                    <div class="card-body">
                        <div>
                            <label for="familiares">Familiares</label>
                            <textarea type="text" class="form-control" name="familiares" id="familiares" wire:model="familiares"></textarea>
                        </div>
                        <div>
                            <label for="noFamiliares">No Familiares</label>
                            <textarea type="text" class="form-control" name="noFamiliares" id="noFamiliares" wire:model="noFamiliares"></textarea>
                        </div>
                        <div>
                            <label for="patologicos">Patologicos</label>
                            <textarea type="text" class="form-control" name="patologicos" id="patologicos" wire:model="patologicos"></textarea>
                        </div>
                        <div>
                            <label for="noPatologicos">No Patologicos</label>
                            <textarea type="text" class="form-control" name="noPatologicos" id="noPatologicos" wire:model="noPatologicos"></textarea>
                        </div>
                        <div>
                            <label for="ginecologicos">Ginecologicos</label>
                            <textarea type="text" class="form-control" name="ginecologicos" id="ginecologicos" wire:model="ginecologicos"></textarea>
                        </div>
                        <div>
                            <label for="quirurgicos">Quirurgicos</label>
                            <textarea type="text" class="form-control" name="quirurgicos" id="quirurgicos" wire:model="quirurgicos"></textarea>
                        </div>
                        <div>
                            <label for="psiquiatricos">Psiquiatricos</label>
                            <textarea type="text" class="form-control" name="psiquiatricos" id="psiquiatricos" wire:model="psiquiatricos"></textarea>
                        </div>
                        @if ($editarRegistro)
                        <button class="btn btn-success mt-3" wire:click="update"><i class="fa fa-save"></i> Guardar</button>
                        @else
                        <button class="btn btn-success mt-3" wire:click="store"><i class="fa fa-save"></i> Guardar</button>
                        @endif
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><strong>Alergias</strong></div>
                    </div>
                    <div class="card-body">
                        <label for="alergias">Alergias</label>
                        <div class="input-group">
                            <select name="alergias" id="alergias" class="form-select" wire:model="alergiaSelect">
                                <option value="">---Selecciona una opción---</option>
                                @foreach ($alergias as $item)
                                <option value="{{$item->id}}">{{$item->nombre}}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary" wire:click="addAlergia" title="Agregar alergia"><i class="fa fa-plus"></i></button>
                        </div>
                        <hr>
                        <h6>Alergias asignar al paciente</h6>
                        @if (count($alergiasToPx)>0)
                        <table class="table table-sm small">
                            <thead>
                                <th>Nombre de la alergia</th>
                                <th>Eliminar</th>
                            </thead>
                            <tbody>
                                @foreach ($alergiasToPx as $item => $value)
                                <tr>
                                    <td>{{$value["alergia"]}}</td>
                                    <td><a href="#" wire:click.prevent="borrarAlergia({{$item}})" class="text-danger" title="Quitar de la lista"><i class="fa fa-minus"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif

                        <button class="btn btn-success mt-3" wire:click="storeAlergias"><i class="fa fa-save"></i> Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    @push('custom-scripts')
    <script>
        document.addEventListener('scrolltop', function() {
            $(document).scrollTop(0)
        })
    </script>
    @endpush
</div>