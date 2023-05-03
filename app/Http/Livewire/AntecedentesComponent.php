<?php

namespace App\Http\Livewire;

use App\Models\Alergia;
use App\Models\AlergiasPx;
use App\Models\Antecedente;
use App\Models\Paciente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AntecedentesComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = "";
    public $searchPx = "";
    public $pxSelect = "";
    public $paciente = "";
    public $pacientes = [];
    public $antecedentes = "";
    public $familiares = "";
    public $noFamiliares = "";
    public $patologicos = "";
    public $noPatologicos = "";
    public $ginecologicos = "";
    public $quirurgicos = "";
    public $psiquiatricos = "";
    public $editarRegistro = false;
    public $alergias;
    public $alergiaSelect = "";
    public $alergiasToPx = [];


    public function render()
    {
        $this->alergias = Alergia::where('active', 1)->get();
        return view('livewire.antecedentes-component');
    }

    public function buscaPx()
    {

        if ($this->searchPx != "") {
            
            $this->clear();
            $this->pacientes = Paciente::where('active', 1)
                ->where(function ($q) {
                    $q->where('apellido', 'LIKE', '%' . $this->searchPx . '%');
                    $q->orWhere('nombre', 'LIKE', '%' . $this->searchPx . '%');
                    $q->orWhere('tel', '=', $this->searchPx);
                })->get();
                
        if(count($this->pacientes) < 1){
            
            $this->dispatchBrowserEvent('scrolltop');
            $this->dispatchBrowserEvent('alerta', ['type' => 'error', 'title' => 'Error', 'content' => 'No se encontrarón resultados']);
        }
                
                
        }
    }

    public function selectPx()
    {

        $this->paciente = Paciente::find($this->pxSelect);
        if ($this->paciente != null) {

            $this->antecedentes = Antecedente::where('px', $this->paciente->id)->first();

            if ($this->antecedentes != null) {

                $this->familiares = $this->antecedentes->familiares;
                $this->noFamiliares = $this->antecedentes->no_familiares;
                $this->patologicos = $this->antecedentes->patologicos;
                $this->noPatologicos = $this->antecedentes->familiares;
                $this->ginecologicos = $this->antecedentes->ginecologicos;
                $this->quirurgicos = $this->antecedentes->qxs;
                $this->psiquiatricos = $this->antecedentes->psiquiatricos;
                $this->editarRegistro = true;
            }

            $this->alergiasToPx = AlergiasPx::leftJoin('alergias', 'alergias.id', 'alergias_pxes.alergia')
                ->leftJoin('pacientes', 'pacientes.id', 'alergias_pxes.px')
                ->select(DB::raw('alergias.nombre as alergia ,alergias.id as idAlergia, pacientes.id as idPx,pacientes.nombre as px'))
                ->where('alergias_pxes.px', $this->paciente->id)->get()->toArray();
        }
    }

    public function store()
    {

        if ($this->paciente != "") {
            $antecedentes = new Antecedente;
            $antecedentes->px = $this->paciente->id;
            $antecedentes->user = Auth::user()->id;
            $antecedentes->familiares = $this->familiares;
            $antecedentes->no_familiares = $this->noFamiliares;
            $antecedentes->patologicos = $this->patologicos;
            $antecedentes->no_patologicos = $this->noPatologicos;
            $antecedentes->ginecologicos = $this->ginecologicos;
            $antecedentes->qxs = $this->quirurgicos;
            $antecedentes->psiquiatricos = $this->psiquiatricos;
            $antecedentes->save();

            $this->dispatchBrowserEvent('scrolltop');
            $this->dispatchBrowserEvent('alerta', ['type' => 'success', 'title' => 'Listo!!', 'content' => 'Registro guardado']);
            
        } else {

            $this->dispatchBrowserEvent('scrolltop');
            $this->dispatchBrowserEvent('alerta', ['type' => 'error', 'title' => 'Error', 'content' => 'Se requiere paciente']);
        }
    }

    public function update()
    {

        $antecedentes = Antecedente::find($this->antecedentes->id);
        $antecedentes->familiares = $this->familiares;
        $antecedentes->no_familiares = $this->noFamiliares;
        $antecedentes->patologicos = $this->patologicos;
        $antecedentes->no_patologicos = $this->noPatologicos;
        $antecedentes->ginecologicos = $this->ginecologicos;
        $antecedentes->qxs = $this->quirurgicos;
        $antecedentes->psiquiatricos = $this->psiquiatricos;
        $antecedentes->save();

        $this->dispatchBrowserEvent('scrolltop');
        $this->dispatchBrowserEvent('alerta', ['type' => 'success', 'title' => 'Listo!!', 'content' => 'Cambios guardados']);
        
    }

    public function clear()
    {

        $this->pxSelect = "";
        $this->paciente = "";
        $this->pacientes = [];
        $this->antecedentes = "";
        $this->familiares = "";
        $this->noFamiliares = "";
        $this->patologicos = "";
        $this->noPatologicos = "";
        $this->ginecologicos = "";
        $this->quirurgicos = "";
        $this->psiquiatricos = "";
        $this->editarRegistro = false;
        $this->alergiasToPx = [];
    }

    public function addAlergia()
    {
        $alergia = Alergia::find($this->alergiaSelect);
        if ($alergia != null && $this->paciente != "")
            array_push($this->alergiasToPx,  ['alergia' => $alergia->nombre, 'idAlergia' => $alergia->id, 'idPx' => $this->paciente->id, 'px' => $this->paciente->nombre]);
        else
            $this->dispatchBrowserEvent('alerta', ['type' => 'error', 'title' => 'Error', 'content' => 'Se requiere paciente y alergia']);
    }

    public function borrarAlergia($index)
    {
        unset($this->alergiasToPx[$index]);
    }
    public function storeAlergias()
    {

        if (count($this->alergiasToPx) > 0) {

            AlergiasPx::where('px', $this->paciente->id)->delete();
            foreach ($this->alergiasToPx as $item) {

                $antpx = new  AlergiasPx;
                $antpx->alergia = $item["idAlergia"];
                $antpx->px = $item["idPx"];
                $antpx->save();
            }

            $this->dispatchBrowserEvent('scrolltop');
            $this->dispatchBrowserEvent('alerta', ['type' => 'success', 'title' => 'Listo!!', 'content' => 'Alergias asignadas']);
            
        }
    }
}
