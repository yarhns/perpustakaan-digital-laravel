<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
        public function index(Request $request)
    {
        $query = Member::query();

        // Logika Pencarian Anggota
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('npm', 'like', "%{$search}%");
        }

        $members = $query->latest()->get();
        
        return view('members.index', compact('members'));
    }

    public function store(Request $request)
    {
                if (session('is_demo')) {
            return back()->with('demo_error', 'Mode Demo: Anda tidak diizinkan menyimpan, mengubah, atau menghapus data.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'npm' => 'required|string|unique:members,npm|max:20',
            'prodi' => 'required|string|max:100',
        ]);
        

        Member::create($request->all());
        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
                if (session('is_demo')) {
            return back()->with('demo_error', 'Mode Demo: Anda tidak diizinkan menyimpan, mengubah, atau menghapus data.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'npm' => 'required|string|max:20|unique:members,npm,' . $id,
            'prodi' => 'required|string|max:100',
        ]);

        $member = Member::findOrFail($id);
        $member->update($request->all());
        
        return redirect()->route('members.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy($id)
    {
                if (session('is_demo')) {
            return back()->with('demo_error', 'Mode Demo: Anda tidak diizinkan menyimpan, mengubah, atau menghapus data.');
        }
        $member = Member::findOrFail($id);
        $member->delete();
        
        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus!');
    }
}