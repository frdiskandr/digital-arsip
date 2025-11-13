<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Arsip;
use App\Models\Kategori;

class ArsipCustomTable extends Component
{
    use WithPagination;

    public $search = '';
    public $kategori = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'kategori' => ['except' => null],
    ];

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingKategori()
    {
        $this->resetPage();
    }

    // (no debug helpers)

    public function render()
    {
        $query = Arsip::with('kategori')
            ->when($this->search, fn($q) => $q->where('judul', 'like', '%' . $this->search . '%'))
            ->when($this->kategori, fn($q) => $q->where('kategori_id', $this->kategori))
            ->orderBy('created_at', 'desc');

        $arsips = $query->paginate(15);

        $kategoris = Kategori::orderBy('nama')->get();

        return view('livewire.arsip-custom-table', compact('arsips', 'kategoris'));
    }
}
