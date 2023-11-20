@extends('master_admin.layouts.plans')
@section('content')
<div class="row m-0 w-100">
    <div class="col-lg-7 col-md-7 col-sm-12 col-12">
        <section class="addEditForm sectionsform">
                <article class="container-fluid">
                        <form class="custom_form editForm company_edit" id="Editcompany">
                        <div class="row w-100 m-0 form_inside_row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row w-100 m-0">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <?php //dd($data); ?>
                                            <input type="text" class="form-control inputText" id="name" name="name" value="{{ $data['user']['name'] }}" placeholder="Service provider" readonly />
                                            <label for="name">Service provider name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control inputText" id="name" name="name" value="{{ $data['user']['first_name'] }}" placeholder="Name"  readonly/>
                                            <label for="name">Service provider first name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control inputText" id="name" name="name" value="{{ $data['user']['last_name']  }}" placeholder="Surname" readonly/>
                                            <label for="name">Service provider last Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="tel" class="form-control inputText" id="phone1" value="{{ $data['user']['phone']  }}"  name="phone1"  readonly/>
                                            <label for="phone1">Phone Number</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="email" class="form-control inputText" id="email" value="{{ $data['user']['email'] }}" name="email"  readonly/>
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control inputText" id="address" name="address"  value="{{ $data['user']['street']}}"  readonly />
                                            <label for="address">Service street</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control inputText" id="postcode" name="postcode" value="{{ $data['user']['zip']}}"   readonly />
                                            <label for="postcode">Service post code</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control inputText" id="usercity" name="usercity" value="{{ $data['user']['city']}}"   readonly />
                                            <label for="usercity">Service city</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control inputText" id="usercountry" name="usercountry" value="{{ $data['user']['country']}}"  readonly />
                                            <label for="usercountry">Service country</label>
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
    </div>
</div>
@endsection