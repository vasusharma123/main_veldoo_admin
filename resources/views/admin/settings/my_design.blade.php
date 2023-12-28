@extends('admin.layouts.master')

@section('content')
<main class="body_content">
    <div class="inside_body">
        <div class="container-fluid p-0">
            <div class="row m-0 w-100">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
                    <div class="body_flow">
                        @include('admin.layouts.sidebar')

                        <div class="formTableContent">

                            <section class="addonTable sectionsform ">
                                <form class="container-fluid" method="POST" action="{{ route('settings.update_my_design') }}" enctype="multipart/form-data">
									@csrf
                                    <div class="row w-100 m-0">
                                        <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                                            <div class="oneSection">

                                                <h4 class="sideHeader ms-2">Header</h4>
                                                <div class="all_updateform">
                                                    <div class="otpoptions">
                                                        <label>Color</label>
                                                        <div class="colorpikerbox position-relative">
                                                            <input type="color" name="header_color" value="{{ !empty($record->header_color) ? $record->header_color  : '#FC4C02' }}" class="form-control clrpickers" />
                                                            <span class="clrselected"></span>
                                                        </div>
                                                    </div>
                                                    <div class="otpoptions">
                                                        <label>Font</label>
                                                        <select class="form-select fontselection" name="header_font_family">
                                                            <option value="" disabled>Select Font</option>
                                                            <option style="font-family:Oswald" value="Oswald" {{ $record->header_font_family == 'Oswald' ? "selected" : ''}}> Oswald</option>
                                                            <option style="font-family:Times-new-roman" value="Times-new-roman" {{ $record->header_font_family == 'Times-new-roman' ? "selected" : ''}}> Times New Roman</option>
                                                            <option style="font-family:Arial" value="Arial" {{ $record->header_font_family == 'Arial' ? "selected" : ''}}>Arial</option>
                                                            <option style="font-family:Algerian" value="Algerian" {{ $record->header_font_family == 'Algerian' ? "selected" : ''}}>Algerian</option>
                                                            <option style="font-family:Berlin-sans-fb" value="Berlin-sans-fb" {{ $record->header_font_family == 'Berlin-sans-fb' ? "selected" : ''}}>Berlin Sans FB</option>
                                                            <option style="font-family:Fantasy" value="Fantasy" {{ $record->header_font_family == 'Fantasy' ? "selected" : ''}}>Fantasy</option>
                                                            <option style="font-family:Cursive" value="Cursive" {{ $record->header_font_family == 'Cursive' ? "selected" : ''}}>cursive</option>
                                                            <option style="font-family:Verdana" value="Verdana" {{ $record->header_font_family == 'Verdana' ? "selected" : ''}}>Verdana</option>
                                                            <option style="font-family:Fearless" value="Fearless" {{ $record->header_font_family == 'Fearless' ? "selected" : ''}}>Fearless</option>
                                                            <option style="font-family:Georgia" value="Georgia" {{ $record->header_font_family == 'Georgia' ? "selected" : ''}}>Georgia</option>
                                                            <option style="font-family:Calibri" value="Calibri" {{ $record->header_font_family == 'Calibri' ? "selected" : ''}}>Calibri</option>
                                                            <option style="font-family:Helvetica" value="Helvetica" {{ $record->header_font_family == 'Helvetica' ? "selected" : ''}}>Helvetica</option>
                                                            <option style="font-family:Palatino" value="Palatino" {{ $record->header_font_family == 'Palatino' ? "selected" : ''}}>Palatino</option>
                                                            <option style="font-family:Cambria" value="Cambria" {{ $record->header_font_family == 'Cambria' ? "selected" : ''}}>Cambria</option>
                                                            <option style="font-family:Garamond" value="Garamond" {{ $record->header_font_family == 'Garamond' ? "selected" : ''}}>Garamond</option>
                                                            <option style="font-family:Comic Sans MS" value="Comic Sans MS" {{ $record->header_font_family == 'Comic Sans MS' ? "selected" : ''}}>Comic Sans MS</option>
                                                            <option style="font-family:Copperplate Gothic" value="Copperplate Gothic" {{ $record->header_font_family == 'Copperplate Gothic' ? "selected" : ''}}>Copperplate Gothic</option>
                                                            <option style="font-family:Optima" value="Optima" {{ $record->header_font_family == 'Optima' ? "selected" : ''}}>Optima</option>
                                                            <option style="font-family:Trebuchet MS" value="Trebuchet MS" {{ $record->header_font_family == 'Trebuchet MS' ? "selected" : ''}}>Trebuchet MS</option>
															<option style="font-family:'Roboto', sans-serif" value="'Roboto', sans-serif" {{ $record->header_font_family == "'Roboto', sans-serif" ? "selected" : ''}}>'Roboto', sans-serif</option>
                                                        </select>
                                                    </div>
                                                    <div class="otpoptions">
                                                        <label>Font Color</label>
                                                        <div class="colorpikerbox position-relative">
                                                            <input name="header_font_color" type="color" class="form-control clrpickers"  value="{{ !empty($record->header_font_color) ? $record->header_font_color  : '#FFFFFF' }}"/>
                                                            <span class="clrselected"></span>
                                                        </div>
                                                    </div>
                                                    <div class="otpoptions">
                                                        <label>Font Size</label>
                                                        <input type="number"  name="header_font_size" min="12" max="22" class="form-select fontselection" value="{{ !empty($record->header_font_size) ? $record->header_font_size  : '16' }}">
                                                    </div>
                                                    <div class="otpoptions">
                                                        <label>Logo</label>
                                                        <div class="colorpikerbox position-relative">
                                                            <input type="file" name="logo" class="form-control filepicker" id="input_logo"/>
															@if (!empty($record->logo) && file_exists('storage/'.$record->logo))
                                                            <img src="{{ env('URL_PUBLIC').'/'.$record->logo }}" class="previewImg img-fluid" alt="img-preview" id="preview_logo"/>
															@else
															<img src="{{ asset('assets/images/veldoo/uploaded.png')}}" class="previewImg img-fluid" alt="img-preview" id="preview_logo"/>
															@endif
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="SecSection mt-4">

                                                <h4 class="sideHeader ms-2">Input Field</h4>
                                                <div class="all_updateform">
                                                    <div class="otpoptions">
                                                        <label>Color</label>
                                                        <div class="colorpikerbox position-relative">
                                                            <input type="color" class="form-control clrpickers" name="input_color" value="{{ !empty($record->input_color) ? $record->input_color  : '#F9F9F9' }}"/>
                                                            <span class="clrselected"></span>
                                                        </div>
                                                    </div>
                                                    <div class="otpoptions">
                                                        <label>Font</label>
                                                        <select class="form-select fontselection" name="input_font_family">
                                                            <option value="" disabled>Select Font</option>
                                                            <option style="font-family:Oswald" value="Oswald" {{ $record->input_font_family == 'Oswald' ? "selected" : ''}}> Oswald</option>
                                                            <option style="font-family:Times-new-roman" value="Times-new-roman" {{ $record->input_font_family == 'Times-new-roman' ? "selected" : ''}}> Times New Roman</option>
                                                            <option style="font-family:Arial" value="Arial" {{ $record->input_font_family == 'Arial' ? "selected" : ''}}>Arial</option>
                                                            <option style="font-family:Algerian" value="Algerian" {{ $record->input_font_family == 'Algerian' ? "selected" : ''}}>Algerian</option>
                                                            <option style="font-family:Berlin-sans-fb" value="Berlin-sans-fb" {{ $record->input_font_family == 'Berlin-sans-fb' ? "selected" : ''}}>Berlin Sans FB</option>
                                                            <option style="font-family:Fantasy" value="Fantasy" {{ $record->input_font_family == 'Fantasy' ? "selected" : ''}}>Fantasy</option>
                                                            <option style="font-family:Cursive" value="Cursive" {{ $record->input_font_family == 'Cursive' ? "selected" : ''}}>cursive</option>
                                                            <option style="font-family:Verdana" value="Verdana" {{ $record->input_font_family == 'Verdana' ? "selected" : ''}}>Verdana</option>
                                                            <option style="font-family:Fearless" value="Fearless" {{ $record->input_font_family == 'Fearless' ? "selected" : ''}}>Fearless</option>
                                                            <option style="font-family:Georgia" value="Georgia" {{ $record->input_font_family == 'Georgia' ? "selected" : ''}}>Georgia</option>
                                                            <option style="font-family:Calibri" value="Calibri" {{ $record->input_font_family == 'Calibri' ? "selected" : ''}}>Calibri</option>
                                                            <option style="font-family:Helvetica" value="Helvetica" {{ $record->input_font_family == 'Helvetica' ? "selected" : ''}}>Helvetica</option>
                                                            <option style="font-family:Palatino" value="Palatino" {{ $record->input_font_family == 'Palatino' ? "selected" : ''}}>Palatino</option>
                                                            <option style="font-family:Cambria" value="Cambria" {{ $record->input_font_family == 'Cambria' ? "selected" : ''}}>Cambria</option>
                                                            <option style="font-family:Garamond" value="Garamond" {{ $record->input_font_family == 'Garamond' ? "selected" : ''}}>Garamond</option>
                                                            <option style="font-family:Comic Sans MS" value="Comic Sans MS" {{ $record->input_font_family == 'Comic Sans MS' ? "selected" : ''}}>Comic Sans MS</option>
                                                            <option style="font-family:Copperplate Gothic" value="Copperplate Gothic" {{ $record->input_font_family == 'Copperplate Gothic' ? "selected" : ''}}>Copperplate Gothic</option>
                                                            <option style="font-family:Optima" value="Optima" {{ $record->input_font_family == 'Optima' ? "selected" : ''}}>Optima</option>
                                                            <option style="font-family:Trebuchet MS" value="Trebuchet MS" {{ $record->input_font_family == 'Trebuchet MS' ? "selected" : ''}}>Trebuchet MS</option>
															<option style="font-family:'Roboto', sans-serif" value="'Roboto', sans-serif" {{ $record->input_font_family == "'Roboto', sans-serif" ? "selected" : ''}}>'Roboto', sans-serif</option>
                                                        </select>
                                                    </div>
                                                    <div class="otpoptions">
                                                        <label>Font Color</label>
                                                        <div class="colorpikerbox position-relative">
                                                            <input type="color" name="input_font_color" class="form-control clrpickers" value="{{ !empty($record->input_font_color) ? $record->input_font_color  : '#666666' }}" />
                                                            <span class="clrselected"></span>
                                                        </div>
                                                    </div>
                                                    <div class="otpoptions">
                                                        <label>Font Size</label>
                                                        <input type="number" name="input_font_size" min="12" max="22" class="form-select fontselection" value="{{ !empty($record->input_font_size) ? $record->input_font_size  : '16' }}">
                                                    </div>
                                                    <div class="otpoptions">
                                                        <label>Ride Color</label>
                                                        <div class="colorpikerbox position-relative">
                                                            <input type="color" name="ride_color" class="form-control clrpickers" value="{{ !empty($record->ride_color) ? $record->ride_color  : '#356681' }}"/>
                                                            <span class="clrselected"></span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                            <div class="oneSection ">

                                                <h4 class="sideHeader ms-2">Background</h4>
                                                <div class="newlefttheme text-center">
                                                    <label>Theme</label>
                                                    <div class="colorpikerbox position-relative">
                                                        <input type="file" name="background_image" class="form-control filepicker" id="input_background_image"/>
														@if (!empty($record->background_image) && file_exists('storage/'.$record->background_image))
                                                            <img src="{{ env('URL_PUBLIC').'/'.$record->background_image }}" class="previewImgFull img-fluid" alt="img-preview" id="preview_background_image" />
															@else
															<img src="{{ asset('assets/images/veldoo/uploaded.png')}}" class="previewImgFull img-fluid" alt="img-preview" id="preview_background_image" />
															@endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <button type="submit" name="submit" value="default" class="btn submit_btn darkBtn mt-2 w-100">Default</button>
                                                <button type="submit" name="submit" value="dfdf" class="btn submit_btn mt-2 ms-2 w-100">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('footer_scripts')
<script>
    $(document).on('change', '#input_logo', function(e) {
        var file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_logo').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

	$(document).on('change', '#input_background_image', function(e) {
        var file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_background_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

</script>

@stop
