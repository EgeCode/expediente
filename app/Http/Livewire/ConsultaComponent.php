<?php

namespace App\Http\Livewire;

use App\Models\Alergia;
use App\Models\AlergiasPx;
use App\Models\Antecedente;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Receta;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class ConsultaComponent extends Component
{

    public $paciente = "";
    public $pxSelect = "";
    public $pacientes = [];
    public $searchPx = "";
    public $motivo = "";
    public $fc = "";
    public $pa = "";
    public $fr = "";
    public $temperatura = "";
    public $nota = "";
    public $medicamento = "";
    public $indicaciones = "";
    public $editarRegistro = false;
    public $medicamentos = [];
    public $alergias = [];
    public $consultasOld = [];
    public $consultaShow = "";
    public $recetaConsulta = "";
    public $antecedentes = "";

    protected $listeners = [

        'loadConsultas',
        'loadAntecedentes',
        'clearModal',
        
    ];

    public function render()
    {
        
        return view('livewire.consulta-component');
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

            if (count($this->pacientes) < 1)
                $this->dispatchBrowserEvent('alerta', ['type' => 'error', 'title' => 'Error', 'content' => 'No se encontrarón resultados']);
            
                
        }
    }

    public function clear()
    {
        $this->paciente = "";
        $this->pxSelect = "";
        $this->pacientes = [];
        $this->editarRegistro = false;
        $this->alergias = [];
    }

    public function selectPx()
    {
        $this->paciente = Paciente::find($this->pxSelect);
        
        $this->alergias = AlergiasPx::leftJoin('alergias', 'alergias.id', 'alergias_pxes.alergia')
            ->select(DB::raw('alergias.nombre as alergia'))
            ->where('alergias_pxes.px', $this->paciente->id)->get()->toArray();
    }

    public function getGrupoReceta()
    {
        $row = Receta::orderBy('grupo','DESC')->first();
        if($row != null)
            $grupo = $row->grupo + 1;
        else
            $grupo = 1;

        return $grupo;
    }

    public function addMedicamentos()
    {   
        if($this->medicamento != null){
            array_push($this->medicamentos, ['medicamento'=> $this->medicamento, 'indicaciones'=> $this->indicaciones]);
            $this->medicamento = "";
            $this->indicaciones= "";
            $this->dispatchBrowserEvent('focusMed');
        }
            

    }
    public function removeItemMed($index)
    {
        unset($this->medicamentos[$index]); 
    }

    public function store()
    {
        $this->validate([
            'motivo' =>'required',
            'nota' =>'required',

        ]);

        $cons = Consulta::where(DB::raw('DATE(created_at)'), now()->format('Y-m-d'))
                        ->where('px', $this->paciente->id)
                        ->where('user', Auth::user()->id)
                        ->get();

        if(count($cons) < 1){

            $consulta = new Consulta();
            $consulta->px = $this->paciente->id;
            $consulta->user = Auth::user()->id;
            $consulta->motivo = $this->motivo;
            $consulta->nota = $this->nota;
            $consulta->temperatura = $this->temperatura;
            $consulta->fc = $this->fc;
            $consulta->pa = $this->pa;
            $consulta->fr = $this->fr;
            $consulta->save();

            //guardamos la receta si es que hay medicamentos agregados
            if(count($this->medicamentos) > 0){

                $grupo = $this->getGrupoReceta();

                foreach($this->medicamentos as $item){
    
                    $receta = new Receta();
                    $receta->px = $this->paciente->id;
                    $receta->user = Auth::user()->id;
                    $receta->grupo = $grupo;
                    $receta->medicamento = $item["medicamento"];
                    $receta->indicaciones = $item["indicaciones"];
                    $receta->consulta = $consulta->id;
                    $receta->save();
    
                }  
                
                //mandamos imprimir la receta
                //$recetaPrint = Receta::where('consulta', )->get();
                $this->dispatchBrowserEvent('openReceta', [ 'idCons' => $consulta->id]);
            }
            $this->dispatchBrowserEvent('scrolltop');
            $this->dispatchBrowserEvent('alerta', ['type' => 'success', 'title' => 'Listo!!', 'content' => 'Registro guardado']);
        }else{
            $this->dispatchBrowserEvent('alerta', ['type' => 'error', 'title' => 'Listo!!', 'content' => 'No puedes registrar dos consultas el mismo dia']);
        }
    }

    public function loadConsultas()
    {
        $this->consultasOld = Consulta::where('px', $this->paciente->id)->get();
        $this->dispatchBrowserEvent('openConsultas');
    }

    public function loadAntecedentes(){
        
        $this->antecedentes = Antecedente::where('px', $this->paciente->id)
                                        ->where('user', Auth::user()->id)
                                        ->first();

        $this->dispatchBrowserEvent('openHistorial');
    }

    public function showConsulta($id)
    {
        $this->consultaShow = Consulta::find($id);
        $this->recetaConsulta = Receta::where('consulta', $this->consultaShow->id)->get();
    }

    public function clearModal()
    {
        $this->consultaShow = "";
        $this->recetaConsulta = "";
        $this->antecedentes = "";
    }

    public function deleteConsulta($id)
    {
        Consulta::find($id)->delete();
        $this->clearModal();
        $this->loadConsultas();  
        $this->dispatchBrowserEvent('scrolltop');
        $this->dispatchBrowserEvent('alerta', ['type' => 'success', 'title' => 'Listo!!', 'content' => 'Registro eliminado']);

        
    }

    public function printReceta()
    {
        
    }
}
