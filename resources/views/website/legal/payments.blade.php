@extends('website.layout')

@section('page')

    <div class="layer">
        <div class="container">

            <div class="legal">

                <h1>Payments. Online Payment Using a Bank Card</h1>
                <p class="legal__updated">Updated at 2021-06-10</p>

                <h2>General</h2>

                <p>
                    Our web site is connected to Internet acquiring. You can pay your Good using your Visa, MasterCard, Maestro bank card. After confirming a selected Good, a secure window will open, which provides a payment page of a 2Checkout processing centre, where you have to enter your bank card data. For an additional authentication of a
                    cardholder, 3D Secure is used. If your Bank supports this technology, you will be redirected to its server for additional identification. For information on rules and additional identification methods, contact the

                    The bank which has issued your bank card.
                </p>

                <h2>Security Guarantees</h2>

                <p>
                    The 2Checkout processing centre secures and processes your bank card data according to the PCI DSS security standard. Information is sent to a payment gateway using a SSL encryption. Any further information transfer is done on private banking networks which feature the highest reliability.
                    2Checkout does not transfer your card
                    data to us nor other 3rd parties. For an additional authentication of a cardholder, 3D Secure is used.

                </p>

                <p>
                    If you have any questions of payment done, you can contact a payment service’s customer support service at <a href="https://www.2co.com/#contactUs" class="bm-link">https://www.2co.com/#contactUs</a>

                </p>

                <p>
                    Your personal information you provide (name, address, phone, e-mail address, credit card number) is confidential and is not subject to disclosure. Your credit card data is transmitted only in an encrypted format and is not stored on our Web server.

                </p>


                <p>
                    2Checkout guarantees the security of an online payment processing. All transactions with payment cards are done according to VISA International, MasterCard and other payment system requirements. When sending information, special security technologies for online card payments are used. A data processing is performed at a secure hi-tech
                    server of a processing company.

                </p>


                <div style="display: flex; justify-content: flex-start; align-items: center; margin: 32px 0 48px 0;">

                    <a target="_blank" href="https://usa.visa.com/products/visa-secure.html">
                        <img style="width: 240px;" src="/website/payments/visa-secure.jpg" alt="Visa Secure">
                    </a>

                    <a target="_blank" href="https://www.mastercard.com/global/en/frequently-asked-questions.html">
                        <img style="width: 240px;" src="/website/payments/mastercard-securecode.png" alt="Visa Secure">
                    </a>



                </div>

                <h2>Contact Us</h2>

                <p>Don't hesitate to contact us if you have any questions.</p>

                <ul>

                    <li>Via E-mail:
                        <a href="mailto:contact@boykomarket.com" class="bm-link">contact@boykomarket.com</a>
                    </li>

                    <li>Via this Link:
                        <a class="bm-link" href="https://boykomarket.com/contact">https://boykomarket.com/contact</a>
                    </li>

                </ul>

            </div>

        </div>
    </div>

@endsection
