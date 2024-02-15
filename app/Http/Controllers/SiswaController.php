<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
// use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;


class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /* tanpa pagination
        $siswa = Siswa::all();        
        return view('siswa.index01',compact('siswa'));
        */

        /* ada pagination */
        $siswa = Siswa::latest()->paginate(10);        
        return view('siswa.index',compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request;
        //validate form
        $this->validate($request, [
            'nama'    => 'required',
            'nis'     => 'required',
            'gender'  => 'required',
            'kelas'   => 'required|not_in:blank',
            'rombel'  => 'required',
            'foto'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);



        //upload image
        $foto = $request->file('foto');
        $foto->storeAs('public/foto_siswa', $foto->hashName());

        //create post
        Siswa::create([
            'nama'     => $request->nama,
            'nis'      => $request->nis,
            'gender'   => $request->gender,
            'kelas'    => $request->kelas,
            'rombel'   => $request->rombel,
            'foto'     => $foto->hashName()
        ]);

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $siswa = Siswa::find($id);

        //return $siswa;

        //return view
        return view('siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $akelas = array('blank'=>'Pilih Kelas',
                                    'X'=>'X - Sepuluh',
                                    'XI'=>'XI - Sebelas',
                                    'XII'=>'XII - Dua Belas',
                                    'XIII'=>'XIII - Tiga Belas'
                        );

        $siswa = Siswa::find($id);
        return view('siswa.edit', compact('siswa','akelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama'    => 'required',
            'nis'     => 'required',
            'gender'  => 'required',
            'kelas'   => 'required|not_in:blank',
            'rombel'  => 'required',
            'foto'    => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $siswa = Siswa::find($id);

        //check if image is uploaded
        if ($request->hasFile('foto')) {

            //upload new image
            $foto = $request->file('foto');
            $foto->storeAs('public/foto_siswa', $foto->hashName());

            //delete old image
            Storage::delete('public/foto_siswa/'.$siswa->foto);

            //update post with new image
            $siswa->update([
                'nama'    => $request->nama,
                'nis'     => $request->nis,
                'gender'  => $request->gender,
                'kelas'   => $request->kelas,
                'rombel'  => $request->rombel,
                'foto'    => $foto->hashName()
            ]);

        } else {

            //update post without image
            $siswa->update([
                'nama'    => $request->nama,
                'nis'     => $request->nis,
                'gender'  => $request->gender,
                'kelas'   => $request->kelas,
                'rombel'  => $request->rombel
            ]);
        }

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::find($id);
        //delete image
        Storage::delete('public/foto_siswa/'. $siswa->foto);

        //delete post
        $siswa->delete();

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
