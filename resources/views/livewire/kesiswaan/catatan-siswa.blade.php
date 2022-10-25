@if (strpos(Config::get('kesiswaan'), Auth::user()->level) === false)
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
            <input type="text" wire:model='search' class="form-control" placeholder="Cari Nama Siswa">
        </div>
    </div>

    @if(session('pesan'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
    {{session('pesan')}}
    </div>
    @endif

        <table class="table table-responsive-lg table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Kelakuan</th>
                <th>Keterangan</th>
                <th>K Poin</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; ?>
            @foreach ($data as $d)
            @if ($d->kelakuan == 'baik')
            <tr class="text-success">
                @else
                <tr class="text-danger">
            @endif
                <td>{{ $no++ }}</td>
                <td>{{ $d->nama_siswa }}</td>
                <td>{{ $d->nama_kelas }}</td>
                <td>{{ $d->kelakuan }}</td>
                <td>{{ $d->keterangan }}</td>
                <td>@if ($d->kelakuan == 'baik')
                    +{{ $d->kpoin }}
                @else
                -{{ $d->kpoin }}
                @endif</td>
                <td>{{ \Carbon\Carbon::parse($d->tanggal)->translatedFormat('l, d F Y h:i') }}</td>
                <td><button class="btn btn-success btn-sm" wire:click="edit({{$d->id_catatan}})" data-toggle="modal" data-target="#edit">Edit</button> <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete" wire:click="konfirmasiHapus({{$d->id_catatan}})">Delete</button></td>
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
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input class="form-control"wire:model="keterangan">
                            <div class="text-danger">
                                @error('keterangan')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="datetime-local" id="date" wire:model="tanggal" class="form-control">
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

