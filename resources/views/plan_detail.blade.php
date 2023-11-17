@extends('master_admin.layouts.plans')
@section('content')
<section class="addEditForm sectionsform">
            <article class="container-fluid">
                <!-- <form action="{{ route('updateServiceProvider') }}" method="POST" enctype="multipart/form-data" class="custom_form editForm company_edit" id="Editcompany">
                    @csrf -->
                    <div class="row w-100 m-0 form_inside_row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row w-100 m-0">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <?php //dd($data); ?>
                                        <input type="text" class="form-control inputText" id="name" name="name" value="{{ $data['user']['name'] }}" placeholder="Service provider" />
                                        <label for="name">Enter service provider name</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control inputText" id="name" name="name" value="{{ Auth::user()->name }}" placeholder="Name" />
                                        <label for="name">Enter admin name</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control inputText" id="name" name="name" value="{{ Auth::user()->first_name }}" placeholder="Surname" />
                                        <label for="name">Enter admin surname</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <input type="tel" class="form-control inputText" id="phone1" value="{{ Auth::user()->phone }}"  name="phone1" placeholder="1234" />
                                        <label for="phone1">Example: +41 123 456 7899</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control inputText" id="email" value="{{ Auth::user()->email }}" name="email" placeholder="company@email-address.com" />
                                        <label for="email">Example: admin@email-address.com</label>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control inputText" id="address" name="address"  value="{{ $data['user']['street']}}" placeholder="Street" />
                                        <label for="address">Enter service street</label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control inputText" id="postcode" name="postcode" value="{{ $data['user']['zip']}}"  placeholder="Enter Post Code" />
                                        <label for="postcode">Enter service post code</label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control inputText" id="usercity" name="usercity" value="{{ $data['user']['city']}}"  placeholder="Enter City" />
                                        <label for="usercity">Enter service city</label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control inputText" id="usercountry" name="usercountry" value="{{ $data['user']['country']}}" placeholder="Enter Country" />
                                        <label for="usercountry">Enter service country</label>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <!-- <div class="form_btn text-end mobile_margin">
                                <button type="submit" form="updateForm" class="btn save_form_btn">Update Changes</button>
                        </div> -->
                    </div>
                </form>
            </article>
        </section>

@endsection