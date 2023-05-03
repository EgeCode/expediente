<div>
    <div class="container">

        <div class="mx-auto col-lg-4 my-5">
            <div class="card">
                <div class="card-header text-center" style="font-size: 17px;">
                    <strong>Sistema de expediente clínico electrónico</strong>
                </div>
                <div class="card-body">
                    <form id="frmLogin" >
                        @error('credentials')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                        <div>
                            <label for="username">Usuario</label>

                            <input type="text" class="form-control" name="username" id="username" wire:model="username" autofocus>
                            @error('username')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" name="pass" id="pass" wire:model="password">
                            @error('password')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button form="fmrLogin" class="btn btn-primary col-lg-12" wire:click.prevent="login"><i class="fa fa-sign-in"></i> Entrar</button>
                </div>


            </div>
        </div>
    </div>

</div>