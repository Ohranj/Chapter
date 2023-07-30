<x-layouts.auth>
    <x-slot name="main_wrapper">
        <div class="flex flex-col h-full gap-8">
            <x-navbarTop></x-navbarTop>
            <div class="flex grow gap-8 sm:w-5/6 mx-auto">
                <x-navbarSide />
                <div class="grow py-4" x-data="community">
                    <h1 class="text-xl text-amber-500 font-semibold">There's a world out there</h1>
                    <small>Use this space to explore our ever-growing community. Network with like-minded readers and expand your interests.</small>
                    <div class="flex flex-col gap-4 mt-12">
                        Bobs
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-layouts.auth>


<script>
    const community = () => ({
        init() {
            console.log(2)
        }
    })
</script>