<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap');

        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        h1,
        h2,
        h3,
        p {
            margin: 0;
        }

        .header {
            width: 100%;
            height: 20rem;
            position: relative;
        }

        .header .background {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header .logo {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 10;
            width: 85%;
            max-width: 30rem;
            margin: auto;
            padding: 1rem;
            background-color: rgba(10, 10, 10, 0.36);
            border-radius: .5rem;
            height: fit-content;
        }

        .logo img {
            width: 100%;
        }

        .content {
            width: 85%;
            max-width: 50rem;
            margin: 1.5rem auto;
            border-radius: .5rem;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            padding: 1rem;
        }

        .content h1 {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: .8rem;
        }

        /* Contact Styles */

        .contact-content {
            width: 90%;
            margin: 1rem auto;
        }

        .contact-content h4 {
            margin: .5rem 0;
        }

        /* Item Styles */

        .item-image {
            width: 90%;
            margin: auto;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .item {
            border-top: 1px solid #ccc;
            padding-top: 1rem;
            margin-bottom: 1rem;
        }

        .item-info-content {
            width: 90%;
            margin: auto;
            padding-bottom: 1rem;
        }

        .price {
            color: #3F8C56;
            margin: .5rem 0;
        }

        .item-address h3 {
            margin-bottom: .5rem;
            line-height: 1.5;
            border-bottom: 1px solid #ccc;
        }

        .item-info p {
            color: #4b4b4b;
            font-size: .8rem;
        }

        .item a {
            color: #fff;
            font-weight: bold;
            height: 3rem;
            width: 100%;
            align-self: center;
            border: none;
            background-color: #D11241;
            border-radius: .2rem;
            cursor: pointer;
            text-decoration: none;
        }

        .item a:hover {
            background-color: #8f0e2e;
        }

        @media screen and (min-width:768px) {

            /* Contact Styles */
            .contact-content {
                width: 100%;
            }

            .contact-row-middle {
                display: flex;
            }

            .contact-field {
                width: 50%;
            }

            /* Item Styles */
            .item-image {
                width: 15rem;
                margin: 0;
            }

            .item {
                display: flex;
                gap: 1.5rem;
            }

            .item-content {
                flex-grow: 1;
                display: flex;
            }

            .item a {
                width: 5rem;
            }

            .item-info-content {
                width: 75%;
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <img class="background" src="https://yadirosalesrealtor.com/wp-content/uploads/2022/12/riverwalk-scaled.jpg"
            alt="Header">
        <div class="logo">
            <img src="https://yadirosalesrealtor.com/wp-content/uploads/2022/02/logo_blanco_50.png" alt="Logo">
        </div>
    </header>
    <main class="container">
        <div class="content">
            <h1>A new visitor to your website wants more information about this property:</h1>

            <div class="contact-container">
                <h1>Contact:</h1>
                <div class="contact-content">
                    <div class="contact-row-middle">
                        <div class="contact-field">
                            <h4>First Name</h4>
                            <p>{{$data['firstname']}}</p>
                        </div>
                        <div class="contact-field">
                            <h4>Last Name</h4>
                            <p>{{$data['lastname']}}</p>
                        </div>
                    </div>

                    <div class="contact-row-middle">
                        <div class="contact-field">
                            <h4>Email</h4>
                            <p>{{$data['email']}}</p>
                        </div>
                        <div class="contact-field">
                            <h4>Phone</h4>
                            <p>{{$data['phone']}}</p>
                        </div>
                    </div>

                    <div class="contact-row-message">
                        <h4>Message</h4>
                        <p>{{$data['message']}}</p>
                    </div>

                    <div class="contact-tour">
                        <h4>{{$data['typetour'] === 'personal' ? 'Tour in Person' : 'Tour via Video Chat'}}</h4>

                        <div class="contact-row-middle">
                            <div class="contact-field">
                                <h4>Date</h4>
                                <p>{{$data['date']}}</p>
                            </div>
                            <div class="contact-field">
                                <h4>Time of Day</h4>
                                <p>{{$data['time']}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="item">
                <div class="item-image">
                    <img src="{{$property->image}}" alt="{{$property->list_number}}">
                </div>
                <div class="item-content">
                    <div class="item-info-content">
                        <div class="item-address">
                            <h3>{{$property->street_number}} {{$property->street}} {{$property->street_suffix}}</h3>
                            <p>{{$property->city}}, {{$property->state}}, {{$property->zipcode}}</p>
                        </div>
                        <div class="item-info">
                            <p>MLS: #{{$property->list_number}}</p>
                            <h3 class="price">{{$property->price}}</h3>
                        </div>
                        <div class="item-office">
                            <p>{{$property->listing_office_name}}</p>
                            <p>{{$property->listing_member_name}}</p>
                        </div>
                    </div>
                    <a href="https://properties.yadirosalesrealtor.com/property/{{$property->id}}">
                        See more
                    </a>
                </div>
            </div>

        </div>
    </main>
</body>

</html>
