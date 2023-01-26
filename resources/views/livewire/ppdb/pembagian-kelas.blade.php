@if (strpos(Config::get('ppdb'), Auth::user()->level) === false)
<script>window.location = "{{ route('index') }}";</script>
@endif
<div>
    <div class="row">
        <div class="col-lg-1 mb-1">
            <select wire:model='result' class="form-control">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col-lg-3 mb-1">
            <input type="text" wire:model='search' class="form-control" placeholder="Cari NISN">
        </div>
        <div class="col-lg-3 mb-1">
          <select class="form-control" wire:model="printkelas">
            <option value="">Pilih Kelas</option>
            @foreach ($kelas as $k)
                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
            @endforeach
          </select>
      </div>
      <div class="col-lg-3 mb-1">
        <a href="{{ route('printkelas',['id' => $printkelas]) }}" class="btn btn-primary" target="_blank">Print</a>
    </div>
    </div>

    @if(session('pesan'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
    {{session('pesan')}}
    </div>
    @endif

    @if(session('gagal'))
    <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Gagal!</h5>
    {{session('gagal')}}
    </div>
    @endif

        <table class="table table-responsive-md">
            <thead>
            <tr>
                <th>NISN</th>
                <th>Nama</th>
                <th>Uang Masuk</th>
                <th>Minat</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
                @if ($d->cicilan1 + $d->cicilan2 + $d->cicilan3 >= 1000000)
                <tr>
                    <td>{{ $d->nisn }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ "Rp. " . number_format($d->cicilan1+$d->cicilan2+$d->cicilan3, 2, ',', '.') }}</td>
                    <td>{{ $d->minat }}</td>
                    <td>{{ $d->nama_kelas }}</td>
                     <td><button type="button" class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#kelas" wire:click="kelas({{ $d->id_ppdb }})">
                      Pilih Kelas
                    </button>
                      </td>
                </tr>
                @endif
            @endforeach
        </tbody>
        </table>
        {{ $data->links() }}





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

      <!-- Modal Kelas -->
      <div wire:ignore.self class="modal fade" id="kelas">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pilih Kelas</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-group">
                      <label>Kelas</label>
                      <select class="form-control" wire:model="id_kelas">
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                      </select>
                      <div class="text-danger">
                        @error('id_kelas')
                            {{$message}}
                        @enderror
                    </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <div class="form-group">
                <button class="btn btn-danger btn-sm" wire:click="updateKelas()">Confirm</button>
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
                            <label>Username</label>
                            <input name="username" class="form-control" wire:model="username">
                            <div class="text-danger">
                                @error('username')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                          <label>Kode Guru</label>
                          <input name="kode_guru" class="form-control" wire:model="kode_guru">
                          <div class="text-danger">
                              @error('kode_guru')
                                  {{$message}}
                              @enderror
                          </div>
                      </div>
                        <div class="form-group">
                            <label>Nama Guru</label>
                            <input name="nama_guru" class="form-control" wire:model="nama_guru">
                            <div class="text-danger">
                                @error('nama_guru')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                          <label>No HP</label>
                          <input name="nohp_guru" class="form-control" wire:model="nohp_guru">
                          <div class="text-danger">
                              @error('nohp_guru')
                                  {{$message}}
                              @enderror
                          </div>
                      </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="custom-select form-control-border" wire:model="jk_guru">
                              <option value="">Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>

                            <div class="text-danger">
                                @error('jk_guru')
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
     $("#bayar").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#edit").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#delete").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#kelas").modal('hide');
    })

  </script>
    </div>

