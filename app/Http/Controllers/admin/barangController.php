<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Barang; // Import the Barang model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class barangController extends Controller
{
    public function index()
    {
        // Paginate the results instead of using all()
        $barang = Barang::paginate(10); // Adjust the number per page as needed

        // Pass the $barang variable to the view
        return view('admin.barang.index', compact('barang'));
    }
    public function indexBarang()
    {
        // Paginate the results instead of using all()
        $barang = Barang::paginate(10); // Adjust the number per page as needed

        // Pass the $barang variable to the view
        return view('admin.barang.create', compact('barang'));
    }
    public function edit($id)
    {
        // Find the barang with the given ID
        $barang = Barang::findOrFail($id);

        // Pass the $barang variable to the view
        return view('admin.barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'nama_barang' => 'required|string',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'jumlah_kg' => 'required|numeric',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'nullable|date',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the Barang record
            $barang = Barang::findOrFail($id);

            // Update the Barang record
            $barang->update([
                'nama_barang' => $request->input('nama_barang'),
                'harga_beli' => $request->input('harga_beli'),
                'harga_jual' => $request->input('harga_jual'),
                'jumlah_kg' => $request->input('jumlah_kg'),
                'tanggal_masuk' => $request->input('tanggal_masuk'),
                'tanggal_kadaluarsa' => $request->input('tanggal_kadaluarsa'),
            ]);

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('barang.index')->with('success', 'Barang updated successfully');
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollBack();

            // Redirect with error message
            return redirect()->route('barang.index')->with('error', 'Failed to update barang. Please try again.');
        }
    }


    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nama_barang' => 'required|string',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'jumlah_kg' => 'required|numeric',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'nullable|date',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create a new barang record
            Barang::create([
                'nama_barang' => $request->input('nama_barang'),
                'harga_beli' => $request->input('harga_beli'),
                'harga_jual' => $request->input('harga_jual'),
                'jumlah_kg' => $request->input('jumlah_kg'),
                'tanggal_masuk' => $request->input('tanggal_masuk'),
                'tanggal_kadaluarsa' => $request->input('tanggal_kadaluarsa'),
            ]);

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('barang.index')->with('success', 'Barang added successfully');
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollBack();

            // Redirect with error message
            return redirect()->route('barang.index')->with('error', 'Failed to add barang. Please try again.');
        }
    }
    public function destroy($id)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the Barang record
            $barang = Barang::findOrFail($id);

            // Delete the Barang record
            $barang->delete();

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('barang.index')->with('success', 'Barang deleted successfully');
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollBack();

            // Redirect with error message
            return redirect()->route('barang.index')->with('error', 'Failed to delete barang. Please try again.');
        }
    }
   
}
