<x-guest-layout>
    <div class="page-header bg-primary py-5">
        <div class="container">
            <h1 class="font-bold text-3xl text-white">About Us</h1>
        </div>
    </div>

    <div class="container py-10 page-content">
        <div class="mb-10">
            <div class="flex flex-col mb-5 sm:flex-row items-center">
                <div class="w-full sm:w-1/2 sm:px-10">
                    <h3 class="heading-4 mb-2">Who We Are</h3>
                    <p>SendTins is a peer-to-peer delivery platform built on a simple idea: make parcel delivery smarter, more affordable, and more human. We connect individuals who need to send packages with trusted travelers already heading to their destination. Whether it’s a short road trip or an international flight, SendTins unlocks unused space in motion to move parcels quickly and efficiently.</p>
                    <p>We are more than just a delivery service — we are a community powered by real people, helping each other across borders and beyond the limits of traditional shipping.</p>
                </div>
                <div class="w-full sm:w-1/2">
                    <img class="w-full" src="{{ asset('asset/img/who-we-are.jpg') }}" alt="Who We Are">
                </div>
            </div>
            <div class="flex flex-col mb-5 sm:flex-row items-center">
                <div class="w-full sm:w-1/2 sm:order-2 sm:px-10">
                    <h3 class="heading-4 mb-2">Our Mission</h3>
                    <p>Our mission is to revolutionise the way parcels move around the world by tapping into existing journeys. We believe in turning everyday travel into an opportunity — for senders to find fast, flexible delivery options, and for travelers to earn money simply by sharing space in their luggage.</p>
                </div>
                <div class="w-full sm:w-1/2 sm:order-1">
                    <img class="w-full" src="{{ asset('asset/img/mission.jpg') }}" alt="Our Mission">
                </div>
            </div>
        </div>
    </div>

    <div class="text-white bg-black mb-10 py-16 bg-no-repeat bg-cover bg-fixed" style="background-image: url({{ asset('asset/img/drives-us.jpg') }})">
        <div class="container">
            <h3 class="heading-4 mb-2">What Drives Us</h3>
            <p>We are driven by a vision of more connected, efficient logistics. We believe delivery should be:</p>
            <ul class="list">
                <li>Faster – by cutting through traditional courier delays.</li>
                <li>Fairer – by offering affordable rates for senders and real earnings for travelers.</li>
                <li>Friendlier to the Planet – by making better use of existing travel.</li>
                <li>Every trip is an opportunity. Every delivery is a connection.</li>
            </ul>
        </div>
    </div>

    <div class="container mb-10">
        <div class="flex gap-10">
            <div class="w-full sm:w-1/2 shadow-lg border p-5 rounded-lg">
                <h3 class="heading-4 mb-4">How We Work</h3>
                <p>SendTins operates through a seamless, secure platform where senders can post delivery needs and travelers can list upcoming trips. Once a match is made, both parties can communicate, agree on terms, and confirm the booking. Our system ensures accountability through user verification, secure payments, and ratings for every completed delivery.</p>
            </div>
            <div class="w-full sm:w-1/2 shadow-lg border p-5 rounded-lg">
                <h3 class="heading-4 mb-4">The People Behind SendTins</h3>
                <p>We are a team of engineers, travelers, and logistics thinkers who saw a smarter way to deliver. Our backgrounds span tech, operations, and product design — but what unites us is a shared commitment to creating a platform that empowers people to help each other.</p>
                <p>We are based across multiple cities, just like the parcels we help deliver. And we are constantly growing, learning, and evolving with our community.</p>
            </div>
        </div>
    </div>

</x-guest-layout>
