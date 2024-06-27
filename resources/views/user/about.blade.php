@extends('user.layouts.main')
@section('content')
<div class="main-container">
    <div class="about-title-section-container">
        <h1 class="about-title">ABOUT US</h1>
        <div class="line"></div>
    </div>
    <div class="about-first-section-container">
        <h1 class="first-section-title">Set aside your concerns upon entering and embrace a more accurate and healthier smile.</h1>
        <p class="first-section-subtitle">We exclusively select top-tier materials available in the market, ensuring our products meet the highest standards. Our commitment is to offer our patients nothing but the best. Rest assured, you're in good hands with us. Therefore, feel free to book an appointment without any concerns.</p>
        <a class="book-appointment-link" href="{{ route('book-appointment')}}">BOOK AN APPOINTMENT</a>
    </div>
    <div class="about-second-section-container">
        <img class="about-teeth-image" src="{{ asset('img/AboutTeethDecor.png')}}" alt="">
        <h1 class="second-section-title">Expert care gained through experience.</h1>
        <p class="second-section-subtitle">At our clinic, years of experience have refined our specialized care, guaranteeing expert focus on each smile for peak dental health. This depth of knowledge ensures every patient receives the utmost attention. We are committed to maintaining and enhancing the health and beauty of every smile that comes through our doors.</p>
    </div>
    <div class="about-card-section-container">
        <div class="card-container">
            <div class="about-card">
                <img src="{{ asset('img/Shield Done.svg')}}" alt="">
                <h1 class="about-card-title">Prioritizing safety above all.</h1>
                <p class="about-card-subtitle">We place utmost importance on safety by conducting thorough health checks and implementing additional safety measures.</p>
            </div>
            <div class="about-card">
                <img src="{{ asset('img/Teeth.svg')}}" alt="">
                <h1 class="about-card-title">Always free from judgment.</h1>
                <p class="about-card-subtitle">From meticulous flossers to those with a sweet tooth, we welcome every type of mouth with equal care and warmth.</p>
            </div>
            <div class="about-card">
                <img src="{{ asset('img/DentalChair.svg')}}" alt="">
                <h1 class="about-card-title">Comprehensive dental services</h1>
                <p class="about-card-subtitle">Our clinic delivers an extensive array of dental services, including regular check-ups, cleanings, and surgical procedures.</p>
            </div>
        </div>
        <div class="view-service-container">
            <a class="view-service-link" href="{{ route('service')}}">VIEW SERVICES</a>
            <img class="draw-line" src="{{ asset('img/LineDraw.svg')}}" alt="">
        </div>
    </div>
</div>
@endsection
@section('css')
    <link href="{{ asset('css/user/about.css') }}" rel="stylesheet">
@endsection
@section('js')
    <script>
        var lastScrollTop = 0;
        document.addEventListener('scroll', function() {
            var line = document.querySelector('.line');
            var firstSection = document.querySelector('.about-first-section-container');
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