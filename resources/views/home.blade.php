<x-guest-layout>

    <x-slide />
    <div class="bg-gray-200 px-8 py-10">
        <div class="container mx-auto">
            <h3 class="heading-3 text-center text-[#000000] mb-8">Why choose SendTins?</h3>
            <div class="flex text-center text-lg">
                <div class="w-1/3">
                    <img src="{{ asset('asset/img/icon-lock.png') }}" alt="Lock" class="inline-block mb-4">
                    <h4 class="font-bold text-xl">Tough</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum.</p>
                </div>
                <div class="w-1/3">
                    <img src="{{ asset('asset/img/icon-trust.png') }}" alt="Trust" class="inline-block mb-4">
                    <h4 class="font-bold text-xl">Trusted</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum.</p>
                </div>
                <div class="w-1/3">
                    <img src="{{ asset('asset/img/icon-transform.png') }}" alt="Transform" class="inline-block mb-4">
                    <h4 class="font-bold text-xl">Transformative</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum.</p>
                </div>
            </div>
        </div>
    </div>
    <x-faq />
    <x-newsletter />
</x-guest-layout>
