<!DOCTYPE html>
<html lang="en" class="h-screen">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Card Pilot - Welcome</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @routes
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-r from-slate-800 via-slate-700 to-slate-800 h-full p-12 text-white" x-data="welcome({ csrfToken: '{{ csrf_token() }}' })">
        {{ $main_wrapper }}

        <x-modal-wrapper var="showContactModal" title="Contact Me">
            <x-slot name="content">
                <div class="p-6 text-center text-white flex flex-col gap-2 sm:w-2/3 mx-auto">
                    <h2 class="text-lg font-semibold mb-4">Please get in touch!</h2>
                    <p>Use the form below to send me a message.</p>
                    <div class="flex flex-col">
                        <label class="font-semibold text-xs text-left">Email</label>
                        <input type="email" placeholder="Enter your email" class="rounded p-1 text-slate-800 font-semibold" x-model="contact.email" />
                    </div>
                    <div class="flex flex-col">
                        <label class="font-semibold text-xs text-left">Reason for the message</label>
                        <select class="rounded px-1 py-2 text-slate-800 font-semibold" x-model="contact.reason">
                            <option value="FEEDBACK">Feedback</option>
                            <option value="ACCOUNT">Account Issues</option>
                            <option value="OTHER">Other</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label class="font-semibold text-xs text-left">Please write your message here</label>
                        <textarea rows="4" placeholder="Include as much detail as possible" class="rounded p-1 text-slate-800 font-semibold" x-model="contact.message"></textarea>
                    </div>
                    <button x-show="!login.showSuccess" class="bg-indigo-300 text-slate-800 font-semibold w-[105px] rounded text-xs py-1 mx-auto hover:bg-indigo-400" @click="signInBtnClicked">Submit</button>    
                    <x-svg.spinner var="login.showSuccess" />
                </div>
            </x-slot>
        </x-modal-wrapper>

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
                    <p x-cloak x-show="login.errorMessage" class="text-red-500 font-semibold" x-text="login.errorMessage"></p>
                    <button x-show="!login.showSuccess" class="bg-indigo-300 text-slate-800 font-semibold w-[105px] rounded text-xs py-1 mx-auto hover:bg-indigo-400" @click="signInBtnClicked">Sign In</button>    
                    <x-svg.spinner var="login.showSuccess" />
                    <small class="mt-4">Dont have an account? <span class="underline underline-offset-2 font-semibold cursor-pointer" @click="showAccountModal = false; showCreateAccountModal = true">Create account</span></small>
                </div>
            </x-slot>
        </x-modal-wrapper>

        <x-modal-wrapper var="showCreateAccountModal" title="Create Account">
            <x-slot name="content">
                <div x-show="!create.showRedirect" class="p-6 text-center text-white flex flex-col gap-2 sm:w-2/3 mx-auto">
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
                    <p x-cloak x-show="create.errorMessage" class="text-red-500 font-semibold" x-text="create.errorMessage"></p>
                    <button x-show="!create.showSuccess" class="bg-indigo-300 text-slate-800 font-semibold w-[105px] rounded text-xs py-1 mx-auto hover:bg-indigo-400" @click="createAccountBtnClicked">Sign In</button>    
                    <x-svg.spinner var="create.showSuccess" />
                    <small class="mt-4">Already have an account? <span class="underline underline-offset-2 font-semibold cursor-pointer" @click="showCreateAccountModal = false; showAccountModal = true">Return to Sign in</span></small>
                </div>
                <div x-cloak x-show="create.showRedirect" class="p-6 text-center text-white flex flex-col gap-4 sm:w-2/3 mx-auto">
                    <h2 class="text-lg font-semibold mb-4">Registration Successfull</h2>
                    <p>You will now be redirected to the dashboard.</p>
                    <x-svg.tick-circle class="w-10 h-10 mx-auto animate-bounce" stroke="white" fill="green" />
                    <p>If you are not redirected within 5 seconds, please click the link below instead.</p>
                    <a href="/" class="font-semibold underline underline-offset-2">Take me to the Dashboard</a>
                </div>
            </x-slot>
        </x-modal-wrapper>

        <script>
            const welcome = (e) => ({
                showAccountModal: false,
                showContactModal: false,
                showCreateAccountModal: false,
                login: {
                    email: '',
                    password: '',
                    remember: false,
                    showSuccess: false,
                    errorMessage: '',
                },
                create: {
                    name: '',
                    surname: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    showSuccess: false,
                    errorMessage: '',
                    showRedirect: false
                },
                contact: {
                    email: '',
                    reason: 'FEEDBACK',
                    message: ''
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
                    this.login.errorMessage = '';
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
                        this.login.showSuccess = false;
                        this.login.errorMessage = json.message;
                        return;
                    }
                    await new Promise((res) => setTimeout(() => res(), 750))
                    this.login.showSuccess = false;
                    location.reload()
                    
                },
                async createAccountBtnClicked() {
                    this.create.errorMessage = ''
                    this.create.showSuccess = true;
                    const response = await fetch(route('post.create_account'), {
                        method: 'post',
                        body: JSON.stringify({
                            email: this.create.email,
                            password: this.create.password,
                            password_confirmation: this.create.password_confirmation,
                            name: this.create.name,
                            surname: this.create.surname
                        }),
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        }
                    })
                    const json = await response.json();
                    if (response.status != 201) {
                        this.create.showSuccess = false;
                        this.create.errorMessage = json.message;
                        return;
                    }
                    this.create.showSuccess = false;
                    this.create.showRedirect = true;
                    await new Promise((res) => setTimeout(() => res(), 5000))
                    location.reload();
                },
                ...e
            })
        </script>
    </body>
</html>