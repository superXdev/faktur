<style>
    tbody {
        counter-reset: row;
    }

    tbody tr::before {
        counter-increment: row;
        content: counter(row) ".";
        position: relative;
        left: 30px;
        top: 17px;
    }
</style>
<div>
    {{-- Do your work, then step back. --}}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="">No Faktur</label>
                    <input disabled id="kodeFaktur" class="form-control" placeholder="-">
                </div>
                <div class="col-md-3">
                    <label for="">Tanggal</label>
                    <input disabled id="tanggal" class="form-control">
                </div>
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="">Outlet</label>
                    <select name="outlet" id="outlet" class="form-control">
                        <option value="">-- Silahkan Pilih Outet --</option>
                        @foreach ($outlet as $outlet)
                        <option value="{{ $outlet->id }}" data-price="{{$outlet->id}}">{{ $outlet->namaOutlet }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <label for="">Nama</label>
                    <input disabled type="text" class="form-control" placeholder="-" id="namaOutlet">
                </div>
                <div class="col-md-3">
                    <label for="">Jenis</label>
                    <input disabled type="text" class="form-control" placeholder="-" id="jenisOutlet">
                </div>
                <div class="col-md-6">
                    <label for="">Alamat</label>
                    <input disabled type="text" class="form-control" placeholder="-" id="alamatOutlet">
                </div>
            </div><br> <hr> <br>

             <div class="row">
                <div class="col-md-5">        
                    <label for="">Produk</label>
                    <select disabled name="goods" id="goods" class="form-control">
                        <option value="">-- Silahkan Pilih Produk --</option>
                    </select>
                </div>
                <div class="col-md-5">        
                    <label for="">Qty</label>
                    <input disabled name="qty" id="qty" type="number" class="form-control" placeholder="-"> 
                    <input hidden name="harga" id="harga" type="text" class="form-control" placeholder="-"> 
                </div>
                <div class="col-md-2">      
                    <br>
                    <button class="btn addRow"><i class="fa fa-plus"></i> Tambah</button>
                </div>
             </div>

             <br>

            <div class="table-responsive">
                <table class="table" id="tableGoods">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Item Barang</th>
                            <th scope="col">QTY</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah Harga</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div style="position: relative; left: 91%;">
                <button class="btn save" id="save"><i class="fa fa-save"></i> Simpan</button>
            </div>

            <!-- <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-1">
                    <p>Diskon</p>
                </div>
                <div class="col-md-3" style="margin-bottom: 10px">
                    <input wire:model="search" class="form-control form-control-sm" placeholder="Diskon">
                </div>
            </div>

            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-1">
                    <p>Retur</p>
                </div>
                <div class="col-md-3" style="margin-bottom: 10px">
                    <input wire:model="search" class="form-control form-control-sm" placeholder="Retur" style="border: 2px solid red;
  border-radius: 50px 20px;">
                </div>
            </div>

            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-1">
                    <p>Total</p>
                </div>
                <div class="col-md-3" style="margin-bottom: 10px">
                    <input wire:model="search" class="form-control form-control-sm" placeholder="Total">
                </div>
            </div> -->
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script language="JavaScript" type="text/JavaScript">

    let dataOutlet = null;
    let dataJenis = null;
    let dataBarang = null
    let hargaBarang = null

    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth();
    var year = date.getFullYear();

    var tanggal = day + "/" + month + "/" + year
    document.getElementById("tanggal").value = tanggal;

    var kofak = "FAK"
    var kodeFaktur = kofak + "/" + month + "/" + year
    document.getElementById("kodeFaktur").value = kodeFaktur;


    $('#outlet').on('change', function(e){

        $('#goods').attr("disabled", false);	
        $('#qty').attr("disabled", false);	
        $('#goods option[value != ""]').remove(); 
        $('#tableGoods tbody tr').remove();


        var id = $('#outlet option:selected').val()

        $.get('/faktur/' + id, function(data){
            dataOutlet = data;
            $.each(data, function(index, dataOutlet){        
                var namaOutlet = dataOutlet['namaOutlet'];
                var alamatOutlet = dataOutlet['alamat'];
                var jenisOutlet = dataOutlet['jenisOutlet'];
                
                $('#namaOutlet').val(namaOutlet);
                $('#alamatOutlet').val(alamatOutlet);
                $('#jenisOutlet').val(jenisOutlet);

                $.get('/fakturJenis/' + dataOutlet['jenisOutlet'], function(data){
                    dataJenis = data;
                    for(let i = 0; i < data.length; i++){
                        
                        $.get('/fakturGoods/' + data[i].goods_id, function(dataGoods){
                            $('#goods').append(`<option value="${dataGoods[0].id}">${dataGoods[0].namaBarang}</option>`);
                        });
                    }
                });
            });
        });
    });

    $('#goods').on('change', function(e){
        var idBarang = $('#goods option:selected').val()
        var cariHarga = dataJenis.filter(x => x.goods_id == idBarang)
        hargaBarang = cariHarga[0].hargaJual;
        $('#harga').val(hargaBarang);
    });

    $("#tableGoods").on("click", "#deleteRow", function() {
        $(this).closest("tr").remove();
    });

    $('.addRow').on('click', function() {
        addRow();
    });

    function addRow() {            

        var qty = $("#qty").val()
        var goods = $("#goods").val()
        var harga = $("#harga").val()

        var totalHarga = qty * harga
        var namaBarang = $('#goods option:selected').text()
        
        var tr = '<tr>' +
            '<td>' +
                '<label for="">'+ namaBarang +'</label>' +
            '</td>' +
            '<td>' +
                '<label for="">'+ qty +'</label>' +
            '</td>' +
            '<td>' +
                '<label for="">'+ harga +'</label>' +
            '</td>' +
            '<td>' +
                '<label for="">'+ totalHarga +'</label>' +
            '</td>' +
            '<td>' +
                '<button class="btn" id="deleteRow"><i class="fa fa-trash"></i></button>' +
            '</td>' +
            '</tr>';
        $('table tbody').append(tr).last();
        
        document.getElementById("qty").value = "";

    };

    $('#save').on('click', function(event) {
        
        var head = headJson();
        var detail = detailJson();
        console.log(head)
        console.log(detail)
    });

    function headJson() {
        var data = [];
        var head = {}
        
        head['kodeFaktur'] = $("#kodeFaktur").val()
        head['tanggal'] = $("#tanggal").val()

        data.push(head)
        return data;
    }

    function detailJson() {
        var json = '{';
        var otArr = [];
        var tbl2 = $('table tbody tr').each(function(e) {        
            x = $(this).children();
            var itArr = [];
            var keys = ['namaBarang','qty','harga','totalHarga'];
            x.each(function(i) {
                itArr.push('"' + keys[i] + '":"' + $(this).text() + '"');
            });
            otArr.push('"' + (e+1) + '": {' + itArr.join(',') + '}');
        })
        json += otArr.join(",") + '}'

        return json;
    }

</script>