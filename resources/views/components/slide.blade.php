<div>
    <div class="swiper slide">
        <div class="swiper-wrapper">
            <div class="swiper-slide relative">
                <img src="{{ asset('asset/img/slide.jpg') }}" alt="Slide" class="hidden md:block w-full">
                <div class="block md:hidden h-[500px] bg-cover" style="background-image: url({{ asset('asset/img/slide.jpg') }})"></div>
                <div class="absolute w-full h-full top-0 ">
                    <div class="container h-full mx-auto">
                        <div class="flex h-full items-center">
                            <div class="w-full xl:w-1/2 slide-content p-5 md:p-0">
                                <h3 class="slide-title">{{ config('app.name') }} - Smart Delivery, Powered by Travelers</h3>
                                <p>A peer-to-peer delivery network connecting trusted travelers with people who need parcels delivered across cities or countries.</p>
                                <div class="flex flex-col md:flex-row gap-4">
                                    <p><a class="w-full text-center sm:w-auto btn-primary" href="{{ route('register') }}">Become a Traveller</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide relative">
                <img src="{{ asset('asset/img/slide2.jpg') }}" alt="Slide" class="hidden md:block w-full">
                <div class="block md:hidden h-[500px] bg-cover" style="background-image: url({{ asset('asset/img/slide2.jpg') }})"></div>
                <div class="absolute w-full h-full top-0 ">
                    <div class="container h-full mx-auto">
                        <div class="flex h-full items-center">
                            <div class="w-full xl:w-1/2 slide-content p-5 md:p-0">
                                <h3 class="slide-title">Find a Traveller Heading Your way</h3>
                                <p><a class="w-full text-center sm:w-auto btn-primary" href="{{ route('register') }}">Become a Traveller</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide relative">
                <img src="{{ asset('asset/img/slide3.jpg') }}" alt="Slide" class="hidden md:block w-full">
                <div class="block md:hidden h-[500px] bg-cover" style="background-image: url({{ asset('asset/img/slide3.jpg') }})"></div>
                <div class="absolute w-full h-full top-0 ">
                    <div class="container h-full mx-auto">
                        <div class="flex h-full items-center">
                            <div class="w-full xl:w-1/2 slide-content p-5 md:p-0">
                                <h3 class="slide-title">Match and Connect</h3>
                                <p><a class="w-full text-center sm:w-auto btn-primary" href="{{ route('register') }}">Become a Traveller</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide relative">
                <img src="{{ asset('asset/img/slide4.jpg') }}" alt="Slide" class="hidden md:block w-full">
                <div class="block md:hidden h-[500px] bg-cover" style="background-image: url({{ asset('asset/img/slide4.jpg') }})"></div>
                <div class="absolute w-full h-full top-0 ">
                    <div class="container h-full mx-auto">
                        <div class="flex h-full items-center">
                            <div class="w-full xl:w-1/2 slide-content p-5 md:p-0">
                                <h3 class="slide-title">Wouldn't you rather contribute to a pristine earth?</h3>
                                <p><a class="w-full text-center sm:w-auto btn-primary" href="{{ route('register') }}">Become a Traveller</a></p>
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
