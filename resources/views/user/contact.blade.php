@extends('user.layouts.main')

@section('content')
<div class="main-container">
    <h1 class="contact-title">CONTACT US</h1>
    <div class="contact-container">
        <div class="contact-form-container">
            <div class="contact-heading-container">
                <h1 class="contact-form-title">Get in Touch With Us</h1>
                <p class="contact-form-subtitle">Fill up the form and let us know how we can help.</p>
            </div>
            <div class="contact-information-container">
                <div class="contact-item-container">
                    <img class="contact-icon" src="{{ asset('img/Phone_fill.svg')}}" alt="">
                    <p class="contact-content">0928 500 2066</p>
                </div>
                <div class="contact-item-container">
                    <img class="contact-icon" src="{{ asset('img/Pin_fill.svg')}}" alt="">
                    <p class="contact-content">Palihan Public Market, Hermosa, Bataan</p>
                </div>
                <div class="contact-item-container">
                    <img class="contact-icon" src="{{ asset('img/Message_alt_fill.svg')}}" alt="">
                    <p class="contact-content">dmjorgehollman.dentalclinic@gmail.com</p>
                </div>
            </div>            
            <form class="contact-form" action="{{ route('send.contact.mail') }}" method="POST">
                @csrf
                <div class="contact-input-container1">
                    <input placeholder="Your Name" class="contact-input" type="text" name="name" id="name">
                    <input placeholder="Email" class="contact-input" type="email" name="email" id="email">
                </div>
                <input placeholder="Subject" class="contact-input2" type="subject" name="subject" id="subject">
                <textarea placeholder="Message" class="contact-textarea" name="message" id="message" cols="30" rows="10"></textarea>
                <button class="send-button">Send</button>
            </form>
        </div>
        <img class="contact-map-image" src="{{ asset('img/contact-map.webp')}}" alt="">
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('css/user/contact.css') }}" rel="stylesheet">
@endsection