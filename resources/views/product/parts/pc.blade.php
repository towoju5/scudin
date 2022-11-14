<div>
  <div class="card mt-2">
    <div class="card-header">
      <h4>Additional Product Information</h4>
    </div>
    <div class="card-body">
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <label for="Memory">
              {{__('Memory')}} :
            </label>
            <input type="text" required value="{{ $product->memory ?? NULL }}" name="_data[memory]" class="form-control" placeholder="Ex: 6GB">
          </div>

          <div class="col-md-6">
            <label for="processor">
              {{__('Processor')}} :
            </label>
            <input type="text" required value="{{ $product->processor ?? NULL }}" name="_data[processor]" class="form-control" placeholder="Ex: Intel Core i5">
          </div>


          <div class="col-md-6">
            <label for="ram">
              {{__('Ram Size')}} :
            </label>
            <input type="text" value="{{ $product->ram ?? NULL }}" name="_data[ram]" class="form-control" placeholder="Ex: 16GB">
          </div>


          <div class="col-md-6">
            <label for="cores" style="padding-bottom: 3px">
              {{__('Storage Capacity')}} :
            </label>
            <input type="text" required value="{{ $product->storage ?? NULL }}" name="_data[storage]" class="form-control" placeholder="Ex: 1 TB SSD">
          </div>

          <div class="col-md-6">
            <label for="processor_peed">
              {{__('Processor Speed')}} :
            </label>
            <input type="text" required value="{{ $product->processor_peed ?? NULL }}" name="_data[processor_peed]" class="form-control" placeholder="Ex: 2.50 GHz">
          </div>

          <div class="col-md-6">
            <label for="release_year" style="padding-bottom: 3px">
              {{__('Release Year')}} :
            </label>
            <input type="text" value="{{ $product->release_year ?? NULL }}" name="_data[release_year]" class="form-control" placeholder="Ex: {{ date('Y') }}">
          </div>

          <div class="col-md-6">
            <label for="operating_system" style="padding-bottom: 3px">
              {{__('Operating System')}} :
            </label>
            <input type="text" required value="{{ $product->operating_system ?? NULL }}" name="_data[operating_system]" class="form-control" placeholder="Ex: Mac OS 11.0, Big Sur / Windows 11 pro">
          </div>

          <div class="col-md-6">
            <label for="upc" style="padding-bottom: 3px">
              {{__('UPC')}} :
            </label>
            <input type="text" value="{{ $product->upc ?? NULL }}" name="_data[upc]" class="form-control" placeholder="Ex: ">
          </div>

          <div class="col-md-6">
            <label for="screen_size" style="padding-bottom: 3px">
              {{__('Screen Size')}} :
            </label>
            <input type="text" value="{{ $product->screen_size ?? NULL }}" name="_data[screen_size]" class="form-control" placeholder="Ex: 13.3 in">
          </div>

          <!-- <div class="col-md-6">
            <label for="color" style="padding-bottom: 3px">
              {{__('color')}} :
            </label>
            <input type="text" name="_data[color]" class="form-control" placeholder="Ex: Silver">
          </div> -->

          <div class="col-md-6">
            <label for="mpn" style="padding-bottom: 3px">
              {{__('MPN')}} :
            </label>
            <input type="text" value="{{ $product->mpn ?? NULL }}" name="_data[mpn]" class="form-control" placeholder="Ex: ">
          </div>

          <div class="col-md-6">
            <label for="product_family" style="padding-bottom: 3px">
              {{__('Product Family')}} :
            </label>
            <input type="text" value="{{ $product->product_family ?? NULL }}" name="_data[product_family]" class="form-control" placeholder="Ex: MacBook Pro">
          </div>

          <div class="col-md-6">
            <label for="model" style="padding-bottom: 3px">
              {{__('Model')}} :
            </label>
            <input type="text" value="{{ $product->model ?? NULL }}" name="_data[model]" class="form-control" placeholder="Ex: MacBook Pro">
          </div>

          <div class="col-md-6">
            <label for="features" style="padding-bottom: 3px">
              {{__('Features')}} :
            </label>
            <input type="text" value="{{ $product->features ?? NULL }}" name="_data[features]" class="form-control" placeholder="Ex: ">
          </div>

          <div class="col-md-6">
            <label for="storage_type" style="padding-bottom: 3px">
              {{__('Storage Type')}} :
            </label>
            <input type="text" value="{{ $product->storage_type ?? NULL }}" name="_data[storage_type]" class="form-control" placeholder="Ex: HDD, SSD, SSHD, EMET e.t.c">
          </div>

        </div>
      </div>
    </div>
  </div>
</div>