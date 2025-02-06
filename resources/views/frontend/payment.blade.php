@extends('frontend.layouts.app')
@section('title', 'Thanks For yor Order' . ' | Buntu Delice ')
@section('keywords','Quote')
@section('content')

    <!-- banner-text -->
    <div class="banner-text">
        <div class="container" style="text-align: center;">
            <h2>Thank You <br></h2>
        </div>
    </div>
    </div>
    <!-- //banner -->
    <!-- breadcrumb -->
    <div class="container">
        <ol class="breadcrumb m9l-crumbs">
            <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Thank You</li>
        </ol>
    </div>
    <!-- //breadcrumb -->
    <div class="wthree-menu">
        <div class="wrapper">
            <div class="container">
                <div class="row cart-head">
                    <div class="container">
                        <div class="row">
                            <p></p>
                        </div>
                        <div class="row">
                            <div style="display: table; margin: auto;">
                                <span class="step step_complete"> <a href="#" class="check-bc">Cart</a> <span class="step_line step_complete"> </span> <span class="step_line backline"> </span> </span>
                                <span class="step step_complete"> <a href="#" class="check-bc">Checkout</a> <span class="step_line step_complete"> </span> <span class="step_line  backline"> </span> </span>
                                <span class="step step_complete"><a href="#" class="check-bc">Thank you</a> <span class="step_line "> </span> <span class="step_line"> </span></span>
                            </div>
                        </div>
                        <div class="row" style="padding:5px;">
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="row cart-body">
                    <div class="container">
                        <section>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="panel panel-default credit-card-box">
                                            <div class="panel-heading display-table" >
                                                <div class="row display-tr" >
                                                    <h3 class="panel-title display-td" >Payment Details</h3>
                                                    <div class="display-td" >
                                                        <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body">

                                                @if (Session::has('success'))
                                                    <div class="alert alert-success text-center">
                                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                                        <p>{{ Session::get('success') }}</p>
                                                    </div>
                                                @endif

                                                <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"
                                                      data-cc-on-file="false"
                                                      data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                                      id="payment-form">
                                                    @csrf

                                                    <div class='form-row row'>
                                                        <div class='col-xs-12 form-group required'>
                                                            <label class='control-label'>Name on Card</label> <input
                                                                class='form-control' size='4' type='text'>
                                                        </div>
                                                    </div>

                                                    <div class='form-row row'>
                                                        <div class='col-xs-12 form-group card required'>
                                                            <label class='control-label'>Card Number</label> <input
                                                                autocomplete='off' class='form-control card-number' size='20'
                                                                type='text'>
                                                        </div>
                                                    </div>

                                                    <div class='form-row row'>
                                                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                                                            <label class='control-label'>CVC</label> <input autocomplete='off'
                                                                                                            class='form-control card-cvc' placeholder='ex. 311' size='4'
                                                                                                            type='text'>
                                                        </div>
                                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                            <label class='control-label'>Expiration Month</label> <input
                                                                class='form-control card-expiry-month' placeholder='MM' size='2'
                                                                type='text'>
                                                        </div>
                                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                            <label class='control-label'>Expiration Year</label> <input
                                                                class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                                                type='text'>
                                                        </div>
                                                    </div>

                                                    <div class='form-row row'>
                                                        <div class='col-md-12 error form-group hide'>
                                                            <div class='alert-danger alert'>Please correct the errors and try
                                                                again.</div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now ($100)</button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"> </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //menu list -->
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
        $(function() {
            var $form         = $(".require-validation");
            $('form.require-validation').bind('submit', function(e) {
                var $form         = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'].join(', '),
                    $inputs       = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid         = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

        });
    </script>
@endsection

