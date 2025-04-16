<div>
    <div class="swiper slide">
        <div class="swiper-wrapper">
            <div class="swiper-slide relative">
                <img src="{{ asset('asset/img/slide.jpg') }}" alt="Slide" class="w-full">
                <div class="absolute w-full h-full top-0 ">
                    <div class="container h-full mx-auto">
                        <div class="flex h-full items-center">
                            <div class="w-1/2 slide-content">
                                <h3 class="slide-title">{{ config('app.name') }} - Smart Delivery, Powered by Travelers</h3>
                                <p>A peer-to-peer delivery network connecting trusted travelers with people who need parcels delivered across cities or countries.</p>
                                <div class="flex gap-4">
                                    <p><a class="btn-primary" href="{{ route('trip.search') }}">Send a Parcel</a></p>
                                    <p><a class="btn-secondary" href="{{ route('register') }}">Become a Traveller</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-button-prev slide-prev"></div>
        <div class="swiper-button-next slide-next"></div>
    </div>
</div>
