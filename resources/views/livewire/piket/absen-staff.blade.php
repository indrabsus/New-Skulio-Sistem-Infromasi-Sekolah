@if (strpos(Config::get('piket'), Auth::user()->level) === false)
<script>window.location = "{{ route('index') }}";</script>
@endif
<div>
    <div class="row justify-content-md-center">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Nama Tendik : </label>
                        <select wire:model="id_tendik" class="form-control">
                            <option value="">Cari Tendik</option>
                            @foreach ($tendik as $g)
                            <option value="{{ $g->id_staf }}">{{ $g->nama_staf }}</option>
                            @endforeach
                        </select>
                         <div class="text-danger">
                            @error('id_staf')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keterangan : </label>
                        <select wire:model="keterangan" class="form-control">
                            <option value="">Pilih Keterangan</option>
                            <option value="hadir">Hadir</option>
                            <option value="kegiatan">Hadir Kegiatan</option>
                            <option value="sakit">Sakit</option>
                            <option value="izin">Izin</option>
                            <option value="nojadwal">Tidak ada jadwal</option>
                        </select>
                         <div class="text-danger">
                            @error('keterangan')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm" wire:click="create()">Absen</button>
                </div>

            </div>
        </div>
    </div>

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
            <input type="text" wire:model='search' class="form-control" placeholder="Cari Nama Tendik">
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
                <th>Nama Tendik</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; ?>
            @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nama_staf }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tanggal)->translatedFormat('l, d F Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($d->waktu)->translatedFormat('h:i:s') }}</td>
                <td>{{ ucwords($d->keterangan) }}</td>
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

