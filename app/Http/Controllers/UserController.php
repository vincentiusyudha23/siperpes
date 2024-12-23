<?php

namespace App\Http\Controllers;

use App\Models\Perumahan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        // dd(getLatLng(521712,9405067));
        return view('user.home');
    }

    public function login()
    {
        return view('user.login');
    }

    public function requestLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' => 'username harus diisi',
            'password.required' => 'password harus diisi'
        ]);

        try{
            if(Auth::attempt($request->only('username','password'))){
                return redirect()->route('user.dashboard');
            }

            return back()->withErrors([
                'error' => 'Username/Password Salah!'
            ])->withInput();

        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }

    public function dashboard()
    {
        $perumahans = Perumahan::orderBy('created_at', 'desc')->get();
        
        return view('user.dashboard', compact('perumahans'));
    }

    public function perumahan()
    {
        $perumahans = Perumahan::all();

        $geojsonData = DB::table('perumahans')
            ->select(DB::raw('ST_AsGeoJSON(geom) AS geojson, ST_AsGeoJSON(lnglat) as point, id, name_perum'))
            ->get();

        $markers = $geojsonData->transform(function($data){
            return [
                'id' => $data->id,
                'name' => $data->name_perum,
                'point' => json_decode($data->point, true),
                'polygon' => [
                    'type' => 'Feature',
                    'geometry' => json_decode($data->geojson, true)
                ]
            ];
        });

        return view('user.perumahan', compact('perumahans','markers'));
    }

    public function add_perum()
    {
        return view('user.add-perum');
    }

    public function req_get_lnglat(Request $request)
    {
        $request->validate([
            'east' => 'required',
            'nort' => 'required'
        ],[
            'east.required' => 'Easting (UTM) Harus Diisi!',
            'nort.required' => 'Northing (UTM) Harus Diisi!',
        ]);
        

        $data = getLatLng($request->east, $request->nort);
        
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function create_perum(Request $request)
    {
        $request->validate([
            'name_perum' => 'required',
            'name_pengembang' => 'required',
            'image' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'tahun_berdiri' => 'required',
            'jumlah_unit' => 'required',
            'easting' => 'required',
            'norting' => 'required',
            'polygon' => 'required'
        ]);
        
        try{

            $image = $request->image;
            $img_ex = $image->extension();
            $image_name_with_ext = $image->getClientOriginalName();

            $image_name = pathinfo($image_name_with_ext, PATHINFO_FILENAME);
            $image_name = strtolower(Str::slug($image_name));

            $image_db = $image_name.time().'.'.$img_ex;
            $folder_path = public_path('asset/img');;
            $image->move($folder_path, $image_db);

            $image_url = asset('asset/img/' . $image_db);

            $luasArea = DB::selectOne("
                SELECT ST_Area(
                    ST_Transform(
                        ST_SetSRID(ST_GeomFromGeoJSON(:polygon), 4326),
                        32748
                    )
                )::int as luas", 
                ['polygon' => $request->polygon]
            )->luas;

            $centroid = DB::selectOne("
                SELECT ST_X(ST_Centroid(ST_GeomFromGeoJSON(:polygon))) as lng,
                       ST_Y(ST_Centroid(ST_GeomFromGeoJSON(:polygon))) as lat",
                ['polygon' => $request->polygon]
            );

        
            Perumahan::create([
                'name_perum' => $request->name_perum,
                'name_pengembang' => $request->name_pengembang,
                'desa' => $request->desa,
                'kecamatan' => $request->kecamatan,
                'tahun_berdiri' => $request->tahun_berdiri,
                'jumlah_unit' => $request->jumlah_unit,
                'image' => $image_url,
                'easting' => $request->easting,
                'norting' => $request->norting,
                'geom' => DB::raw("ST_GeomFromGeoJSON('" . $request->polygon . "')"),
                'lnglat' => DB::raw("ST_SetSRID(ST_MakePoint({$centroid->lng}, {$centroid->lat}), 4326)"),
                'luas_perumahan' => $luasArea
            ]);

            return redirect()->route('user.perumahan')->with('success', 'Berhasil Menambahkan Perumahan.');

        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }

    public function getPerumahan($id)
    {
        $perumahan = Perumahan::find($id);

        if($perumahan){
            return response()->json([
                'status' => 'success',
                'markup' => View::make('user.markup.perum', ['perumahan' => $perumahan])->render()
            ]);
        }
    }
}
