<div>
  <div class="card mt-2">
    <div class="card-header">
      <h4>{{ __('Car Specifications & Datas') }}</h4>
    </div>
    <div class="card-body">
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <label for="Memory">
              {{__('Transmission')}} :
            </label>
            <input type="text" name="_data['transmission']" value="{{ $product->transmission ?? NULL }}" class="form-control" placeholder="{{__('Transmission')}}">
          </div>

          <div class="col-md-6">
            <label for="cores" style="padding-bottom: 3px">
              {{__('Engine')}} :
            </label>
            <input type="text" name="_data['engine']" value="{{ $product->engine ?? NULL }}" class="form-control" placeholder="{{__('Engine')}}">
          </div>
          <div class="col-md-6">
            <label for="colors">
              {{__('Seating Capacity')}} :
            </label>
            <input type="text" name="_data['seating_capacity']" value="{{ $product->seating_capacity ?? NULL }}" class="form-control" placeholder="{{__('Seating Capacity')}}">
          </div>

          <div class="col-md-6">
            <label for="attributes" style="padding-bottom: 3px">
              {{__('Wheels')}} :
            </label>
            <input type="text" name="_data['wheels']" value="{{ $product->wheels ?? NULL }}" class="form-control" placeholder="{{__('Wheels')}}">
          </div>

          <div class="col-md-6">
            <label for="attributes" style="padding-bottom: 3px">
              {{__('Body Type')}} :
            </label>
            <input type="text" name="_data['body_type']" value="{{ $product->body_type ?? NULL }}" class="form-control" placeholder="{{__('Body Type')}}">
          </div>
          <div class="col-md-6">
            <label for="attributes" style="padding-bottom: 3px">
              {{__('Power & Torque')}} :
            </label>
            <input type="text" name="_data['power_and_torque']" value="{{ $product->power_and_torque ?? NULL }}" class="form-control" placeholder="{{__('Power and Torque')}}">
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <label for="Memory">
              {{__('Service Intervals')}} :
            </label>
            <input type="text" name="_data['service_ntervals']" value="{{ $product->service_ntervals ?? NULL }}" class="form-control" placeholder="{{__('Service Intervals')}} Ex: 5000km">
          </div>

          <div class="col-md-6">
            <label for="cores" style="padding-bottom: 3px">
              {{__('Safety')}} :
            </label>
            <input type="text" name="_data['safety']" value="{{ $product->safety ?? NULL }}" class="form-control" placeholder="{{__('Safety')}}">
          </div>
          <div class="col-md-6">
            <label for="colors">
              {{__('Trim')}} :
            </label>
            <input type="text" name="_data['trim']" value="{{ $product->trim ?? NULL }}" class="form-control" placeholder="{{__('Trim')}}">
          </div>

          <div class="col-md-6">
            <label for="attributes" style="padding-bottom: 3px">
              {{__('Number of Cylinders')}} :
            </label>
            <input type="text" name="_data['number_of_cylinders']" value="{{ $product->number_of_cylinders ?? NULL }}" class="form-control" placeholder="{{__('Number of Cylinders')}}">
          </div>

          <div class="col-md-6">
            <label for="attributes" style="padding-bottom: 3px">
              {{__('Bore and Stroke')}} :
            </label>
            <input type="text" name="_data['bore_and_stroke']" value="{{ $product->bore_and_stroke ?? NULL }}" class="form-control" placeholder="{{__('Bore and Stroke')}}">
          </div>
          <div class="col-md-6">
            <label for="attributes" style="padding-bottom: 3px">
              {{__('Maximum Power')}} :
            </label>
            <input type="text" name="_data['maimum_power']" value="{{ $product->maimum_power ?? NULL }}" class="form-control" placeholder="{{__('Maximum Power')}}">
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <label for="Memory">
              {{__('Fuel Type')}} :
            </label>
            <input type="text" name="_data['fuel_type']" value="{{ $product->fuel_type ?? NULL }}" class="form-control" placeholder="{{__('Fuel Type.')}} Petrol, Diesel, Hybrid, Electric?">
          </div>

          <div class="col-md-6">
            <label for="cores" style="padding-bottom: 3px">
              {{__('Fuel Supply')}} :
            </label>
            <input type="text" name="_data['fuel_supply']" value="{{ $product->fuel_supply ?? NULL }}" class="form-control" placeholder="{{__('Fuel Supply')}}">
          </div>
          <div class="col-md-6">
            <label for="colors">
              {{__('Fuel Tank Capacity')}} :
            </label>
            <input type="text" name="_data['fuel_tank_capacity']" value="{{ $product->fuel_tank_capacity ?? NULL }}" class="form-control" placeholder="{{__('Fuel Tank Capacity')}}">
          </div>

          <div class="col-md-6">
            <label for="attributes" style="padding-bottom: 3px">
              {{__('Suspension')}} :
            </label>
            <input type="text" name="_data['suspension']" value="{{ $product->suspension ?? NULL }}" class="form-control" placeholder="{{__('Suspension')}}">
          </div>

          <div class="col-md-6">
            <label for="attributes" style="padding-bottom: 3px">
              {{__('Sound System')}} :
            </label>
            <input type="text" name="_data['sound_system']" value="{{ $product->sound_system ?? NULL }}" class="form-control" placeholder="{{__('Sound System')}}">
          </div>

          <div class="col-md-6">
            <label for="attributes" style="padding-bottom: 3px">
              {{__('Warranty')}} :
            </label>
            <input type="text" name="_data['warranty']" value="{{ $product->warranty ?? NULL }}" class="form-control" placeholder="{{__('Warranty')}}">
          </div>

          <div class="col-md-12">
            <label for="attributes" style="padding-bottom: 3px">
              {{__('Others')}} :
            </label>
            <textarea name="_data['others']" value="{{ $product->others ?? NULL }}" cols="4" rows="12" class="form-control text-area" placeholder="{{__('Others')}}"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>