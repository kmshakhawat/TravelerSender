<x-guest-layout>

    <x-slide />

    <div class="-mt-14 relative z-10">
        <div class="container mx-auto">
            <div class="bg-white shadow rounded">
                <div class="container py-6">
                    <x-search-form />
                </div>
            </div>
        </div>
    </div>
    <div class="container py-16">
        <div class="text-center mb-10 max-w-7xl mx-auto">
{{--            <h1 class="heading-3 mb-4">Welcome to {{ config('app.name') }}</h1>--}}
            <p>SendTins is a peer-to-peer delivery network connecting travelers with senders who need parcels delivered across cities or countries. Whether you are flying from Paris to Rome or taking a train from NYC to Boston or even a road trip from Abuja to Ibadan, you can carry small packages for others and earn some cash - securely, reliably, and efficiently. </p>
        </div>
        <div class="text-center max-w-7xl mx-auto">
            <h2 class="heading-3 mb-5">How It Works</h2>
            <div class="flex flex-col sm:flex-row gap-5 lg:gap-10">
                <div class="w-full sm:w-1/3 shadow-lg rounded-lg p-5 border">
                    <div class="text-6xl text-primary font-bold mb-4">1.</div>
                    <h3 class="text-2xl font-bold">Post or Search a Trip</h3>
                    <p>Travelers list their upcoming trips and available luggage space. Senders browse or search for travelers heading to their parcel’s destination.</p>
                </div>
                <div class="w-full sm:w-1/3 shadow-lg rounded-lg p-5 border">
                    <div class="text-6xl text-primary font-bold mb-4">2.</div>
                    <h3 class="text-2xl font-bold">Match and Connect</h3>
                    <p> Once a match is found, both parties can chat, agree on delivery terms, and confirm the booking.</p>
                </div>
                <div class="w-full sm:w-1/3 shadow-lg rounded-lg p-5 border">
                    <div class="text-6xl text-primary font-bold mb-4">3.</div>
                    <h3 class="text-2xl font-bold">Deliver and Earn</h3>
                    <p>Travelers carry parcels during their trips. Once delivered, the sender confirms receipt and payment is released.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-primary text-white px-8 py-16">
        <div class="container mx-auto">
            <h3 class="heading-3 text-center mb-8">Why choose SendTins?</h3>
            <div class="flex flex-col sm:flex-row text-center text-base gap-5">
                <div class="w-full sm:w-1/3 mb-4">
                    <img src="{{ asset('asset/img/icon-lock.png') }}" alt="Lock" class="inline-block mb-4">
                    <h4 class="font-bold text-xl mb-3">Crowdsources Convenience</h4>
                    <p>No more waiting for expensive couriers. Find a traveller heading your way.</p>
                </div>
                <div class="w-full sm:w-1/3 mb-4">
                    <img src="{{ asset('asset/img/icon-trust.png') }}" alt="Trust" class="inline-block mb-4">
                    <h4 class="font-bold text-xl mb-3">Secure and Trustworthy</h4>
                    <p>Each user is verified. Ratings and reviews ensure reliability and transparency.</p>
                </div>
                <div class="w-full sm:w-1/3 mb-4">
                    <img src="{{ asset('asset/img/icon-transform.png') }}" alt="Transform" class="inline-block mb-4">
                    <h4 class="font-bold text-xl mb-3">Eco-Friendly Logistics</h4>
                    <p>Reduce wasteful shipping by using space that’s already moving.</p>
                </div>
            </div>
        </div>
    </div>

    <x-testimonials />

    <div class="bg-gray-200 py-16 bg-no-repeat bg-cover bg-fixed" style="background-image: url({{ asset('asset/img/trust.jpg') }})">
        <div class="container">
            <h2 class="heading-3 mb-8 text-white text-center">Security & Trust</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-white">
                <div>
                    <div class="p-5 border rounded-lg h-full">
                        <h3 class="text-2xl mb-3 font-bold">Verified User IDs</h3>
                        <p>Every user is required to verify their identity, creating a trusted community and enhancing safety for both senders and travelers.</p>
                    </div>
                </div>
                <div>
                    <div class="p-5 border rounded-lg h-full">
                        <h3 class="text-2xl mb-3 font-bold">Real-Time Messaging</h3>
                        <p>Communicate instantly with other users through built-in real-time chat, making coordination smooth and hassle-free.</p>
                    </div>
                </div>
                <div>
                    <div class="p-5 border rounded-lg h-full">
                        <h3 class="text-2xl mb-3 font-bold">Secure Escrow Payments</h3>
                        <p>Our integrated payment system holds funds in escrow until the parcel is successfully delivered, ensuring protection for all parties.</p>
                    </div>
                </div>
                <div>
                    <div class="p-5 border rounded-lg h-full">
                        <h3 class="text-2xl mb-3 font-bold">Delivery Confirmation</h3>
                        <p>Senders receive confirmation upon successful delivery, ensuring transparency and peace of mind.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-newsletter />


</x-guest-layout>
