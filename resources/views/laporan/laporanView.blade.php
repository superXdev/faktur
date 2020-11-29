<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Daftar Outlet') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">Daftar Outlet</div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><strong>Tambah Laporan</strong></h3>
                    <form  action="{{ route('laporan.index') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="namaOutlet">Nama Outlet</label>
                            <select class="form-control form-control-sm ok" name="jenisOutlet">
                                <option value="" selected=""> -- Nama Outlet --</option>
                                @foreach ($outlet as $outlet)
                                <option value="{{$outlet->namaOutlet}}">{{$outlet->namaOutlet}}</option>
                                @endforeach
                               
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Periode</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                  <input type="radio" name="value" value="50" class="selectgroup-input" checked="">
                                  <span class="selectgroup-button">S</span>
                                </label>
                                <label class="selectgroup-item">
                                  <input type="radio" name="value" value="100" class="selectgroup-input">
                                  <span class="selectgroup-button">M</span>
                                </label>
                                <label class="selectgroup-item">
                                  <input type="radio" name="value" value="150" class="selectgroup-input">
                                  <span class="selectgroup-button">L</span>
                                </label>
                                <label class="selectgroup-item">
                                  <input type="radio" name="value" value="200" class="selectgroup-input">
                                  <span class="selectgroup-button">XL</span>
                                </label>
                              </div>
                        </div>
                       
                        <div class="text-center">
                            <button type="submit" class="btn btn-info btn-sm" name="search">Submit</button>
                            <button type="submit" class="btn btn-warning btn-sm" name="exportPDF">export PDF</button>
                       
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Nama Outlet</th>
                                <th scope="col">invoice</th>
                                <th scope="col">total</th>
                                <th scope="col">HPP</th>
                                <th scope="col">Laba</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            @foreach ($ViewsPage as $V)
                                <tr>
                                    <td>{{ $V->namaOutlet }}</td>
                                    <td>{{ $V->invoice }}</td>
                                    <td>{{ $V->grandTotal }}</td>
                                    <td>{{ $V->HPP }}</td>
                                    <td>{{ $V->laba }}</td>
                                    
                                </tr>
                                @endforeach
                              
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
