<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function index($idConsulta)
    {
        $datos = Receta::leftJoin('pacientes','pacientes.id', 'recetas.px')
                        ->leftJoin('users', 'users.id', 'recetas.user')
                        ->select(DB::raw("recetas.*, CONCAT_WS(' ',pacientes.nombre,pacientes.apellido) 
                        as nomPx, pacientes.fecha_nac, CONCAT_WS(' ',users.nombre, users.apellido) as nomUser"))
                        ->where('consulta', $idConsulta)->get();

        $data = [
            'nomPx' => $datos[0]->nomPx,
            'userMed' => $datos[0]->nomUser,
            'fechaNac' => $datos[0]->fecha_nac,
            'medicamentos'=> $datos,
        ];

        
        $pdf = Pdf::loadView('pdf.receta', $data)->setPaper('letter', 'potrait');
        return $pdf->stream('receta.pdf');
    }
}
