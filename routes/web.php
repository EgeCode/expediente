<?php

use App\Http\Controllers\PDFController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\AlergiasComponent;
use App\Http\Livewire\AntecedentesComponent;
use App\Http\Livewire\ConsultaComponent;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\LoginComponent;
use App\Http\Livewire\PacientesComponent;
use Illuminate\Support\Facades\Route;

Route::get('/',LoginComponent::class)->name('login');


//Rutas protegidas
Route::middleware(['auth'])->group(function(){
    Route::get('/home',HomeComponent::class)->name('home');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    //pacientes
    Route::get('/pacientes', PacientesComponent::class)->name('pacientes');
    //alergias
    Route::get('/alergias', AlergiasComponent::class)->name('alergias');
    //antecedentes
    Route::get('/historia_clinica', AntecedentesComponent::class)->name('antecedentes');
    //consulta
    Route::get('/consulta', ConsultaComponent::class)->name('consulta');
    Route::get('/receta/{idConsulta}', [PDFController::class, 'index'])->name('receta');
  
});
