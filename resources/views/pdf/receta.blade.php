<?php

use Carbon\Carbon; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receta {{$nomPx}}</title>
</head>
<style>
    * {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    body {
        position: relative;
    }
</style>

<body>
    <!-- Logo -->
    <div style="left:25px; position: absolute;">
        <img src="./storage/logo.png" alt="esculapio">
    </div>

    <!-- Marca de agua -->
    <div style="top:310px; left:100px; position: absolute; opacity: 0.17; ">
        <img src="./storage/esculapio.png" alt="esculapio">
    </div>

    <div style="text-align: right;">
        <div><strong><i>Dra. Adriana Cruz Calderón</i></strong></div>
        <div><i><small>
        Alergía e Inmunología
        </small></i></div>
        <div><i><small>Universidad Autónoma de Tamaulipas,  <br> Hospital Regional Lic. Adolfo López Mateos CDMX</small> </i></div>
    </div>
    <hr>
    <h3 style="text-align: center;">RECETA MEDICA</h3>
    <br>
    <strong>Nombre del paciente:</strong> <span style="border-bottom: 1px solid #000; margin-right: 50px;">{{$nomPx}}</span>
    <strong>Edad:</strong> <span style="border-bottom: 1px solid #000; margin-right: 35px;">{{Carbon::parse($fechaNac)->age}}</span>
    <strong>Fecha:</strong> <span style="border-bottom: 1px solid #000; margin-right: 10px;">{{now()->format('d/m/Y')}}</span>
    <br><br>

    <ol>
        @foreach ($medicamentos as $item)
        <li>
            <strong>{{$item->medicamento}}</strong><br>
            <small>{{$item->indicaciones}}</small>
            <br><br>
        </li>
        @endforeach
    </ol>
    <br><br>
    <div style="position: absolute; bottom:0; left:0; margin-bottom:100px; margin-left: 10px;">
        <div style="border-top: 2px solid black; max-width:260px"><strong>Firma:</strong> Dra. Adriana Cruz Calderón</div>
        <div style="font-size:13px;"><strong>Ced Prof: </strong>3456784</div>
        <div style="font-size:13px;"><strong>Ced Esp.: </strong>1455578</div>
    </div>
    <div style="position: absolute; bottom:0; left:0; margin-bottom:10px; margin-left: 10px;">

    </div>
    <div style="position: absolute; bottom:0; left:0; margin-bottom:10px; margin-left: 10px;">
        <div><strong>Hospital Star Medica, Consultorios 707 y 708, Septimo piso</strong></div>
        <div style="font-size: 14px;"><strong>Avenida Paseo de la Victoria 4370, Cerrada Arboledas CP 32543, Ciudad Juárez, Chihuahua.</strong></div>
    </div>



    <!-- <div><strong>Hospital StarMedica consultorio 707 y 708</strong></div>  -->
</body>

</html>