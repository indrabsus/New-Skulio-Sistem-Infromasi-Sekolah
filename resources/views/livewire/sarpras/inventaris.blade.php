<div>
    <div class="row">
        <div class="col-lg-2"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add">
            Tambah Data
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
            <input type="text" wire:model='search' class="form-control" placeholder="Cari Nama Barang">
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
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tempat</th>
                <th>Sumber</th>
                <th>Keterangan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; ?>
            @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nama_barang }}</td>
                <td>{{ $d->jumlah_barang }}</td>
                <td>{{ $d->tempat_barang }}</td>
                <td>{{ $d->sumber_barang }}</td>
                <td>{{ $d->keterangan }}</td>
                <td>@if ($d->tanggal != NULL)
                    {{ \Carbon\Carbon::parse($d->tanggal)->translatedFormat('l, d F Y') }}
                @endif</td>
                <td><button class="btn btn-success btn-sm" wire:click="edit({{$d->id_barang}})" data-toggle="modal" data-target="#edit">Edit</button> <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete" wire:click="konfirmasiHapus({{$d->id_barang}})">Delete</button></td>
            </tr>
            @endforeach
        </tbody>
        </table>
        {{ $data->links() }}


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
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <input name="nama_barang" class="form-control" value="{{old('nama_barang')}}" wire:model="nama_barang">
                                <div class="text-danger">
                                    @error('nama_barang')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Jumlah</label>
                                <input name="jumlah_barang" class="form-control" value="{{old('jumlah_barang')}}" wire:model="jumlah_barang">
                                <div class="text-danger">
                                    @error('jumlah_barang')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                              <label>Tempat</label>
                              <input name="tempat_barang" class="form-control" value="{{old('tempat_barang')}}" wire:model="tempat_barang">
                              <div class="text-danger">
                                  @error('tempat_barang')
                                      {{$message}}
                                  @enderror
                              </div>
                          </div>
                          <div class="form-group">
                            <label>Sumber Barang</label>
                            <input name="sumber_barang" class="form-control" value="{{old('sumber_barang')}}" wire:model="sumber_barang">
                            <div class="text-danger">
                                @error('sumber_barang')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Keterangan Barang</label>
                            <select class="form-control" wire:model="keterangan">
                                <option value="">Pilih Keterangan</option>
                                <option value="masuk">Masuk</option>
                                <option value="keluar">Keluar</option>
                            </select>
                            <div class="text-danger">
                                @error('keterangan')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" wire:model="tanggal">
                            <div class="text-danger">
                                @error('tanggal')
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
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input name="nama_barang" class="form-control" value="{{old('nama_barang')}}" wire:model="nama_barang">
                            <div class="text-danger">
                                @error('nama_barang')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jumlah</label>
                            <input name="jumlah_barang" class="form-control" value="{{old('jumlah_barang')}}" wire:model="jumlah_barang">
                            <div class="text-danger">
                                @error('jumlah_barang')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                          <label>Tempat</label>
                          <input name="tempat_barang" class="form-control" value="{{old('tempat_barang')}}" wire:model="tempat_barang">
                          <div class="text-danger">
                              @error('tempat_barang')
                                  {{$message}}
                              @enderror
                          </div>
                      </div>
                      <div class="form-group">
                        <label>Sumber Barang</label>
                        <input name="sumber_barang" class="form-control" value="{{old('sumber_barang')}}" wire:model="sumber_barang">
                        <div class="text-danger">
                            @error('sumber_barang')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keterangan Barang</label>
                        <select class="form-control" wire:model="keterangan">
                            <option value="">Pilih Keterangan</option>
                            <option value="masuk">Masuk</option>
                            <option value="keluar">Keluar</option>
                        </select>
                        <div class="text-danger">
                            @error('keterangan')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" wire:model="tanggal">
                        <div class="text-danger">
                            @error('tanggal')
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

  </script>
    </div>

