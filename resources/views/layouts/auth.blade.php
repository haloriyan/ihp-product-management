<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {!! json_encode(config('tailwind')) !!}
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        div, aside, header, * { transition: 0.4s; }
        body {
            font-family: "Poppins", sans-serif;
            font-style: normal;
            font-weight: 400;
        }
    </style>
    @yield('head')
</head>
<body class="bg-white">
    
<div class="absolute top-0 left-0 right-0 bottom-0 flex items-center justify-center gap-4 flex z-10">
    @yield('content')
</div>

<script>
    const select = dom => document.querySelector(dom);
    const selectAll = dom => document.querySelectorAll(dom);
    const toggleHidden = target => {
        select(target).classList.toggle('hidden');
    }

    const toasts = selectAll(".toast");
    let toastInterval = null;

    if (toasts.length > 0) {
        let toastCounter = 0;
        let toastInterval = setInterval(() => {
            dismissToast(toastCounter);

            if (toastCounter === toasts.length - 1) {
                // stop toast dismisser when reach last toast
                clearInterval(toastInterval);
            } else {
                toastCounter++;
            }
        }, 3000);
        console.log('ada');        
    }

    const dismissToast = index => {
        toasts[index].remove();
    }
    
</script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
@yield('javascript')

</body>
</html>