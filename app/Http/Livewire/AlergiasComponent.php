<?php

namespace App\Http\Livewire;

use App\Models\Alergia;
use Illuminate\Console\View\Components\Alert;
use Livewire\Component;
use Livewire\WithPagination;

class AlergiasComponent extends Component
{
    
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search="";

    public $idAlergia = "";
    public $nombre = "";
    public $editarRegistro= false;

    protected $listeners = [
        'delete',
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $alergias = [];
        $alergias = Alergia::where('active', 1)
                            ->where('nombre', 'LIKE', '%'.$this->search.'%')
                            ->paginate(20);

        return view('livewire.alergias-component', compact('alergias'));
    }

    public function store(){
        
        $this->validate([
            'nombre'=>'required',
            
        ]);

        $alergia = new Alergia;
        $alergia->nombre = $this->nombre;
        $alergia->save();
        $this->clear();

        $this->dispatchBrowserEvent('scrolltop');
        $this->dispatchBrowserEvent('alerta', ['type'=>'success', 'title'=>'Listo!!', 'content'=>'Registro guardado']);
        $this->dispatchBrowserEvent('focus_name');
        
    }
    
    public function edit($id){
        
        $alergia = Alergia::find($id);

        $this->idAlergia = $alergia->id;
        $this->nombre =  $alergia->nombre;
        $this->editarRegistro = true;
    }

    public function update(){
        
        $this->validate([
            'nombre'=>'required',
            
        ]);

        $alergia = Alergia::find($this->idAlergia);
        $alergia->nombre = $this->nombre;
        $alergia->save();
        $this->dispatchBrowserEvent('scrolltop');
        $this->dispatchBrowserEvent('alerta', ['type'=>'success', 'title'=>'Listo!!', 'content'=>'Cambios guardados']);

    }

    public function clear(){
        
        $this->nombre = "";
    }

    public function cancelEdit(){

        $this->nombre = "";
        $this->editarRegistro = false;
    }

    public function delete($id){
        
        $alergia = Alergia::find($id);
        $alergia->active = 0;
        $alergia->save();
        $this->dispatchBrowserEvent('scrolltop');
        $this->dispatchBrowserEvent('alerta', ['type'=>'success', 'title'=>'Listo!!', 'content'=>'Registro eliminado']);
        
    }
}
