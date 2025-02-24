<div class="bg-cover py-20" style="background-image: url({{ asset('asset/img/newsletter-bg.jpg') }})">
    <div class="container mx-auto text-center text-white">
        <h2 class="heading-2 mb-5">Join our Newsletter</h2>
        <p>
            We talk about Africa, recruitment, talent, human resources, {{ config('app.name') }} news and tips for employers.
        </p>
        <div class="mx-auto w-96">
            <form x-ref="newsletterForm" class="mt-5" method="POST" @submit.prevent="submitNewsletter">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <input type="text" name="name" class="form-input" placeholder="Enter your name">
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-input" placeholder="Enter your email address">
                </div>
                <div class="mt-8">
                    <button class="btn-secondary">Subscribe Now</button>
                </div>
            </form>
        </div>
    </div>
</div>
