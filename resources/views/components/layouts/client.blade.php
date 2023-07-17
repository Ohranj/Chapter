<!DOCTYPE html>
<html lang="en" class="h-screen">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Card Pilot</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @routes
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-r from-[#E6E6E6] via-pink-100 to-[#E6E6E6] h-full p-12 text-slate-800" x-data="welcome({ csrfToken: '{{ csrf_token() }}' })">
        {{ $main_wrapper }}

        <x-modal-wrapper var="showAccountModal" title="My Account">
            <x-slot name="content">
                <div class="p-6 text-center text-white flex flex-col gap-2 sm:w-2/3 mx-auto">
                    <h2 class="text-lg font-semibold mb-4">Welcome Back</h2>
                    <p>Please enter your details to sign in.</p>
                    <div class="flex flex-col">
                        <label class="font-semibold text-xs text-left">Email</label>
                        <input type="email" placeholder="Enter your email" class="rounded p-1 text-slate-800 font-semibold" x-model="login.email" />
                    </div>
                    <div class="flex flex-col">
                        <label class="font-semibold text-xs text-left">Password</label>
                        <input type="password" placeholder="Enter your password" class="rounded p-1 text-slate-800 font-semibold" x-model="login.password" />
                    </div>
                   
                    <div class="flex justify-between items-center">
                        <small>
                            <input type="checkbox" class="w-4 h-4 cursor-pointer inline-block align-top" x-model="login.remember" />
                            Remember me
                        </small>
                        <small class="underline underline-offset-2 font-semibold">Forgot password</small>
                    </div>
                    <button x-show="!login.showSuccess" class="bg-indigo-300 text-slate-800 font-semibold w-[105px] rounded text-xs py-1 mx-auto" @click="signInBtnClicked">Sign In</button>    
                    <x-svg.spinner var="login.showSuccess" />
                    <small class="mt-4">Dont have an account? <span class="underline underline-offset-2 font-semibold">Create account</span></small>
                </div>
            </x-slot>
        </x-modal-wrapper>

        <script>
            const welcome = (e) => ({
                showAccountModal: false,
                toggle: true,
                login: {
                    email: '',
                    password: '',
                    remember: false,
                    showError: false,
                    showSuccess: false,
                    clientMessage: '',
                },
                init() {
                    this.$watch('showAccountModal', (state) => {
                        if (state) return;
                        this.login.email = ''
                        this.login.password = ''
                        this.error.show = false;
                        this.success.show = false;
                        this.login.remember = false;
                    })
                },
                async signInBtnClicked() {
                    this.login.showSuccess = true;
                    const response = await fetch(route('post.login'), {
                        method: 'post',
                        body: JSON.stringify({
                            email: this.login.email,
                            password: this.login.password,
                            remember: this.login.remember
                        }),
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        }
                    })
                    const json = await response.json();
                    console.log(json)
                },
                ...e
            })
        </script>
    </body>
</html>


