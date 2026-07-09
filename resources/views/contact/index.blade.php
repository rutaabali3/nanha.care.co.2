@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/contact.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-5 bg-gradient-hero text-on-gradient">
    <div class="container text-center">
        <h1 class="display-4 fw-bold text-on-gradient">Contact Us</h1>
        <p class="lead mb-0 text-on-gradient">We'd love to hear from you. Get in touch with our team.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4 text-navy">Send us a Message</h4>
                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-send"></i> Send Message</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4 text-navy">Contact Information</h4>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-sky-blue text-on-gradient" style="width: 45px; height: 45px;">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Email</h6>
                                <a href="mailto:support@nanhacare.com" class="text-decoration-none text-dark">support@nanhacare.com</a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-coral text-on-gradient" style="width: 45px; height: 45px;">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Phone</h6>
                                <a href="tel:+921234567890" class="text-decoration-none text-dark">+92 123 4567890</a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-mint-green text-on-gradient" style="width: 45px; height: 45px;">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Address</h6>
                                <p class="mb-0 text-dark">Lahore, Pakistan</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: var(--sunshine-yellow); color: var(--white);">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Working Hours</h6>
                                <p class="mb-0 text-dark">Mon-Fri 9AM - 6PM</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6 class="fw-semibold mb-3">Follow Us</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-outline-primary rounded-circle"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-danger rounded-circle"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-outline-dark rounded-circle"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="btn btn-outline-success rounded-circle"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h4 class="fw-bold mb-4 text-center text-navy">Frequently Asked Questions</h4>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        What is NanhaCare?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        NanhaCare is Pakistan's trusted platform for baby products, childcare resources, and expert parenting advice from top pediatricians.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        How do I place an order?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Browse our marketplace, add products to your cart, proceed to checkout, and place your order with cash on delivery or online payment.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        Do you offer returns?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes, we offer a 7-day return policy on most items. Please contact our support team to initiate a return.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                        How can I contribute as a doctor?
                    </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Registered pediatricians can apply to write for our blog. Contact us at support@nanhacare.com for more information.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
