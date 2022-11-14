<div>
  <div class="card mt-2">
    <div class="card-header">
      <h4>Hardware</h4>
    </div>
    <div class="card-body">
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <label for="Memory">
              {{__('RAM Memory')}} :
            </label>
            <input type="text" value="{{ $product->ram ?? NULL }}" name="ram" class="form-control" placeholder="{{__('RAM Memory')}}">
          </div>

          <div class="col-md-6">
            <label for="cores" style="padding-bottom: 3px">
              {{__('CPU cores')}} :
            </label>
            <input type="text" value="{{ $product->ram ?? NULL }}" name="ram" class="form-control" placeholder="{{__('CPU cores')}}">
          </div>
          <div class="col-md-6">
            <label for="colors">
              {{__('Accelerometer')}} :
            </label>
            <input type="text" value="{{ $product->ram ?? NULL }}" name="ram" class="form-control" placeholder="{{__('RAM Memory')}}">
          </div>

          <div class="col-md-6">
            <label for="attributes" style="padding-bottom: 3px">
              {{__('Ambient Light Sensor')}} :
            </label>
            <input type="text" value="{{ $product->ram ?? NULL }}" name="ram" class="form-control" placeholder="{{__('RAM Memory')}}">
          </div>

          <div class="col-md-6">
            <label for="attributes" style="padding-bottom: 3px">
              {{__('Compass')}} :
            </label>
            <input type="text" value="{{ $product->ram ?? NULL }}" name="ram" class="form-control" placeholder="{{__('RAM Memory')}}">
          </div>
          <div class="col-md-6">
            <label for="attributes" style="padding-bottom: 3px">
              {{__('Gyroscope')}} :
            </label>
            <input type="text" value="{{ $product->ram ?? NULL }}" name="ram" class="form-control" placeholder="{{__('RAM Memory')}}">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>