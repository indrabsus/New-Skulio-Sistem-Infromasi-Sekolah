@if (strpos(Config::get('guru'), Auth::user()->level) === false)
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
            <input type="text" wire:model='search' class="form-control" placeholder="Cari Nama Guru">
        </div>
        <div class="col-lg-3 mb-1">
            <select class="form-control" wire:model.prevent="carihari">
                <option value="">Cari berdasarkan hari</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
            </select>
        </div>
    </div>

    @if(session('pesan'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
    {{session('pesan')}}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{session('error')}}
    </div>
    @endif
    <div class="row">
        <table class="table table-bordered">
            <tr>
                <th colspan="5"><i>Agenda Terakhir anda :</i></th>
            </tr>
            @foreach ($agenda as $g)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($g->created_at)->translatedFormat('l, d F Y - h:i') }}</td>
                    <td>{{ $g->materi }}</td>
                    <td>{{ $g->kegiatan }}</td>
                    <td>{{ $g->nama_kelas }}</td>
                    <td>{{ $g->nama_mapel }}</td>
                </tr>
            @endforeach
        </table>
    </div>
        <table class="table table-responsive-lg table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Jam ke</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; ?>
            @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nama_mapel }}</td>
                <td>{{ $d->nama_kelas }}</td>
                <td>{{ $d->hari }}</td>
                <td>{{ date('h:i', strtotime($d->jam_a)) }} - {{ date('h:i', strtotime($d->jam_b)) }}</td>
                <td>
                <button class="btn btn-success btn-sm mb-1" wire:click="agenda({{$d->id_jadwal}})" data-toggle="modal" data-target="#agenda">Agenda</button>
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
        {{ $data->links() }}




      <!-- Modal EDIT USER -->
      <div wire:ignore.self class="modal fade" id="agenda">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Agenda Kelas</h4>
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
                            <label>Materi</label>
                            <input type="text" class="form-control" wire:model="materi">
                            <div class="text-danger">
                                @error('materi')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Kegiatan</label>
                            <input type="text" class="form-control" wire:model="kegiatan">
                            <div class="text-danger">
                                @error('kegiatan')
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
                <button class="btn btn-primary btn-sm" wire:click.prevent="kirimagenda()">Simpan</button>
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
                <div class="col-sm">
                    <div class="form-group">
                        <label>Nama Guru</label>
                        <select class="form-control" wire:model="id_ajar">
                            <option value="">Pilih Guru Mapel</option>
                            @foreach ($guru as $g)
                                <option value="{{ $g->id_ajar }}">{{ $g->nama_guru }} ({{ $g->nama_mapel }} {{ $g->nama_kelas }})</option>
                            @endforeach
                        </select>
                        <div class="text-danger">
                            @error('id_ajar')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Hari</label>
                    <select class="form-control" wire:model="hari">
                        <option value="">Pilih Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                    </select>
                        <div class="text-danger">
                            @error('hari')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Jam Ke</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="time" class="form-control" wire:model="jam_a">

                            </div>
                            <div class="col-sm-6">
                                <input type="time" class="form-control" wire:model="jam_b">

                            </div>
                            <div class="text-danger">
                                @error('jam_a')
                                    {{$message}}
                                @enderror
                            </div>
                            <div class="text-danger">
                                @error('jam_b')
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
     $("#add").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#agenda").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#delete").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#reset").modal('hide');
    })

  </script>
    </div>

