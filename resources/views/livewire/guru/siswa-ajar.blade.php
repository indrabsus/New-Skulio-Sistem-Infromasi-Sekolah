@if (strpos(Config::get('guru'), Auth::user()->level) === false)
<script>window.location = "{{ route('index') }}";</script>
@endif
<div>
    <div class="row">
        <div class="col-lg-3">
            <button class="btn btn-success btn-sm mb-1"  data-toggle="modal" data-target="#tugas">Kirim Tugas</button>
        </div>
        <div class="col-lg-1 mb-1">
            <select wire:model='result' class="form-control">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col-lg-3 mb-1">
            <input type="text" wire:model='search' class="form-control" placeholder="Cari Nama Kelas">
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
                <th>Nama Tugas</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Batas Pengumpulan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; ?>
            @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nama_tugas }}</td>
                <td>{{ $d->nama_mapel }}</td>
                <td>{{ $d->nama_kelas }}</td>
                <td>{{ \Carbon\Carbon::parse($d->akhir)->translatedFormat('l, d F Y h:i') }}</td>
                <td><button class="btn btn-success btn-sm mb-1" wire:click="edit({{$d->id_tugas}})" data-toggle="modal" data-target="#edit">Edit</button> <button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#delete" wire:click="konfirmasiHapus({{$d->id_tugas}})">Delete</button></td>

                </tr>
            @endforeach
        </tbody>
        </table>
        {{ $data->links() }}

      <!-- Modal EDIT USER -->
      <div wire:ignore.self class="modal fade" id="tugas">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Kirim Tugas Kelas {{ $nama_kelas }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="container">
                <form>
                @csrf
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                                @foreach ($gurumapel as $g)
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="tugas" value="{{ $g->id_ajar }}">
                                <label class="form-check-label">{{ $g->nama_kelas }} {{ $g->nama_mapel }}</label>
                            </div>
                                @endforeach


                            <div class="text-danger">
                                @error('tugas')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Tugas</label>
                            <input class="form-control" wire:model="nama_tugas">
                            <div class="text-danger">
                                @error('nama_tugas')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control" wire:model="deskripsi"></textarea>
                            <div class="text-danger">
                                @error('deskripsi')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Batas Pengumpulan</label>
                            <input type="datetime-local" id="date" wire:model="akhir" class="form-control">
                            <div class="text-danger">
                                @error('akhir')
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
                <button class="btn btn-primary btn-sm" wire:click.prevent="kirim()">Simpan</button>
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


  <div wire:ignore.self class="modal fade" id="edit">
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
                <div class="col-sm">
                    <div class="form-group">
                        <label>Nama Tugas</label>
                        <input class="form-control" wire:model="nama_tugas">
                        <div class="text-danger">
                            @error('nama_tugas')
                                {{$message}}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" wire:model="deskripsi"></textarea>
                        <div class="text-danger">
                            @error('deskripsi')
                                {{$message}}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Batas Pengumpulan</label>
                        <input type="datetime-local" id="date" wire:model="akhir" class="form-control">
                        <div class="text-danger">
                            @error('akhir')
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
            <button class="btn btn-primary btn-sm" wire:click.prevent="update()" id="tambahclose">Simpan</button>
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
     $("#tugas").modal('hide');
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

