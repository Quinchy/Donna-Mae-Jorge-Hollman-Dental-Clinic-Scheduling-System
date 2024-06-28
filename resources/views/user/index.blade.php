@extends('user.layouts.main')
@section('content')
<div class="main-container">
    <div class="intro-container">
        <h1 class="intro-title">Where <span class="intro-title-highlight">Beautiful Smiles</span> Begin.</h1>
        <p class="intro-subtitle">Gentle, compassionate care | Advanced technology | Convenient scheduling.</p>
        <div class="intro-button-container">
            <a class="book-appointment-container" href="{{ route('book-appointment')}}">BOOK AN APPOINTMENT</a>
            <div class="learn-more-container">
                <a class="learn-more-link" href="#about-section">Learn More</a>
                <img src="{{ asset('img/Arrow-Down.svg') }}" alt="">
            </div>
        </div>
    </div>
    <div class="about-container" id="about-section">
        <div class="about-1-container">
            <h1 class="about-title">Welcome to Donna Mae Jorge-Hollman Dental Clinic, where your smile is our top priority.</h1>
            <img src="{{ asset('img/Line-Decoration.png')}}" alt="">
        </div>
        <div class="about-2-container">
            <img class="about-img" src="{{ asset('img/About-Image-Decoration.png')}}" alt="">
            <p class="about-2-subtitle">At Donna Mae Jorge-Hollman Dental Clinic, we are dedicated to providing personalized and gentle care. Our team of experienced professionals uses the latest technology to ensure the best dental health for you and your family. Experience a welcoming environment where every visit leaves you with a brighter smile.</p>
            <div class="about-link-container">
                <a class="about-link" href="{{ route('about') }}">LEARN MORE ABOUT US</a>
                <img src="{{ asset('img/Arrow-Right.svg')}}" alt="">
            </div>
        </div>
    </div>
    <div class="services-container">
        <h1 class="services-title">How to get our service?</h1>
        <div class="card-container">
            <div class="service-cards">
                <div class="service-cards-title-container">
                    <div class="card-number">1</div>
                    <h1 class="card-title">Book for an Appointment</h1>
                </div>
                <p class="service-card-subtitle">Schedule your appointment easily with our system. Simply select the date and time that suits you best. Then, choose the service you require.</p>
            </div>
            <div class="service-cards">
                <div class="service-cards-title-container">
                    <div class="card-number">2</div>
                    <h1 class="card-title">Get a<br class="linebreak"> Confirmation</h1>
                </div>
                <p class="service-card-subtitle">Once you've scheduled, wait for an appointment confirmation. After confirmation, you'll receive an email notification. This email will include your appointment ID.</p>
            </div>
            <div class="service-cards">
                <div class="service-cards-title-container">
                    <div class="card-number">3</div>
                    <h1 class="card-title">Consult your Dentist</h1>
                </div>
                <p class="service-card-subtitle">Please arrive at our clinic according to your scheduled time. Failure to attend as planned may result in the cancellation of your appointment.</p>
            </div>
        </div>
        <div class="services-link-container">
            <a class="services-link" href="{{ route('service') }}">KNOW OUR SERVICES</a>
            <img src="{{ asset('img/Arrow-Right.svg')}}" alt="">
        </div>
    </div>
    <div class="contact-container">
        <img class="service-img" src="{{ asset('img/Map-Location.png')}}" alt="">
        <div class="contact-section-container">
            <div class="contact-title-container">
                <h1 class="contact-title">Reach Out to Us</h1>
                <img src="{{ asset('img/Line-Decoration-2.png')}}" alt="">
            </div>
            <p class="contact-subtitle">Located in the Palihan Public Market in Hermosa, Bataan, our clinic offers personalized healthcare services to the local community. For inquiries, please call us at 0928 500 2066. Need further assistance? Our dedicated customer service team is just a click away.</p>
            <div class="contact-link-container">
                <a class="contact-link" href="{{ route('contact') }}">VIEW CUSTOMER SERVICE</a>
                <img src="{{ asset('img/Arrow-Right.svg')}}" alt="">
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
    <link href="{{ asset('css/user/home.css') }}" rel="stylesheet">
@endsection