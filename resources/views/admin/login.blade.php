@extends('layouts.auth')

@section('title', "Login")

@section('content')
<form action="#" method="POST" class="w-4/12 mobile:w-10/12 flex flex-col gap-4">
    <h1 class="text-3xl text-slate-700 font-bold mobile:font-medium mb-4">Sign in.</h1>
    @csrf
    <div class="group border border-slate-300 focus-within:border-blue-500 rounded-lg p-1 relative px-3">
        <label class="text-slate-500 group-focus-within:text-blue-500 text-xs absolute top-2 left-3">Username</label>
        <input
            type="text"
            name="username"
            id="username"
            class="w-full outline-none h-12 text-sm bg-transparent mt-3"
            required
        />
    </div>
    <div class="group border border-slate-300 focus-within:border-blue-500 rounded-lg p-1 relative px-3 flex items-center gap-4">
        <label class="text-slate-500 group-focus-within:text-blue-500 text-xs absolute top-2 left-3">Password</label>
        <input
            type="password"
            name="password"
            id="password"
            class="w-full outline-none h-12 text-sm bg-transparent mt-3"
            required
        />
        <ion-icon name="eye-outline" class="text-xl cursor-pointer" onclick="togglePasswordVisibility(this)">ed</ion-icon>
    </div>

    @if ($message != "")
        <div class="toast bg-green-100 text-green-500 p-3 rounded-lg text-xs flex items-center gap-4" onclick="dismissToast(0)">
            <div class="flex grow">{{ $message }}</div>
            <div class="bg-green-500 text-white flex items-center justify-center aspect-square h-6 rounded-full cursor-pointer">
                <ion-icon name="close-outline" class="text-lg"></ion-icon>
            </div>
        </div>
    @endif
    @if ($errors->count() > 0)
        @foreach ($errors->all() as $e => $err)
            <div class="toast bg-red-100 text-red-500 p-3 rounded-lg text-xs flex items-center gap-4" onclick="dismissToast({{ $e }})">
                <div class="flex grow">{{ $err }}</div>
                <div class="bg-red-500 text-white flex items-center justify-center aspect-square h-6 rounded-full cursor-pointer">
                    <ion-icon name="close-outline" class="text-lg"></ion-icon>
                </div>
            </div>
        @endforeach
    @endif

    <button class="w-full h-14 mt-6 rounded-lg bg-primary text-white text-sm font-medium">
        Login
    </button>
</form>
@endsection

@section('javascript')
<script>
    const togglePasswordVisibility = btn => {
        let passwordInput = select("input#password");
        let isHidden = passwordInput.getAttribute('type') === "password";
        if (isHidden) {
            passwordInput.setAttribute('type', "text");
            btn.setAttribute("name", "eye-off-outline");
        } else {
            passwordInput.setAttribute('type', "password");
            btn.setAttribute("name", "eye-outline");
        }
        passwordInput.focus();
    }
</script>
@endsection