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
                        <small class="underline underline-offset-2 font-semibold cursor-pointer">Forgot password</small>
                    </div>
                    <button x-show="!login.showSuccess" class="bg-indigo-300 text-slate-800 font-semibold w-[105px] rounded text-xs py-1 mx-auto hover:bg-indigo-400" @click="signInBtnClicked">Sign In</button>    
                    <x-svg.spinner var="login.showSuccess" />
                    <small class="mt-4">Dont have an account? <span class="underline underline-offset-2 font-semibold cursor-pointer" @click="showAccountModal = false; showCreateAccountModal = true">Create account</span></small>
                </div>
            </x-slot>
        </x-modal-wrapper>

        <x-modal-wrapper var="showCreateAccountModal" title="Create Account">
            <x-slot name="content">
                <div class="p-6 text-center text-white flex flex-col gap-2 sm:w-2/3 mx-auto">
                    <h2 class="text-lg font-semibold mb-4">Create your Account</h2>
                    <p>Get started in seconds using the form below.</p>
                    <div class="flex gap-2">
                        <div class="flex flex-col grow">
                            <label class="font-semibold text-xs text-left">Name</label>
                            <input type="email" placeholder="Enter your forename" class="rounded p-1 text-slate-800 font-semibold w-full" x-model="create.name" />
                        </div>
                        <div class="flex flex-col grow">
                            <label class="font-semibold text-xs text-left">Surname</label>
                            <input type="email" placeholder="Enter your surname" class="rounded p-1 text-slate-800 font-semibold w-full" x-model="create.surname" />
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label class="font-semibold text-xs text-left">Email</label>
                        <input type="email" placeholder="Enter your email" class="rounded p-1 text-slate-800 font-semibold" x-model="create.email" />
                    </div>
                    <div class="flex flex-col">
                        <label class="font-semibold text-xs text-left">Password</label>
                        <input type="password" placeholder="Enter your password" class="rounded p-1 text-slate-800 font-semibold" x-model="create.password" />
                    </div>
                    <div class="flex flex-col">
                        <label class="font-semibold text-xs text-left">Confirm your Password</label>
                        <input type="password" placeholder="Confirm your password" class="rounded p-1 text-slate-800 font-semibold" x-model="create.password_confirmation" />
                    </div>
                    <button x-show="!create.showSuccess" class="bg-indigo-300 text-slate-800 font-semibold w-[105px] rounded text-xs py-1 mx-auto hover:bg-indigo-400" @click="createAccountBtnClicked">Sign In</button>    
                    <x-svg.spinner var="create.showSuccess" />
                    <small class="mt-4">Already have an account? <span class="underline underline-offset-2 font-semibold cursor-pointer" @click="showCreateAccountModal = false; showAccountModal = true">Return to Sign in</span></small>
                </div>
            </x-slot>
        </x-modal-wrapper>

        <script>
            const welcome = (e) => ({
                showAccountModal: false,
                showCreateAccountModal: false,
                toggle: true,
                login: {
                    email: '',
                    password: '',
                    remember: false,
                    showError: false,
                    showSuccess: false,
                    clientMessage: '',
                },
                create: {
                    name: '',
                    surname: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    showError: false,
                    showSuccess: false,
                },
                init() {
                    this.$watch('showAccountModal', (state) => {
                        if (state) return;
                        this.login.email = ''
                        this.login.password = ''
                        this.login.showError = false;
                        this.login.showSuccess = false;
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
                    if (response.status != 200) {
                        return;
                    }
                    await new Promise((res) => setTimeout(() => res(), 1500))
                    this.login.showSuccess = false;
                },
                async createAccountBtnClicked() {
                    this.create.showSuccess = true;
                    const response = await fetch(route('post.create_account'), {
                        method: 'post',
                        body: JSON.stringify({
                            email: this.create.email,
                            password: this.create.password,
                            password_confirmation: this.create.password_confirmation,
                            name: this.create.name,
                            surname: this.create.sur
                        }),
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        }
                    })
                    if (response.status != 201) {
                        this.create.showSuccess = false;
                        return;
                    }
                    const json = await response.json();
                    await new Promise((res) => setTimeout(() => res(), 1500))
                    this.create.showSuccess = false;
                },
                ...e
            })
        </script>
    </body>
</html>