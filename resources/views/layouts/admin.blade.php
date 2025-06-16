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
    
<div class="fixed top-0 left-0 right-0 h-16 border-b bg-white flex items-center justify-center gap-4 px-10 mobile:px-6 z-10">
    <div class="flex grow justify-start mobile:hidden">
        <a href="{{ route('admin.index') }}">
            <h1 class="text-lg text-slate-700 font-medium">@yield('title')</h1>
        </a>
    </div>
    <form action="#" class="w-4/12 mobile:w-8/12 bg-slate-100 h-12 rounded-lg flex items-center gap-4 px-6" onsubmit="headerSearch(event)">
        <input type="text" name="q" id="q" class="w-full h-12 outline-0 text-sm text-slate-700 bg-transparent" value="{{ $request->q }}" placeholder="Cari...">
        <button>
            <ion-icon name="search-outline"></ion-icon>
        </button>
    </form>
    <div class="flex items-center grow justify-end gap-4">
        <div class="text-sm text-slate-700 mobile:hidden">Hai, {{ $admin->name }}!</div>
        <a href="{{ route('admin.logout') }}" class="bg-red-500 text-white text-sm font-medium p-2 px-5 rounded-full">
            Logout
        </a>
    </div>
</div>

<div class="absolute top-16 left-0 right-0 p-10 mobile:p-6">
    @yield('content')
</div>

<div class="fixed top-20 mobile:top-4 right-10 mobile:right-6 z-10">
    @yield('toast')
</div>

@yield('outer')

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
    }

    const dismissToast = index => {
        toasts[index].remove();
    }

    const queryParam = (key, value) => {
        const url = new URL(window.location.href);

        if (value === null || value === '') {
            url.searchParams.delete(key);
        } else {
            url.searchParams.set(key, value);
        }

        window.location.href = url.toString();
    }


	const onChangeImage = (input, target) => {
		let file = input.files[0];
		let reader = new FileReader();
		let imagePreview = select(target);
		
		reader.onload = function () {
			let source = reader.result;
			imagePreview.style.backgroundImage = `url(${source})`;
			imagePreview.style.backgroundSize = "cover";
			imagePreview.style.backgroundPosition = "center center";

			Array.from(imagePreview.childNodes).forEach(ch => {
				if (ch.tagName !== "INPUT") ch.remove();
			});
		};

		reader.readAsDataURL(file);
	};

	const Currency = amount => ({
		encode: (prefix = 'Rp') => {
			let amountRev = amount.toString().split('').reverse().join('');
			let result = '';
			for (let i = 0; i < amountRev.length; i += 3) {
				result += amountRev.substr(i, 3) + '.';
			}
			return prefix + ' ' + result.split('', result.length - 1).reverse().join('');
		},
		decode: () => parseInt(amount.replace(/,.*|[^0-9]/g, ''), 10)
	});

    const headerSearch = e => {
        let q = select("input#q").value;
        queryParam("q", q);
        e.preventDefault();
    }
</script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
@yield('javascript')

</body>
</html>