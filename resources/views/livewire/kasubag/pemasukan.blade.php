<div>
    <div class="row">
        <div class="col-lg-2"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add">
            Tambah Pemasukan
          </button></div>
        <div class="col-lg-1 mb-1">
            <select wire:model='result' class="form-control">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col-lg-3 mb-1">
            <input type="text" wire:model='search' class="form-control" placeholder="Cari Nama Pemasukan">
        </div>
        <div class="col-lg-3 mb-1">
            <input type="date" class="form-control" wire:model="cari_tahun">
        </div>
    </div>

    @if(session('pesan'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
    {{session('pesan')}}
    </div>
    @endif

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemasukan</th>
                <th>Biaya</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; ?>
            @foreach ($vcredit as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nama_credit }}</td>
                <td>Rp. {{ number_format($d->biaya_credit,2,',','.') }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tahun_credit)->translatedFormat('l, d F Y') }}</td>
                <td><button class="btn btn-success btn-sm" wire:click="edit({{$d->id_credit}})" data-toggle="modal" data-target="#edit">Edit</button> <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete" wire:click="konfirmasiHapus({{$d->id_credit}})">Delete</button></td>
            </tr>
            @endforeach
        </tbody>
        </table>
        {{ $vcredit->links() }}

    <div class="container"><h6>Jumlah Pemasukan : Rp. {{number_format($credit,2,',','.')}}</h6></div>
    <div class="container"><h6>Jumlah Pengeluaran : Rp. {{number_format($debit,2,',','.')}}</h6></div>
    <div class="container"><h4>TOTAL : Rp. {{number_format(($credit-$debit),2,',','.')}}</h4></div>

      <!-- Modal EDIT USER -->
      <div wire:ignore.self class="modal fade" id="edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="container">
                <form>
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nama Pemasukan</label>
                            <input name="nama_credit" class="form-control" value="{{old('nama_credit')}}" wire:model="nama_credit">
                            <div class="text-danger">
                                @error('nama_credit')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jumlah</label>
                            <input name="biaya_credit" class="form-control" value="{{old('biaya_credit')}}" wire:model="biaya_credit">
                            <div class="text-danger">
                                @error('biaya_credit')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" id="date" wire:model="tahun_credit" class="form-control">
                            <div class="text-danger">
                                @error('tahun_credit')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <div class="form-group">
                <button class="btn btn-primary btn-sm" wire:click.prevent="update()">Simpan</button>
              </form>
            </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <!-- Modal Delete USER -->
      <div wire:ignore.self class="modal fade" id="delete">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Hapus User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    Apakah anda yakin untuk menghapus user ini?

                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <div class="form-group">
                <button class="btn btn-danger btn-sm" wire:click="delete()">Hapus</button>
            </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- Modal ADD USER -->
  <div wire:ignore.self class="modal fade" id="add">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <form>
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Nama Pemasukan</label>
                        <input name="nama_credit" class="form-control" value="{{old('nama_credit')}}" wire:model="nama_credit">
                        <div class="text-danger">
                            @error('nama_credit')
                                {{$message}}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Jumlah</label>
                        <input name="biaya_credit" class="form-control" value="{{old('biaya_credit')}}" wire:model="biaya_credit">
                        <div class="text-danger">
                            @error('biaya_credit')
                                {{$message}}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" id="date" wire:model="tahun_credit" class="form-control">
                        <div class="text-danger">
                            @error('tahun_credit')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <div class="form-group">
            <button class="btn btn-primary btn-sm" wire:click.prevent="create()" id="tambahclose">Simpan</button>
          </form>
        </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <script>
    window.addEventListener('closeModal', event => {
     $("#add").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#edit").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#delete").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#reset").modal('hide');
    })

  </script>
    </div>

