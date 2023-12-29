<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    // public function index()
    // {
    //     return view('konvey');
    // }

    public function sendAPI(Request $request)
    {

        // Load page afresh
        if($request->isMethod('get')) return view('konvey');
        
        // Validate prompt
        $request->validate([
            'prompt' => 'required'
        ]);
        
        // Prompt serialization
        $prompt = $request->prompt . ($request->tone ? " - Note: use \"{$request->tone}\" tone/style." : '');
        
        /**
         * GeminiAI Text-API
         * 
         * @prefix $g_ means gemini
         * 
         * 
         */
        $g_curl = curl_init();

        $g_data = array(
            "contents" => array(
                array(
                    "parts" => array(
                        array(
                            "text" => $prompt
                        )
                    )
                )
            )
        );

        $g_api_url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=".env('GEMINI_AI_API_KEY');
        
        $g_options = array(
            CURLOPT_URL => $g_api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($g_data),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        );

        curl_setopt_array($g_curl, $g_options);

        $geminiResponseData = curl_exec($g_curl);

        if ($geminiResponseData === false) {
            $g_error_msg = 'cURL error: ' . curl_error($g_curl);

            session()->flash('error', $g_error_msg);
            return view('konvey');
        }

        curl_close($g_curl);

        $geminiResponseData = json_decode($geminiResponseData, true);

        /** get the data content: */

        // Check if 'candidates' is set and not empty
        if (
            isset($geminiResponseData['candidates'][0]['content']['parts'][0]['text']) &&
            !empty($geminiResponseData['candidates'][0]['content']['parts'][0]['text'])
        ) {
            $geminiData = $geminiResponseData['candidates'][0]['content']['parts'][0]['text'];
        } else {
            session()->flash('error', 'Unable to access Prompt text');
            return view('konvey');
        }

        /**
         * Stability AI Text-to-Image
         * 
         * @prefix $d_ means diffusion
         */
        $d_curl = curl_init();

        $d_data = array(
            "steps"         => 30,
            "width"         => 1024,
            "height"        => 1024,
            "seed"          => 0,
            "cfg_scale"     => 7,
            "samples"       => 2,
            "text_prompts"  => array(
                array(
                    "text" => "Imagine: ".$request->prompt,
                    "weight" => 1
                )
            ),
        );

        $d_options = array(
            CURLOPT_URL => "https://api.stability.ai/v1/generation/stable-diffusion-xl-1024-v1-0/text-to-image",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($d_data),
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Authorization: Bearer ".env('STABILITY_AI_API_KEY'),
                "Content-Type: application/json"
            ),
        );

        curl_setopt_array($d_curl, $d_options);

        $diffusionResponseData = curl_exec($d_curl);

        if ($diffusionResponseData === false) {
            $g_error_msg = 'cURL error: ' . curl_error($d_curl);

            session()->flash('error', $g_error_msg);
            return view('konvey');
        }

        curl_close($d_curl);

        $diffusionResponseData = json_decode($diffusionResponseData, true);

        if (
            isset($diffusionResponseData['artifacts'][0]['base64']) &&
            !empty($diffusionResponseData['artifacts'][0]['base64'])
        ) {
            $diffusionImageOne = $diffusionResponseData['artifacts'][0]['base64'];
            $diffusionImageTwo = $diffusionResponseData['artifacts'][1]['base64'];
        } else {
            session()->flash('error', 'Unable to access Stability Diffusion');
            return view('konvey');
        }
        
        return view('konvey', compact('geminiData','diffusionImageOne','diffusionImageTwo'));
        
    }
}
