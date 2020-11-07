<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Barang') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('barang.index') }}">Daftar Barang</a></div>
            <div class="breadcrumb-item active">Data Barang</div>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="h2">
                        {{ $data->namaBarang }} - {{ $data->kodeBarang }}
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="h5 mt-4">
                                Harga Modal : @currency($data->hargaModal)
                            </div>
                            <div class="h5 mt-4">
                                Satuan : {{ $data->satuan }}
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="h5 mt-4">
                                Minimal Stok : {{ $data->minStok }}
                            </div>
                            <div class="h5 mt-4">
                                @if( $data->stok === null)
                                    Stok : <strong style="color: red">Stok Kosong</strong>
                                @else
                                    Stok : {{ $data->stok }}
                                @endif
                            </div>
                        </div>
                        <div class="text-center">
                            <a class="btn btn-info" href="{{ route('barang.edit', $data->slug) }}">Perbarui</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <livewire:harga-per-jenis.add-harga-barang :data="$data" />
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <livewire:harga-per-jenis.list-harga-barang :data="$data"/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
