@extends('layouts.backend')
@section('title','Edit Shipping')
@push('css_or_js')

@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{__('shipping_method')}} {{__('update')}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{__('shipping_method')}} {{__('form')}}
                </div>
                <div class="card-body">
                    <form action="{{route('seller.business-settings.shipping-method.update', [$method['id']])}}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 pri">
                                    <label for="address">{{ __('shipping') }} {{__('title')}}</label>
                                    <select name="title" class="form-control" id="shipping_method">
                                        <option selected disabled> Select Shipping Method</option>
                                        
                                        <option <?php if($method['title'] == "UPS Standard"){ echo "selected"; } ?> value="UPS Standard">UPS Standard</option>
                                        <option <?php if($method['title'] == "UPS Overnight Priority"){ echo "selected"; } ?> value="UPS Overnight Priority">UPS Overnight Priority</option>
                                        
                                        <option <?php if($method['title'] == "FedEx Standard"){ echo "selected"; } ?> value="FedEx Standard">FedEx Standard</option>
                                        <option <?php if($method['title'] == "FedEx Overnight Priority"){ echo "selected"; } ?> value="FedEx Overnight Priority">FedEx Overnight Priority</option>
                                        <option <?php if($method['title'] == "FedEx Express International Export"){ echo "selected"; } ?> value="FedEx Express International Export">FedEx Express International Export</option>
                                    </select>
                                </div>

                                <div class="col-md-4 pri" hidden>
                                    <label for="title">{{__('method')}}</label>
                                    <input type="text" name="_method" id="title" class="form-control" placeholder="">
                                </div>

                                <div class="col-md-4 sec">
                                    <label for="duration">{{__('duration')}}</label>
                                    <input type="text" name="duration" value="{{ $method->duration}}" class="form-control" id="duration" placeholder="Ex : 4-6 days">
                                </div>

                                <div class="col-md-6 sec">
                                    <label for="cost">{{__('cost')}} per lbs per mile</label>
                                    <input type="number" id="cost" name="cost" value="{{ $method->cost }}" class="form-control" placeholder="Ex : 10 $">
                                </div>

                                <div class="col-md-6 sec" hidden>
                                    <label for="cost">Per Qty Additional price</label>
                                    <input type="number" id="cost" name="_cost" class="form-control" placeholder="Ex : 10 $">
                                </div>

                                <div class="col-md-6">
                                    <label for="cost">{{__('shipping')}} {{__('policy')}} </label>
                                    <input type="text" id="shipping_policy" value="https://scudin.com/terms" name="shipping_policy" class="form-control" placeholder="Shipping Policy">
                                </div>

                                <div class="col-md-6">
                                    <label for="cost">{{__('Refund')}} {{__('policy')}} </label>
                                    <input type="text" id="refund_policy" value="https://scudin.com/return-policy" name="refund_policy" class="form-control" placeholder="Refund Policy">
                                </div>

                            </div>


                            <hr class="mt-3">
                            <h4>{{ __('shipping') }} {{ __('from') }}</h4>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="inputAddress">{{ __('address') }}</label>
                                    <input type="text" class="form-control" value="{{$method['address']}}" name="address" id="inputAddress" placeholder="1234 Main St">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCountry">{{ __('country') }}</label>
                                    <select class="form-control" id="inputCountry" name="country">
                                        <option>select country</option>
                                        <option <?php if($method['country'] == "AF"){ echo "selected"; } ?>  value="AF">Afghanistan</option>
                                        <option <?php if($method['country'] == "AX"){ echo "selected"; } ?>  value="AX">Aland Islands</option>
                                        <option <?php if($method['country'] == "AL"){ echo "selected"; } ?>  value="AL">Albania</option>
                                        <option <?php if($method['country'] == "DZ"){ echo "selected"; } ?>  value="DZ">Algeria</option>
                                        <option <?php if($method['country'] == "AS"){ echo "selected"; } ?>  value="AS">American Samoa</option>
                                        <option <?php if($method['country'] == "AD"){ echo "selected"; } ?>  value="AD">Andorra</option>
                                        <option <?php if($method['country'] == "AO"){ echo "selected"; } ?>  value="AO">Angola</option>
                                        <option <?php if($method['country'] == "AI"){ echo "selected"; } ?>  value="AI">Anguilla</option>
                                        <option <?php if($method['country'] == "AQ"){ echo "selected"; } ?>  value="AQ">Antarctica</option>
                                        <option <?php if($method['country'] == "AG"){ echo "selected"; } ?>  value="AG">Antigua and Barbuda</option>
                                        <option <?php if($method['country'] == "AR"){ echo "selected"; } ?>  value="AR">Argentina</option>
                                        <option <?php if($method['country'] == "AM"){ echo "selected"; } ?>  value="AM">Armenia</option>
                                        <option <?php if($method['country'] == "AW"){ echo "selected"; } ?>  value="AW">Aruba</option>
                                        <option <?php if($method['country'] == "AU"){ echo "selected"; } ?>  value="AU">Australia</option>
                                        <option <?php if($method['country'] == "AT"){ echo "selected"; } ?>  value="AT">Austria</option>
                                        <option <?php if($method['country'] == "AZ"){ echo "selected"; } ?>  value="AZ">Azerbaijan</option>
                                        <option <?php if($method['country'] == "BS"){ echo "selected"; } ?>  value="BS">Bahamas</option>
                                        <option <?php if($method['country'] == "BH"){ echo "selected"; } ?>  value="BH">Bahrain</option>
                                        <option <?php if($method['country'] == "BD"){ echo "selected"; } ?>  value="BD">Bangladesh</option>
                                        <option <?php if($method['country'] == "BB"){ echo "selected"; } ?>  value="BB">Barbados</option>
                                        <option <?php if($method['country'] == "BY"){ echo "selected"; } ?>  value="BY">Belarus</option>
                                        <option <?php if($method['country'] == "BE"){ echo "selected"; } ?>  value="BE">Belgium</option>
                                        <option <?php if($method['country'] == "BZ"){ echo "selected"; } ?>  value="BZ">Belize</option>
                                        <option <?php if($method['country'] == "BJ"){ echo "selected"; } ?>  value="BJ">Benin</option>
                                        <option <?php if($method['country'] == "BM"){ echo "selected"; } ?>  value="BM">Bermuda</option>
                                        <option <?php if($method['country'] == "BT"){ echo "selected"; } ?>  value="BT">Bhutan</option>
                                        <option <?php if($method['country'] == "BO"){ echo "selected"; } ?>  value="BO">Bolivia</option>
                                        <option <?php if($method['country'] == "BQ"){ echo "selected"; } ?>  value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                        <option <?php if($method['country'] == "BA"){ echo "selected"; } ?>  value="BA">Bosnia and Herzegovina</option>
                                        <option <?php if($method['country'] == "BW"){ echo "selected"; } ?>  value="BW">Botswana</option>
                                        <option <?php if($method['country'] == "BV"){ echo "selected"; } ?>  value="BV">Bouvet Island</option>
                                        <option <?php if($method['country'] == "BR"){ echo "selected"; } ?>  value="BR">Brazil</option>
                                        <option <?php if($method['country'] == "IO"){ echo "selected"; } ?>  value="IO">British Indian Ocean Territory</option>
                                        <option <?php if($method['country'] == "BN"){ echo "selected"; } ?>  value="BN">Brunei Darussalam</option>
                                        <option <?php if($method['country'] == "BG"){ echo "selected"; } ?>  value="BG">Bulgaria</option>
                                        <option <?php if($method['country'] == "BF"){ echo "selected"; } ?>  value="BF">Burkina Faso</option>
                                        <option <?php if($method['country'] == "BI"){ echo "selected"; } ?>  value="BI">Burundi</option>
                                        <option <?php if($method['country'] == "KH"){ echo "selected"; } ?>  value="KH">Cambodia</option>
                                        <option <?php if($method['country'] == "CM"){ echo "selected"; } ?>  value="CM">Cameroon</option>
                                        <option <?php if($method['country'] == "CA"){ echo "selected"; } ?>  value="CA">Canada</option>
                                        <option <?php if($method['country'] == "CV"){ echo "selected"; } ?>  value="CV">Cape Verde</option>
                                        <option <?php if($method['country'] == "KY"){ echo "selected"; } ?>  value="KY">Cayman Islands</option>
                                        <option <?php if($method['country'] == "CF"){ echo "selected"; } ?>  value="CF">Central African Republic</option>
                                        <option <?php if($method['country'] == "TD"){ echo "selected"; } ?>  value="TD">Chad</option>
                                        <option <?php if($method['country'] == "CL"){ echo "selected"; } ?>  value="CL">Chile</option>
                                        <option <?php if($method['country'] == "CN"){ echo "selected"; } ?>  value="CN">China</option>
                                        <option <?php if($method['country'] == "CX"){ echo "selected"; } ?>  value="CX">Christmas Island</option>
                                        <option <?php if($method['country'] == "CC"){ echo "selected"; } ?>  value="CC">Cocos (Keeling) Islands</option>
                                        <option <?php if($method['country'] == "CO"){ echo "selected"; } ?>  value="CO">Colombia</option>
                                        <option <?php if($method['country'] == "KM"){ echo "selected"; } ?>  value="KM">Comoros</option>
                                        <option <?php if($method['country'] == "CG"){ echo "selected"; } ?>  value="CG">Congo</option>
                                        <option <?php if($method['country'] == "CD"){ echo "selected"; } ?>  value="CD">Congo, Democratic Republic of the Congo</option>
                                        <option <?php if($method['country'] == "CK"){ echo "selected"; } ?>  value="CK">Cook Islands</option>
                                        <option <?php if($method['country'] == "CR"){ echo "selected"; } ?>  value="CR">Costa Rica</option>
                                        <option <?php if($method['country'] == "CI"){ echo "selected"; } ?>  value="CI">Cote D'Ivoire</option>
                                        <option <?php if($method['country'] == "HR"){ echo "selected"; } ?>  value="HR">Croatia</option>
                                        <option <?php if($method['country'] == "CU"){ echo "selected"; } ?>  value="CU">Cuba</option>
                                        <option <?php if($method['country'] == "CW"){ echo "selected"; } ?>  value="CW">Curacao</option>
                                        <option <?php if($method['country'] == "CY"){ echo "selected"; } ?>  value="CY">Cyprus</option>
                                        <option <?php if($method['country'] == "CZ"){ echo "selected"; } ?>  value="CZ">Czech Republic</option>
                                        <option <?php if($method['country'] == "DK"){ echo "selected"; } ?>  value="DK">Denmark</option>
                                        <option <?php if($method['country'] == "DJ"){ echo "selected"; } ?>  value="DJ">Djibouti</option>
                                        <option <?php if($method['country'] == "DM"){ echo "selected"; } ?>  value="DM">Dominica</option>
                                        <option <?php if($method['country'] == "DO"){ echo "selected"; } ?>  value="DO">Dominican Republic</option>
                                        <option <?php if($method['country'] == "EC"){ echo "selected"; } ?>  value="EC">Ecuador</option>
                                        <option <?php if($method['country'] == "EG"){ echo "selected"; } ?>  value="EG">Egypt</option>
                                        <option <?php if($method['country'] == "SV"){ echo "selected"; } ?>  value="SV">El Salvador</option>
                                        <option <?php if($method['country'] == "GQ"){ echo "selected"; } ?>  value="GQ">Equatorial Guinea</option>
                                        <option <?php if($method['country'] == "ER"){ echo "selected"; } ?>  value="ER">Eritrea</option>
                                        <option <?php if($method['country'] == "EE"){ echo "selected"; } ?>  value="EE">Estonia</option>
                                        <option <?php if($method['country'] == "ET"){ echo "selected"; } ?>  value="ET">Ethiopia</option>
                                        <option <?php if($method['country'] == "FK"){ echo "selected"; } ?>  value="FK">Falkland Islands (Malvinas)</option>
                                        <option <?php if($method['country'] == "FO"){ echo "selected"; } ?>  value="FO">Faroe Islands</option>
                                        <option <?php if($method['country'] == "FJ"){ echo "selected"; } ?>  value="FJ">Fiji</option>
                                        <option <?php if($method['country'] == "FI"){ echo "selected"; } ?>  value="FI">Finland</option>
                                        <option <?php if($method['country'] == "FR"){ echo "selected"; } ?>  value="FR">France</option>
                                        <option <?php if($method['country'] == "GF"){ echo "selected"; } ?>  value="GF">French Guiana</option>
                                        <option <?php if($method['country'] == "PF"){ echo "selected"; } ?>  value="PF">French Polynesia</option>
                                        <option <?php if($method['country'] == "TF"){ echo "selected"; } ?>  value="TF">French Southern Territories</option>
                                        <option <?php if($method['country'] == "GA"){ echo "selected"; } ?>  value="GA">Gabon</option>
                                        <option <?php if($method['country'] == "GM"){ echo "selected"; } ?>  value="GM">Gambia</option>
                                        <option <?php if($method['country'] == "GE"){ echo "selected"; } ?>  value="GE">Georgia</option>
                                        <option <?php if($method['country'] == "DE"){ echo "selected"; } ?>  value="DE">Germany</option>
                                        <option <?php if($method['country'] == "GH"){ echo "selected"; } ?>  value="GH">Ghana</option>
                                        <option <?php if($method['country'] == "GI"){ echo "selected"; } ?>  value="GI">Gibraltar</option>
                                        <option <?php if($method['country'] == "GR"){ echo "selected"; } ?>  value="GR">Greece</option>
                                        <option <?php if($method['country'] == "GL"){ echo "selected"; } ?>  value="GL">Greenland</option>
                                        <option <?php if($method['country'] == "GD"){ echo "selected"; } ?>  value="GD">Grenada</option>
                                        <option <?php if($method['country'] == "GP"){ echo "selected"; } ?>  value="GP">Guadeloupe</option>
                                        <option <?php if($method['country'] == "GU"){ echo "selected"; } ?>  value="GU">Guam</option>
                                        <option <?php if($method['country'] == "GT"){ echo "selected"; } ?>  value="GT">Guatemala</option>
                                        <option <?php if($method['country'] == "GG"){ echo "selected"; } ?>  value="GG">Guernsey</option>
                                        <option <?php if($method['country'] == "GN"){ echo "selected"; } ?>  value="GN">Guinea</option>
                                        <option <?php if($method['country'] == "GW"){ echo "selected"; } ?>  value="GW">Guinea-Bissau</option>
                                        <option <?php if($method['country'] == "GY"){ echo "selected"; } ?>  value="GY">Guyana</option>
                                        <option <?php if($method['country'] == "HT"){ echo "selected"; } ?>  value="HT">Haiti</option>
                                        <option <?php if($method['country'] == "HM"){ echo "selected"; } ?>  value="HM">Heard Island and Mcdonald Islands</option>
                                        <option <?php if($method['country'] == "VA"){ echo "selected"; } ?>  value="VA">Holy See (Vatican City State)</option>
                                        <option <?php if($method['country'] == "HN"){ echo "selected"; } ?>  value="HN">Honduras</option>
                                        <option <?php if($method['country'] == "HK"){ echo "selected"; } ?>  value="HK">Hong Kong</option>
                                        <option <?php if($method['country'] == "HU"){ echo "selected"; } ?>  value="HU">Hungary</option>
                                        <option <?php if($method['country'] == "IS"){ echo "selected"; } ?>  value="IS">Iceland</option>
                                        <option <?php if($method['country'] == "IN"){ echo "selected"; } ?>  value="IN">India</option>
                                        <option <?php if($method['country'] == "ID"){ echo "selected"; } ?>  value="ID">Indonesia</option>
                                        <option <?php if($method['country'] == "IR"){ echo "selected"; } ?>  value="IR">Iran, Islamic Republic of</option>
                                        <option <?php if($method['country'] == "IQ"){ echo "selected"; } ?>  value="IQ">Iraq</option>
                                        <option <?php if($method['country'] == "IE"){ echo "selected"; } ?>  value="IE">Ireland</option>
                                        <option <?php if($method['country'] == "IM"){ echo "selected"; } ?>  value="IM">Isle of Man</option>
                                        <option <?php if($method['country'] == "IL"){ echo "selected"; } ?>  value="IL">Israel</option>
                                        <option <?php if($method['country'] == "IT"){ echo "selected"; } ?>  value="IT">Italy</option>
                                        <option <?php if($method['country'] == "JM"){ echo "selected"; } ?>  value="JM">Jamaica</option>
                                        <option <?php if($method['country'] == "JP"){ echo "selected"; } ?>  value="JP">Japan</option>
                                        <option <?php if($method['country'] == "JE"){ echo "selected"; } ?>  value="JE">Jersey</option>
                                        <option <?php if($method['country'] == "JO"){ echo "selected"; } ?>  value="JO">Jordan</option>
                                        <option <?php if($method['country'] == "KZ"){ echo "selected"; } ?>  value="KZ">Kazakhstan</option>
                                        <option <?php if($method['country'] == "KE"){ echo "selected"; } ?>  value="KE">Kenya</option>
                                        <option <?php if($method['country'] == "KI"){ echo "selected"; } ?>  value="KI">Kiribati</option>
                                        <option <?php if($method['country'] == "KP"){ echo "selected"; } ?>  value="KP">Korea, Democratic People's Republic of</option>
                                        <option <?php if($method['country'] == "KR"){ echo "selected"; } ?>  value="KR">Korea, Republic of</option>
                                        <option <?php if($method['country'] == "XK"){ echo "selected"; } ?>  value="XK">Kosovo</option>
                                        <option <?php if($method['country'] == "KW"){ echo "selected"; } ?>  value="KW">Kuwait</option>
                                        <option <?php if($method['country'] == "KG"){ echo "selected"; } ?>  value="KG">Kyrgyzstan</option>
                                        <option <?php if($method['country'] == "LA"){ echo "selected"; } ?>  value="LA">Lao People's Democratic Republic</option>
                                        <option <?php if($method['country'] == "LV"){ echo "selected"; } ?>  value="LV">Latvia</option>
                                        <option <?php if($method['country'] == "LB"){ echo "selected"; } ?>  value="LB">Lebanon</option>
                                        <option <?php if($method['country'] == "LS"){ echo "selected"; } ?>  value="LS">Lesotho</option>
                                        <option <?php if($method['country'] == "LR"){ echo "selected"; } ?>  value="LR">Liberia</option>
                                        <option <?php if($method['country'] == "LY"){ echo "selected"; } ?>  value="LY">Libyan Arab Jamahiriya</option>
                                        <option <?php if($method['country'] == "LI"){ echo "selected"; } ?>  value="LI">Liechtenstein</option>
                                        <option <?php if($method['country'] == "LT"){ echo "selected"; } ?>  value="LT">Lithuania</option>
                                        <option <?php if($method['country'] == "LU"){ echo "selected"; } ?>  value="LU">Luxembourg</option>
                                        <option <?php if($method['country'] == "MO"){ echo "selected"; } ?>  value="MO">Macao</option>
                                        <option <?php if($method['country'] == "MK"){ echo "selected"; } ?>  value="MK">Macedonia, the Former Yugoslav Republic of</option>
                                        <option <?php if($method['country'] == "MG"){ echo "selected"; } ?>  value="MG">Madagascar</option>
                                        <option <?php if($method['country'] == "MW"){ echo "selected"; } ?>  value="MW">Malawi</option>
                                        <option <?php if($method['country'] == "MY"){ echo "selected"; } ?>  value="MY">Malaysia</option>
                                        <option <?php if($method['country'] == "MV"){ echo "selected"; } ?>  value="MV">Maldives</option>
                                        <option <?php if($method['country'] == "ML"){ echo "selected"; } ?>  value="ML">Mali</option>
                                        <option <?php if($method['country'] == "MT"){ echo "selected"; } ?>  value="MT">Malta</option>
                                        <option <?php if($method['country'] == "MH"){ echo "selected"; } ?>  value="MH">Marshall Islands</option>
                                        <option <?php if($method['country'] == "MQ"){ echo "selected"; } ?>  value="MQ">Martinique</option>
                                        <option <?php if($method['country'] == "MR"){ echo "selected"; } ?>  value="MR">Mauritania</option>
                                        <option <?php if($method['country'] == "MU"){ echo "selected"; } ?>  value="MU">Mauritius</option>
                                        <option <?php if($method['country'] == "YT"){ echo "selected"; } ?>  value="YT">Mayotte</option>
                                        <option <?php if($method['country'] == "MX"){ echo "selected"; } ?>  value="MX">Mexico</option>
                                        <option <?php if($method['country'] == "FM"){ echo "selected"; } ?>  value="FM">Micronesia, Federated States of</option>
                                        <option <?php if($method['country'] == "MD"){ echo "selected"; } ?>  value="MD">Moldova, Republic of</option>
                                        <option <?php if($method['country'] == "MC"){ echo "selected"; } ?>  value="MC">Monaco</option>
                                        <option <?php if($method['country'] == "MN"){ echo "selected"; } ?>  value="MN">Mongolia</option>
                                        <option <?php if($method['country'] == "ME"){ echo "selected"; } ?>  value="ME">Montenegro</option>
                                        <option <?php if($method['country'] == "MS"){ echo "selected"; } ?>  value="MS">Montserrat</option>
                                        <option <?php if($method['country'] == "MA"){ echo "selected"; } ?>  value="MA">Morocco</option>
                                        <option <?php if($method['country'] == "MZ"){ echo "selected"; } ?>  value="MZ">Mozambique</option>
                                        <option <?php if($method['country'] == "MM"){ echo "selected"; } ?>  value="MM">Myanmar</option>
                                        <option <?php if($method['country'] == "NA"){ echo "selected"; } ?>  value="NA">Namibia</option>
                                        <option <?php if($method['country'] == "NR"){ echo "selected"; } ?>  value="NR">Nauru</option>
                                        <option <?php if($method['country'] == "NP"){ echo "selected"; } ?>  value="NP">Nepal</option>
                                        <option <?php if($method['country'] == "NL"){ echo "selected"; } ?>  value="NL">Netherlands</option>
                                        <option <?php if($method['country'] == "AN"){ echo "selected"; } ?>  value="AN">Netherlands Antilles</option>
                                        <option <?php if($method['country'] == "NC"){ echo "selected"; } ?>  value="NC">New Caledonia</option>
                                        <option <?php if($method['country'] == "NZ"){ echo "selected"; } ?>  value="NZ">New Zealand</option>
                                        <option <?php if($method['country'] == "NI"){ echo "selected"; } ?>  value="NI">Nicaragua</option>
                                        <option <?php if($method['country'] == "NE"){ echo "selected"; } ?>  value="NE">Niger</option>
                                        <option <?php if($method['country'] == "NG"){ echo "selected"; } ?>  value="NG">Nigeria</option>
                                        <option <?php if($method['country'] == "NU"){ echo "selected"; } ?>  value="NU">Niue</option>
                                        <option <?php if($method['country'] == "NF"){ echo "selected"; } ?>  value="NF">Norfolk Island</option>
                                        <option <?php if($method['country'] == "MP"){ echo "selected"; } ?>  value="MP">Northern Mariana Islands</option>
                                        <option <?php if($method['country'] == "NO"){ echo "selected"; } ?>  value="NO">Norway</option>
                                        <option <?php if($method['country'] == "OM"){ echo "selected"; } ?>  value="OM">Oman</option>
                                        <option <?php if($method['country'] == "PK"){ echo "selected"; } ?>  value="PK">Pakistan</option>
                                        <option <?php if($method['country'] == "PW"){ echo "selected"; } ?>  value="PW">Palau</option>
                                        <option <?php if($method['country'] == "PS"){ echo "selected"; } ?>  value="PS">Palestinian Territory, Occupied</option>
                                        <option <?php if($method['country'] == "PA"){ echo "selected"; } ?>  value="PA">Panama</option>
                                        <option <?php if($method['country'] == "PG"){ echo "selected"; } ?>  value="PG">Papua New Guinea</option>
                                        <option <?php if($method['country'] == "PY"){ echo "selected"; } ?>  value="PY">Paraguay</option>
                                        <option <?php if($method['country'] == "PE"){ echo "selected"; } ?>  value="PE">Peru</option>
                                        <option <?php if($method['country'] == "PH"){ echo "selected"; } ?>  value="PH">Philippines</option>
                                        <option <?php if($method['country'] == "PN"){ echo "selected"; } ?>  value="PN">Pitcairn</option>
                                        <option <?php if($method['country'] == "PL"){ echo "selected"; } ?>  value="PL">Poland</option>
                                        <option <?php if($method['country'] == "PT"){ echo "selected"; } ?>  value="PT">Portugal</option>
                                        <option <?php if($method['country'] == "PR"){ echo "selected"; } ?>  value="PR">Puerto Rico</option>
                                        <option <?php if($method['country'] == "QA"){ echo "selected"; } ?>  value="QA">Qatar</option>
                                        <option <?php if($method['country'] == "RE"){ echo "selected"; } ?>  value="RE">Reunion</option>
                                        <option <?php if($method['country'] == "RO"){ echo "selected"; } ?>  value="RO">Romania</option>
                                        <option <?php if($method['country'] == "RU"){ echo "selected"; } ?>  value="RU">Russian Federation</option>
                                        <option <?php if($method['country'] == "RW"){ echo "selected"; } ?>  value="RW">Rwanda</option>
                                        <option <?php if($method['country'] == "BL"){ echo "selected"; } ?>  value="BL">Saint Barthelemy</option>
                                        <option <?php if($method['country'] == "SH"){ echo "selected"; } ?>  value="SH">Saint Helena</option>
                                        <option <?php if($method['country'] == "KN"){ echo "selected"; } ?>  value="KN">Saint Kitts and Nevis</option>
                                        <option <?php if($method['country'] == "LC"){ echo "selected"; } ?>  value="LC">Saint Lucia</option>
                                        <option <?php if($method['country'] == "MF"){ echo "selected"; } ?>  value="MF">Saint Martin</option>
                                        <option <?php if($method['country'] == "PM"){ echo "selected"; } ?>  value="PM">Saint Pierre and Miquelon</option>
                                        <option <?php if($method['country'] == "VC"){ echo "selected"; } ?>  value="VC">Saint Vincent and the Grenadines</option>
                                        <option <?php if($method['country'] == "WS"){ echo "selected"; } ?>  value="WS">Samoa</option>
                                        <option <?php if($method['country'] == "SM"){ echo "selected"; } ?>  value="SM">San Marino</option>
                                        <option <?php if($method['country'] == "ST"){ echo "selected"; } ?>  value="ST">Sao Tome and Principe</option>
                                        <option <?php if($method['country'] == "SA"){ echo "selected"; } ?>  value="SA">Saudi Arabia</option>
                                        <option <?php if($method['country'] == "SN"){ echo "selected"; } ?>  value="SN">Senegal</option>
                                        <option <?php if($method['country'] == "RS"){ echo "selected"; } ?>  value="RS">Serbia</option>
                                        <option <?php if($method['country'] == "CS"){ echo "selected"; } ?>  value="CS">Serbia and Montenegro</option>
                                        <option <?php if($method['country'] == "SC"){ echo "selected"; } ?>  value="SC">Seychelles</option>
                                        <option <?php if($method['country'] == "SL"){ echo "selected"; } ?>  value="SL">Sierra Leone</option>
                                        <option <?php if($method['country'] == "SG"){ echo "selected"; } ?>  value="SG">Singapore</option>
                                        <option <?php if($method['country'] == "SX"){ echo "selected"; } ?>  value="SX">Sint Maarten</option>
                                        <option <?php if($method['country'] == "SK"){ echo "selected"; } ?>  value="SK">Slovakia</option>
                                        <option <?php if($method['country'] == "SI"){ echo "selected"; } ?>  value="SI">Slovenia</option>
                                        <option <?php if($method['country'] == "SB"){ echo "selected"; } ?>  value="SB">Solomon Islands</option>
                                        <option <?php if($method['country'] == "SO"){ echo "selected"; } ?>  value="SO">Somalia</option>
                                        <option <?php if($method['country'] == "ZA"){ echo "selected"; } ?>  value="ZA">South Africa</option>
                                        <option <?php if($method['country'] == "GS"){ echo "selected"; } ?>  value="GS">South Georgia and the South Sandwich Islands</option>
                                        <option <?php if($method['country'] == "SS"){ echo "selected"; } ?>  value="SS">South Sudan</option>
                                        <option <?php if($method['country'] == "ES"){ echo "selected"; } ?>  value="ES">Spain</option>
                                        <option <?php if($method['country'] == "LK"){ echo "selected"; } ?>  value="LK">Sri Lanka</option>
                                        <option <?php if($method['country'] == "SD"){ echo "selected"; } ?>  value="SD">Sudan</option>
                                        <option <?php if($method['country'] == "SR"){ echo "selected"; } ?>  value="SR">Suriname</option>
                                        <option <?php if($method['country'] == "SJ"){ echo "selected"; } ?>  value="SJ">Svalbard and Jan Mayen</option>
                                        <option <?php if($method['country'] == "SZ"){ echo "selected"; } ?>  value="SZ">Swaziland</option>
                                        <option <?php if($method['country'] == "SE"){ echo "selected"; } ?>  value="SE">Sweden</option>
                                        <option <?php if($method['country'] == "CH"){ echo "selected"; } ?>  value="CH">Switzerland</option>
                                        <option <?php if($method['country'] == "SY"){ echo "selected"; } ?>  value="SY">Syrian Arab Republic</option>
                                        <option <?php if($method['country'] == "TW"){ echo "selected"; } ?>  value="TW">Taiwan, Province of China</option>
                                        <option <?php if($method['country'] == "TJ"){ echo "selected"; } ?>  value="TJ">Tajikistan</option>
                                        <option <?php if($method['country'] == "TZ"){ echo "selected"; } ?>  value="TZ">Tanzania, United Republic of</option>
                                        <option <?php if($method['country'] == "TH"){ echo "selected"; } ?>  value="TH">Thailand</option>
                                        <option <?php if($method['country'] == "TL"){ echo "selected"; } ?>  value="TL">Timor-Leste</option>
                                        <option <?php if($method['country'] == "TG"){ echo "selected"; } ?>  value="TG">Togo</option>
                                        <option <?php if($method['country'] == "TK"){ echo "selected"; } ?>  value="TK">Tokelau</option>
                                        <option <?php if($method['country'] == "TO"){ echo "selected"; } ?>  value="TO">Tonga</option>
                                        <option <?php if($method['country'] == "TT"){ echo "selected"; } ?>  value="TT">Trinidad and Tobago</option>
                                        <option <?php if($method['country'] == "TN"){ echo "selected"; } ?>  value="TN">Tunisia</option>
                                        <option <?php if($method['country'] == "TR"){ echo "selected"; } ?>  value="TR">Turkey</option>
                                        <option <?php if($method['country'] == "TM"){ echo "selected"; } ?>  value="TM">Turkmenistan</option>
                                        <option <?php if($method['country'] == "TC"){ echo "selected"; } ?>  value="TC">Turks and Caicos Islands</option>
                                        <option <?php if($method['country'] == "TV"){ echo "selected"; } ?>  value="TV">Tuvalu</option>
                                        <option <?php if($method['country'] == "UG"){ echo "selected"; } ?>  value="UG">Uganda</option>
                                        <option <?php if($method['country'] == "UA"){ echo "selected"; } ?>  value="UA">Ukraine</option>
                                        <option <?php if($method['country'] == "AE"){ echo "selected"; } ?>  value="AE">United Arab Emirates</option>
                                        <option <?php if($method['country'] == "GB"){ echo "selected"; } ?>  value="GB">United Kingdom</option>
                                        <option <?php if($method['country'] == "US"){ echo "selected"; } ?>  value="US">United States</option>
                                        <option <?php if($method['country'] == "UM"){ echo "selected"; } ?>  value="UM">United States Minor Outlying Islands</option>
                                        <option <?php if($method['country'] == "UY"){ echo "selected"; } ?>  value="UY">Uruguay</option>
                                        <option <?php if($method['country'] == "UZ"){ echo "selected"; } ?>  value="UZ">Uzbekistan</option>
                                        <option <?php if($method['country'] == "VU"){ echo "selected"; } ?>  value="VU">Vanuatu</option>
                                        <option <?php if($method['country'] == "VE"){ echo "selected"; } ?>  value="VE">Venezuela</option>
                                        <option <?php if($method['country'] == "VN"){ echo "selected"; } ?>  value="VN">Viet Nam</option>
                                        <option <?php if($method['country'] == "VG"){ echo "selected"; } ?>  value="VG">Virgin Islands, British</option>
                                        <option <?php if($method['country'] == "VI"){ echo "selected"; } ?>  value="VI">Virgin Islands, U.s.</option>
                                        <option <?php if($method['country'] == "WF"){ echo "selected"; } ?>  value="WF">Wallis and Futuna</option>
                                        <option <?php if($method['country'] == "EH"){ echo "selected"; } ?>  value="EH">Western Sahara</option>
                                        <option <?php if($method['country'] == "YE"){ echo "selected"; } ?>  value="YE">Yemen</option>
                                        <option <?php if($method['country'] == "ZM"){ echo "selected"; } ?>  value="ZM">Zambia</option>
                                        <option <?php if($method['country'] == "ZW"){ echo "selected"; } ?>  value="ZW">Zimbabwe</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCity">City</label>
                                    <input type="text" class="form-control" value="{{$method['city']}}" name="city" placeholder="Las Vegas" id="inputCity">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputState">State Code</label>
                                    <input type="text" class="form-control" value="{{$method['state']}}" maxlength="2" name="state" id="inputState" placeholder="Ex: NY, LA, CA, TX">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputZip">Zip</label>
                                    <input type="text" class="form-control" value="{{$method['postal']}}" name="postal" id="inputZip" placeholder="90011">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer" style="padding-left: 0">
                            <button type="button" id="validateAddr" onclick="validateAddress()" class="btn btn-primary">{{__('validate')}} {{__('address')}}</button>
                            <button type="submit" hidden id="submitAddr" class="btn btn-primary">{{__('Submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function validateAddress() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $("#validateAddr").empty().append("<i class='fas fa-spinner fa-pulse'></i> Validating...").attr('disabled', true);
        $.ajax({
            url: "{{route('address.validation')}}",
            method: 'POST',
            data: {
                address: $("#inputAddress").val(),
                country: $("#inputCountry").val(),
                city: $("#inputCity").val(),
                state: $("#inputState").val(),
                postal: $("#inputZip").val(),
            },
            dataType: "JSON",
            success: function(response) {
                if (response.status == 'success') {
                    $("#validateAddr").hide();
                    $("#submitAddr").attr('hidden', false);
                    $("#submitAddr").show();
                    $("#validateAddr").empty().append("Validate").attr('disabled', false);
                    toastr.success(response.msg);
                } else {
                    $("#validateAddr").empty().append("Validate").attr('disabled', false);
                    toastr.error(response.msg);
                }
            }
        });
    }
</script>
@endpush