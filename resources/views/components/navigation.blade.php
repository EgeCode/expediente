<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Expediente Electrónico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('home')}}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('pacientes')}}">Pacientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('antecedentes')}}">Historia clínica</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('alergias')}}">Catálogo de alergias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('consulta')}}">Consulta</a>
                </li>
                <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li> -->
                <!-- <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li> -->
            </ul>

            <ul class="navbar-nav ms-auto mr-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{auth()->user()->nombre.' '.auth()->user()->apellido}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <form class="form-inline" action="{{route('logout')}}" method="POST" onclick="return confirm('¿Estas seguro de salir del sistema?')">
                            @csrf
                            <button class="btn btn-link text-dark">Salir</button>
                        </form>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>