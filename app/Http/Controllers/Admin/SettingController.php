<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $query = Setting::query();
        $settings = $query->paginate();
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.settings_table', compact('settings'))->render()
            ]);
        }
        return view('admin.settings', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'website_name' => 'required|string|max:255',
            'footer_desc' => 'required|string|max:255',
            'website_logo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        
        try {
            $imagePath = $request->file('website_logo')->store('website_logo', 'public');

            $setting = Setting::create([
                'website_name' => $request->website_name,
                'footer_desc' => $request->footer_desc,
                'website_logo' => basename($imagePath)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Setting added successfully',
                'data' => $setting
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating setting: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Setting $setting)
    {
        return response()->json([
            'success' => true,
            'data' => $setting
        ]);
    }

    public function edit(Setting $setting)
    {
        return response()->json([
            'success' => true,
            'data' => $setting
        ]);
    }

    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'website_name' => 'required|string|max:255',
            'footer_desc' => 'required|string',
            'website_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        
        try {
            $setting->website_name = $request->website_name;
            $setting->footer_desc = $request->footer_desc;
            
            if ($request->hasFile('website_logo')) {
                // Delete old image
                $oldImagePath = str_replace('website_logo/', '', $setting->website_logo);
                Storage::disk('public')->delete('website_logo/' . $oldImagePath);
                
                // Store new image
                $imagePath = $request->file('website_logo')->store('website_logo', 'public');
                $setting->website_logo = $imagePath;
            }
            
            $setting->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Setting updated successfully',
                'data' => $setting
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating setting: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Setting $setting)
    {
        try {
            // Delete associated image
            $imagePath = str_replace('website_logo/', '', $setting->website_logo);
            Storage::disk('public')->delete('website_logo/' . $imagePath);
            
            $setting->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Setting deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting setting: ' . $e->getMessage()
            ], 500);
        }
    }
}