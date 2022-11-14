@extends('layouts.about.app')
@section('title', "Sell on Scudin")

@section('content')
<!-- Sell on Amazon -->
<div class="sell-on-amazon">
    <h1>Sell on Amazon</h1>
    <div>
        <button class="sell-on-amazon-btn">Create account</button>
    </div>
</div>
<div class="container">
    <!-- Become an Amazon seller -->
    <div class="row">
        <div class="become-an-seller">
            <div class="col-md-6 become-an-seller-text">
                <h1>Become an Amazon seller</h1>
                <h6>More than half the units sold in our stores are from independent sellers.</h6>
                <button class="become-an-seller-btn">Creat account</button>
                <p>$39.99 a month + selling fee</p>
            </div>
            <div class="col-md-6 become-an-seller-img">
                <img src="{{ url('/') }}/images/prime-boxes-2-sm.png" alt="">
            </div>
        </div>
    </div>
    <!-- sales -->
    <div class="row">
        <div class="sale">
            <div class="col-md-6">
                <img src="{{ url('/') }}/images/illustration-growth-graph.svg" alt="">
            </div>
            <div class="col-md-6 sale-text">
                <h1>Over $50K in potential benefits</h1>
                <h3>Ready to sell? Launch your brand today with a powerful playbook for new sellers and over $50K in potential benefits.</h3>
                <p><i class="fa-solid fa-check"></i> Get 5% back on your first $1,000,000 in branded sales</p>
                <p><i class="fa-solid fa-check"></i> Get 5% back on your first $1,000,000 in branded sales</p>
                <p><i class="fa-solid fa-check"></i> Get 5% back on your first $1,000,000 in branded sales</p>
                <p><i class="fa-solid fa-check"></i> Get 5% back on your first $1,000,000 in branded sales</p>
            </div>
        </div>
    </div>
    <!-- finance section -->
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ url('/') }}/images/Desktop_Computer._CB424651243_.svg" alt="" height="64px" width="64px">
                    <h1>Sell more</h1>
                    <p>Fresh new startups and Fortune 500s. B2B and B2C. Brand owners and resellers. Independent third-party sellers sold more than a billion items during the 2019 holiday season alone.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ url('/') }}/images/Desktop_Computer._CB424651243_.svg" alt="" height="64px" width="64px">
                    <h1>Sell more</h1>
                    <p>Fresh new startups and Fortune 500s. B2B and B2C. Brand owners and resellers. Independent third-party sellers sold more than a billion items during the 2019 holiday season alone.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ url('/') }}/images/Desktop_Computer._CB424651243_.svg" alt="" height="64px" width="64px">
                    <h1>Sell more</h1>
                    <p>Fresh new startups and Fortune 500s. B2B and B2C. Brand owners and resellers. Independent third-party sellers sold more than a billion items during the 2019 holiday season alone.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Steven Yang -->
    <div class="row">
        <div class="steven-yang">
            <div class="col-md-6 steven-yang-img">
                <img src="{{ url('/') }}/images/Anker-01._CB1580163796_.jpg" alt="" height="400px" width="336px">
            </div>
            <div class="col-md-6 steven-yang-text">
                <h1>With all the infrastructure, systems, and processes Amazon built I realized that selling efficiency is no longer a problem.</h1>
                <div class="steven-yang-info">
                    <img src="{{ url('/') }}/images/syang-2-2x.png" alt="" width="82px" height="82px">
                    <div>
                        <h2>Steven Yang</h2>
                        <p>Anker Technology</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- learn more -->
    <div class="row">
        <div class="learn-more">
            <h1 class="learn-more-h1">Learn more about selling with Amazon</h1>
            <ul>
                <p>Get help from an Amazon account manager </p>
                <p>Get help from an Amazon account manager </p>
                <p>Get help from an Amazon account manager </p>
                <p>Get help from an Amazon account manager </p>
                <p>Get help from an Amazon account manager </p>
                <p>Get help from an Amazon account manager </p>
                <p>Get help from an Amazon account manager </p>
                <p>Get help from an Amazon account manager </p>
                <p>Get help from an Amazon account manager </p>
                <p>Get help from an Amazon account manager </p>
                <p>Get help from an Amazon account manager </p>
                <p>Get help from an Amazon account manager </p>
            </ul>
        </div>
    </div>
    <!-- Introduction to ecommerce selling -->
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <img src="{{ url('/') }}/images/Mobile_App.svg" alt="" height="64px" width="64px">
                <h1>What is ecommerce?</h1>
                <p>Electronic commerce (ecommerce) is the trading of goods and services on the internet. Learn about the advantages and disadvantages of this selling channel.Electronic commerce (ecommerce) is the trading of goods and services on the internet. Learn about the advantages and disadvantages of this selling channel.</p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <img src="{{ url('/') }}/images/Mobile_App.svg" alt="" height="64px" width="64px">
                <h1>What is ecommerce?</h1>
                <p>Electronic commerce (ecommerce) is the trading of goods and services on the internet. Learn about the advantages and disadvantages of this selling channel.Electronic commerce (ecommerce) is the trading of goods and services on the internet. Learn about the advantages and disadvantages of this selling channel.</p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <img src="{{ url('/') }}/images/Mobile_App.svg" alt="" height="64px" width="64px">
                <h1>What is ecommerce?</h1>
                <p>Electronic commerce (ecommerce) is the trading of goods and services on the internet. Learn about the advantages and disadvantages of this selling channel.Electronic commerce (ecommerce) is the trading of goods and services on the internet. Learn about the advantages and disadvantages of this selling channel.</p>
            </div>
        </div>
    </div>
    <!-- start selling -->
    <div class="row" style="margin-top: 50px;">
        <div class="col-md-12">
            <div class="start-selling" style="padding: 30px">
                <h1>Start selling today</h1>
                <p>Put your products in front of the millions of customers who search Amazon.com every day.</p>
                <button class="start-selling-btn">Creat account</button>
            </div>
        </div>
    </div>
</div>
@endsection