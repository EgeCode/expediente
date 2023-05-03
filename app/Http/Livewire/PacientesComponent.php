<?php

namespace App\Http\Livewire;

use App\Models\Paciente;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PacientesComponent extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $search = "";
    public $idPx = '';
    public $nombre = "";
    public $apellido = "";
    public $fechaDeNacimiento = "";
    public $telefono = "";
    public $tipoDeSangre = "";
    public $diabetico = 0;
    public $hipertenso = 0;
    public $covid = 0;
    public $tipos = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    public $editarRegistro = false;
    public $photo;


    protected $listeners = [
        'delete',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $pacientes = Paciente::where('active', 1)
            ->where(function ($q) {
                $q->where('apellido', 'LIKE', '%' . $this->search . '%');
                $q->orWhere('nombre', 'LIKE', '%' . $this->search . '%');
                $q->orWhere('tel', '=', $this->search);
            })
            ->orderBy('apellido')
            ->paginate(50);

        return view('livewire.pacientes-component', compact('pacientes'));
    }

    public function store()
    {

        $this->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'fechaDeNacimiento' => 'required',
            'photo'=> 'mimes:jpg,png|nullable'
        ]);


        $path = "";
        if($this->photo != null){
            $path = $this->photo->store('public/photos');
        }
        

        $px = new Paciente;
        $px->nombre = $this->nombre;
        $px->apellido = $this->apellido;
        $px->fecha_nac = $this->fechaDeNacimiento;
        $px->tel = $this->telefono;
        $px->tipo_sangre = $this->tipoDeSangre;
        $px->diabetico = $this->diabetico;
        $px->hipertenso = $this->hipertenso;
        $px->covid = $this->covid;
        $px->name_photo = ($path != "")? $path: null;
        $px->save();
        $this->clear();
        
        $this->dispatchBrowserEvent('scrolltop');
        $this->dispatchBrowserEvent('alerta', ['type' => 'success', 'title' => 'Listo!!', 'content' => 'Registro guardado']);
        $this->dispatchBrowserEvent('focus_name');

    }

    public function clear()
    {

        $this->editarRegistro = false;
        $this->nombre = "";
        $this->apellido = "";
        $this->fechaDeNacimiento = "";
        $this->telefono = "";
        $this->tipoDeSangre = "";
        $this->diabetico = 0;
        $this->hipertenso = 0;
        $this->covid = 0;
    }

    public function edit($id)
    {

        $px = Paciente::find($id);

        $this->idPx = $px->id;
        $this->nombre =  $px->nombre;
        $this->apellido =  $px->apellido;
        $this->fechaDeNacimiento =  $px->fecha_nac;
        $this->telefono =  $px->tel;
        $this->tipoDeSangre =  $px->tipo_sangre;
        $this->diabetico =  $px->diabetico;
        $this->hipertenso =  $px->hipertenso;
        $this->covid =  $px->covid;

        $this->editarRegistro = true;
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'fechaDeNacimiento' => 'required',
            'photo'=> 'mime: jpg|nullable'
        ]);

        $px = Paciente::find($this->idPx);
        $px->nombre = $this->nombre;
        $px->apellido = $this->apellido;
        $px->fecha_nac = $this->fechaDeNacimiento;
        $px->tel = $this->telefono;
        $px->tipo_sangre = $this->tipoDeSangre;
        $px->diabetico = $this->diabetico;
        $px->hipertenso = $this->hipertenso;
        $px->covid = $this->covid;
        
        $px->save();
        
        $this->clear();
        $this->dispatchBrowserEvent('alerta', ['type' => 'success', 'title' => 'Listo!!', 'content' => 'Cambios guardados']);
        $this->dispatchBrowserEvent('scrolltop');

    }

    public function delete($id){
        
        $alergia = Paciente::find($id);
        $alergia->active = 0;
        $alergia->save();
        $this->dispatchBrowserEvent('alerta', ['type'=>'success', 'title'=>'Listo!!', 'content'=>'Registro eliminado']);
        $this->dispatchBrowserEvent('scrolltop');
    }

    public function uploadPhoto()
    {
        $this->validate([
            
        ]);

        
    }
}
