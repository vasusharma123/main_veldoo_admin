<?php

namespace App\Http\Controllers\SpAdmin;

use App\Company;
use App\Http\Controllers\Controller;
use App\Setting;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class SettingsController extends Controller
{

    public function my_design()
    {
        $breadcrumb = array('title' => 'My design', 'action' => 'my_design');
        $data = [];
        $data = array_merge($breadcrumb, $data);
        $data['record'] = Setting::where(['key' => '_configuration', 'service_provider_id' => Auth::user()->id])->first();
        $data = array_merge($breadcrumb, $data);
        return view('admin.settings.my_design')->with($data);
    }

    public function update_my_design(Request $request)
	{
		DB::beginTransaction();
		try {
			$data = [];
            $settings = Setting::where(['service_provider_id' => Auth::user()->id])->first();
			if (!empty($request->submit) && $request->submit == 'default') {
                if (!empty($settings->logo)) {
                    Storage::disk('public')->delete($settings->logo);
                }
                if (!empty($settings->background_image)) {
                    Storage::disk('public')->delete($settings->background_image);
                }
				$data = ['ride_color' => '', 'logo' => '', 'background_image' => '', 'header_color' => '', 'header_font_family' => '', 'header_font_color' => '', 'header_font_size' => '', 'input_color' => '', 'input_font_family' => '', 'input_font_color' => '', 'input_font_size' => ''];
			} else {
				$data = ['ride_color' => $request->ride_color, 'header_color' => $request->header_color, 'header_font_family' => $request->header_font_family, 'header_font_color' => $request->header_font_color, 'header_font_size' => $request->header_font_size, 'input_color' => $request->input_color, 'input_font_family' => $request->input_font_family, 'input_font_color' => $request->input_font_color, 'input_font_size' => $request->input_font_size];
			}

			if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                if (!empty($settings->logo)) {
                    Storage::disk('public')->delete($settings->logo);
                }
				$imageName = 'logo-' . time() . '.' . $request->logo->extension();
				$image = Storage::disk('public')->putFileAs(
					'setting/' . Auth::user()->id,
					$request->logo,
					$imageName
				);
                $data['logo'] = $image;
			}
			if ($request->hasFile('background_image') && $request->file('background_image')->isValid()) {
				if (!empty($settings->background_image)) {
                    Storage::disk('public')->delete($settings->background_image);
                }
                $imageName = 'background-image-' . time() . '.' . $request->background_image->extension();
				$image = Storage::disk('public')->putFileAs(
					'setting/' . Auth::user()->id,
					$request->background_image,
					$imageName
				);
				$data['background_image'] = $image;
			}

            $settings->fill($data);
            $settings->save();

			DB::commit();
            if (!empty($request->submit) && $request->submit == 'default') {
                $successMessage = 'Information reset successfully!';
            } else {
                $successMessage = 'Information updated successfully!';
            }
            return redirect()->back()->with('success', $successMessage);
		} catch (Exception $exception) {
			DB::rollBack();
			return back()->with('error', $exception->getMessage());
		}
	}

}
