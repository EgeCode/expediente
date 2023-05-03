<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>@stack('title')</title>
    @livewireStyles
</head>
<style>
    /* body{
        position: relative;
    } */
</style>
@component('components.navigation')
@endcomponent
<body>
    {{ $slot }}
    <!-- Alerta -->
    <div id="alert-toast" class="toast align-items-center text-white bg-primary border-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; bottom:0; right:0;">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @livewireScripts
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('alerta', event => {

            switch (event.detail.type) {

                case 'success':
                    $('.toast').removeClass('bg-danger');
                    $('.toast').addClass('bg-success');
                    break
                case 'error':
                    $('.toast').removeClass('bg-success');
                    $('.toast').addClass('bg-danger');
                    break
            }

            // $('.title-alert').html(event.detail.title)
            $('.toast-body').html(event.detail.content)
            $('#alert-toast').toast('show')

        })
    </script>
    @stack('custom-scripts')
</body>
</html>