<div>
    <?php

    use Carbon\Carbon; ?>

    @push('title')
    Consulta
    @endpush
    <div class="container mt-3">
        <div class="card">
            <h5 class="card-header">Nueva Consulta</h5>
            <div class="card-body">
                <label for="buscarPaciente">Buscar paciente</label>
                <div class="input-group">
                    <input type="search" name="buscarPaciente" id="buscarPaciente" class="form-control" wire:model="searchPx" placeholder="Nombre, apellido, teléfono...">
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

                <div>
                    @if ($paciente != "")
                    <div class="card sticky-top" style="background-color: #F0F0F0;">

                        <div class="card-body">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic mixed styles example" style="position: absolute; top:0; right:0">
                                <button type="button" class="btn btn-primary" wire:click="loadConsultas"><i class="fa fa-file-text-o" aria-hidden="true"></i> Consultas</button>
                                <button type="button" class="btn btn-secondary" wire:click="loadAntecedentes"><i class="fa fa-book" aria-hidden="true"></i> Antecedentes</button>
                            </div>

                            <div>
                                <strong>Nombre:</strong> {{$paciente->nombre .' '.$paciente->apellido}} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Edad:</strong> {{Carbon::parse($paciente->fecha_nac)->age}} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Teléfono:</strong> {{$paciente->tel}} &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Tipo de sangre:</strong> {{$paciente->tipo_sangre}}
                            </div>
                            <div>
                                <strong>Diabetico:</strong>
                                @if ($paciente->diabetico)
                                <span><i class="fa fa-check"></i></span>
                                @endif
                                &nbsp;&nbsp;&nbsp;&nbsp;

                                <strong>Hipertenso:</strong>
                                @if ($paciente->hipertenso)
                                <span><i class="fa fa-check"></i></span>
                                @endif

                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Padeció COVID-19:</strong>
                                @if ($paciente->covid)
                                <span><i class="fa fa-check"></i></span>
                                @endif

                                &nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div>
                                <hr>
                                <strong>Alergias:</strong>
                                @foreach ($alergias as $item)
                                <span class="badge bg-danger rounded-pill">{{$item["alergia"]}}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <h6 class="mb-2">Consulta</h6>

                    <div>
                        <label for="motivo">Motivo</label>
                        <input type="text" name="motivo" id="motivo" class="form-control" wire:model="motivo">
                        @error('motivo')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <h6>Signos vitales</h6>
                    <div class="d-flex align-items-center justify-content-start">
                        <div class="me-2">
                            <label for="fc">FC</label>
                            <input type="text" name="fc" id="fc" class="form-control" wire:model="fc">
                            @error('fc')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="me-2">
                            <label for="pa">PA</label>
                            <input type="text" name="pa" id="pa" class="form-control" wire:model="pa">
                            @error('pa')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="me-2">
                            <label for="fc">FR</label>
                            <input type="text" name="fr" id="fr" class="form-control" wire:model="fr">
                            @error('fr')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="me-2">
                            <label for="temperatura">Temperatura</label>
                            <input type="text" name="temperatura" id="temperatura" class="form-control" wire:model="temperatura">
                            @error('temperatura')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                    </div>
                    <h6>Nota de evolución</h6>
                    <textarea name="nota" id="nota" rows="10" class="form-control" wire:model="nota"></textarea>
                    @error('nota')
                    <small class="text-danger">{{$message}}</small>
                    @enderror

                    <h6>Tratamiento (medicamentos)</h6>
                    <div>
                        <label for="medicamento">Medicamento</label>
                        <input type="text" class="form-control" id="medicamento" name="medicamento" wire:model="medicamento">
                    </div>
                    <div>
                        <label for="indicaciones">Indicaciones</label>
                        <textarea type="text" class="form-control" id="indicaciones" name="indicaciones" wire:model="indicaciones"></textarea>
                    </div>
                    <button class="btn btn-primary mt-2 btn-sm" wire:click="addMedicamentos"><i class="fa fa-plus"></i> Agregar</button>
                    <br><br>
                    @if (count($medicamentos) > 0)
                    <table class="table table-sm small">
                        <thead>
                            <th>Medicamento</th>
                            <th>Indicaciones</th>
                            <th>Eliminar</th>
                        </thead>
                        <tbody>
                            @foreach ($medicamentos as $item => $value)
                            <tr>
                                <td>{{$value["medicamento"]}}</td>
                                <td>{{$value["indicaciones"]}}</td>
                                <td>
                                    <a href="#" wire:click.prevent="removeItemMed({{$item}})" class="text-danger"><i class="fa fa-minus"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    <br>
                    <hr>
                    <button class="btn btn-success mt-2" wire:click="store"><i class="fa fa-save"></i> Guardar</button>


                </div>
            </div>
        </div>
    </div>
    <div id="modalConsultas" wire:ignore.self class="modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Consultas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($consultasOld)
                    <div style="max-height: 200px; overflow: auto;">
                        <table class="table table-sm small">
                            <thead>
                                <th>Fecha</th>
                                <th>Motivo</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($consultasOld as $item)
                                <tr>
                                    <td>{{Carbon::parse($item->created_at)->format('d-m-Y')}}</td>
                                    <td>{{$item->motivo}}</td>
                                    <td>
                                        <a href="#" class="mx-2" title="Ver consulta" wire:click.prevent="showConsulta({{$item->id}})"><i class="fa fa-eye"></i></a>
                                        @if (Carbon::parse($item->created_at)->format('d-m-Y') == now()->format('d-m-Y'))
                                        |<a href="#" class="mx-2 text-danger" title="Eliminar" wire:click.prevent="deleteConsulta({{$item->id}})"><i class="fa fa-trash"></i></a>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if ($consultaShow != "")
                    <div class="card mt-2">
                        <h5 class="card-header">{{Carbon::parse($consultaShow->created_at)->format('d/m/Y') .' - '. $consultaShow->motivo}}</h5>
                        <div class="card-body">
                            <label><strong>Nota de evolución:</strong></label>
                            <div><small>{{$consultaShow->nota}}</small></div>
                            <hr>
                            <label><strong>Signos vitales</strong></label>
                            <div class="d-flex">
                                <div class="me-3"><small><strong>Temperatura: </strong>{{$consultaShow->temperatura}}</small></div>
                                <div class="me-3"><small><strong>FC: </strong>{{$consultaShow->fc}}</small></div>
                                <div class="me-3"><small><strong>PA: </strong>{{$consultaShow->pa}}</small></div>
                                <div class="me-3"><small><strong>FR: </strong>{{$consultaShow->fr}}</small></div>
                            </div>
                            <hr>
                            <label for="tratamiento"><strong>Tratamiento</strong></label>
                            <div>
                                @if (count($recetaConsulta) > 0)
                                <table class="table table-sm small">
                                    <thead>
                                        <th><small>Medicamento</small></th>
                                        <th><small>Indicaciones</small></th>
                                    </thead>
                                    <tbody>
                                        @foreach ($recetaConsulta as $item)
                                        <tr>
                                            <td><small>{{$item->medicamento}}</small></td>
                                            <td><small>{{$item->indicaciones}}</small></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif

                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <br>
    <div id="modalAntecedentes" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Antecedentes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mt-2">
                        <div class="card-body">
                            @if ($antecedentes != "")
                            <label><strong>Familiares:</strong></label>
                            <div><small>{{$antecedentes->familiares}}</small></div>
                            <hr>
                            <label><strong>No familiares:</strong></label>
                            <div><small>{{$antecedentes->no_familiares}}</small></div>
                            <hr>
                            <label><strong>Patologicos:</strong></label>
                            <div><small>{{$antecedentes->patologicos}}</small></div>
                            <hr>
                            <label><strong>No patologicos:</strong></label>
                            <div><small>{{$antecedentes->no_patologicos}}</small></div>
                            <hr>
                            <label><strong>Ginecologicos:</strong></label>
                            <div><small>{{$antecedentes->ginecologicos}}</small></div>
                            <hr>
                            <label><strong>Quirurgicos:</strong></label>
                            <div><small>{{$antecedentes->qxs}}</small></div>
                            <hr>
                            <label><strong>Psiquiatricos:</strong></label>
                            <div><small>{{$antecedentes->psiquiatricos}}</small></div>
                            <hr>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('custom-scripts')
    <script>
        $(document).on('openConsultas', function() {

            $('#modalConsultas').modal('show')
        })

        $(document).on('openHistorial', function() {

            $('#modalAntecedentes').modal('show')
        })

        $(document).on('hidden.bs.modal', '#modalConsultas, #modalAntecedentes', function() {

            Livewire.emit('clearModal')
        })

        $(document).on('focusMed', function() {
            $('#medicamento').focus()

        })

        $(document).on('scrolltop', function() {
            $(document).scrollTop(0);

        })

        $(document).on('openReceta', function(event) {

            setTimeout(() => {
                window.open("/receta/" + event.detail.idCons)
            }, 1500);

        })
    </script>
    @endpush
</div>