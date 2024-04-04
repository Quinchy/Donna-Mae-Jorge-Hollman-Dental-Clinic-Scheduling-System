@extends('layouts.main')
@section('content')
<div class="main-container">
    <div class="service-title-section-container">
        <h1 class="service-title">SERVICES</h1>
        <div class="line"></div>
    </div>
    <div class="service-first-section-container">
        <h1 class="first-section-title">Comprehensive dental solutions tailored for everyone.</h1>
        <p class="first-section-subtitle">Routine dental checkups, cleanings, and examinations are vital for sustaining optimal oral hygiene. We provide an extensive selection of preventative dental care options. Here on our service page, find valuable insights about your initial appointment, including preparation and necessary items to bring.</p>
    </div>
    <div class="service-list-section-container" id="service-section">
        <hv class="service-list-title">Our Clinic Services</hv>
        <div class="services-cards-container">
            <div class="service-card">
                <img class="service-image" src="{{ asset('img/ServiceImage1.png')}}" alt="">
                <div class="service-cards-text-container">
                    <h1 class="service-card-title">Check-Up</h1>
                    <p class="service-card-description">A dental check-up typically begins with a diagnosis, where the dentist examines your teeth, gums, and mouth for signs of decay, gum disease, and other oral health issues. This is followed by a thorough cleaning to remove plaque and tartar build-up. The dentist may also offer advice on oral hygiene and discuss any necessary treatments or follow-up care.</p>
                </div>
            </div>
            <div class="service-card">
                <img class="service-image" src="{{ asset('img/ServiceImage2.png')}}" alt="">
                <div class="service-cards-text-container">
                    <h1 class="service-card-title">Dental Cleaning</h1>
                    <p class="service-card-description">A dental cleaning involves a professional removing plaque and tartar from your teeth, typically using specialized instruments. The process includes polishing the teeth to remove stains and smooth the enamel, and often concludes with flossing and a review of proper oral hygiene techniques.</p>
                </div>
            </div>
            <div class="service-card">
                <img class="service-image" src="{{ asset('img/ServiceImage3.png')}}" alt="">
                <div class="service-cards-text-container">
                    <h1 class="service-card-title">Dental Surgery</h1>
                    <p class="service-card-description">Dental surgery encompasses various procedures aimed at treating more complex oral health issues, such as tooth extractions, root canals, and implant placements. These surgeries often require local anesthesia and are performed by specialized dental professionals to restore or improve oral health and function.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
    <link href="{{ asset('css/service.css') }}" rel="stylesheet">
@endsection
@section('js')
    <script>
        var lastScrollTop = 0;
        document.addEventListener('scroll', function() {
            var line = document.querySelector('.line');
            var firstSection = document.querySelector('.service-first-section-container');
            var lineBottom = line.getBoundingClientRect().bottom;
            var firstSectionTop = firstSection.getBoundingClientRect().top;
            var currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
            var speedFactor = 2.2;
            var maxDistance = firstSectionTop - lineBottom;  
            var distanceToMove = Math.min((currentScrollTop - lastScrollTop) * speedFactor, maxDistance);
            if (distanceToMove > 0 && currentScrollTop > lastScrollTop) {
                line.style.transform = 'translateY(' + distanceToMove + 'px)';
            } else if (currentScrollTop < lastScrollTop) {
                line.style.transform = 'translateY(0px)';
            }
            lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
        });
    </script>
@endsection