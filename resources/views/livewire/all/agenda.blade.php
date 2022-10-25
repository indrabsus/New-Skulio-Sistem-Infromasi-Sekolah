@if (strpos(Config::get('manajemen'), Auth::user()->level) === false)
<script>window.location = "{{ route('index') }}";</script>
@endif
<div>
    <p><i>Note : Tulisan hitam artinya dipublikasikan</i></p>
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
            <input type="text" wire:model='search' class="form-control" placeholder="Berdasarkan kegiatan">
        </div>
        @if (Auth::user()->level == 'admin' || Auth::user()->level == 'kepsek' || Auth::user()->level == 'mutu')
        <div class="col-lg-3 mb-1">
            <select class="form-control" wire:model="carilevel">
                <option value="">Cari berdasarkan Divisi</option>
                <option value="kepsek">Kepsek</option>
                <option value="kurikulum">kurikulum</option>
                <option value="kesiswaan">Kesiswaan</option>
                <option value="humas">Humas</option>
                <option value="mutu">WMM</option>
                <option value="perpus">Perpus</option>
                <option value="konseling">BK/BP</option>
                <option value="otkp">OTKP</option>
                <option value="bdp">BDP</option>
                <option value="akl">AKL</option>
                <option value="rpl">RPL</option>
            </select>
        </div>
        @endif

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
                <th>Tanggal</th>
                <th>Kegiatan</th>
                <th>Partner</th>
                <th>Materi</th>
                <th>Hasil</th>
                {{-- <th>Divisi</th> --}}
                {{-- <th>Publish?</th> --}}
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; ?>
            @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="{{ $d->publish == 'y' ? '':'text-danger' }}">{{ \Carbon\Carbon::parse(date($d->tanggal_agenda))->translatedFormat('l, d F Y h:i') }}</td>
                <td class="{{ $d->publish == 'y' ? '':'text-danger' }}">{{ $d->kegiatan_agenda }}</td>
                <td class="{{ $d->publish == 'y' ? '':'text-danger' }}">{{ $d->partner }}</td>
                <td class="{{ $d->publish == 'y' ? '':'text-danger' }}">{{ $d->materi }}</td>
                <td class="{{ $d->publish == 'y' ? '':'text-danger' }}">{{ $d->hasil_kegiatan }}</td>
                {{-- <td>{{ $d->level }}</td> --}}
                {{-- <td>{{ $d->publish }}</td> --}}
                <td>
                    @if (Auth::user()->level == $d->level || Auth::user()->level == 'admin')
                    <button class="btn btn-success btn-sm" wire:click="edit({{$d->id_agenda}})" data-toggle="modal" data-target="#edit">Edit</button> <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete" wire:click="konfirmasiHapus({{$d->id_agenda}})">Delete</button>
                    @endif
                </td>
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
                            <label>Tanggal</label>
                            <input type="datetime-local" id="datetime-local" wire:model="tanggal_agenda" class="form-control">
                            <div class="text-danger">
                                @error('tanggal_agenda')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Kegiatan</label>
                            <input name="kegiatan_agenda" class="form-control" value="{{old('kegiatan_agenda')}}" wire:model="kegiatan_agenda">
                            <div class="text-danger">
                                @error('kegiatan_agenda')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Partner</label>
                            <input name="partner" class="form-control" value="{{old('partner')}}" wire:model="partner">
                            <div class="text-danger">
                                @error('partner')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                          <label>Materi</label>
                          <input name="materi" class="form-control" value="{{old('materi')}}" wire:model="materi">
                          <div class="text-danger">
                              @error('materi')
                                  {{$message}}
                              @enderror
                          </div>
                      </div>
                      <div class="form-group">
                        <label>Hasil Kegiatan</label>
                        <input name="hasil_kegiatan" class="form-control" value="{{old('hasil_kegiatan')}}" wire:model="hasil_kegiatan">
                        <div class="text-danger">
                            @error('hasil_kegiatan')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Publish?</label>
                        <select wire:model="publish" class="form-control">
                            <option value="">Publikasikan?</option>
                            <option value="y">Ya</option>
                            <option value="n">Tidak</option>
                        </select>
                        <div class="text-danger">
                            @error('publish')
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
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="datetime-local" id="datetime-local" wire:model="tanggal_agenda" class="form-control">
                                <div class="text-danger">
                                    @error('tanggal_agenda')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Kegiatan</label>
                                <input name="kegiatan_agenda" class="form-control" value="{{old('kegiatan_agenda')}}" wire:model="kegiatan_agenda">
                                <div class="text-danger">
                                    @error('kegiatan_agenda')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Partner</label>
                                <input name="partner" class="form-control" value="{{old('partner')}}" wire:model="partner">
                                <div class="text-danger">
                                    @error('partner')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                              <label>Materi</label>
                              <input name="materi" class="form-control" value="{{old('materi')}}" wire:model="materi">
                              <div class="text-danger">
                                  @error('materi')
                                      {{$message}}
                                  @enderror
                              </div>
                          </div>
                          <div class="form-group">
                            <label>Hasil Kegiatan</label>
                            <input name="hasil_kegiatan" class="form-control" value="{{old('hasil_kegiatan')}}" wire:model="hasil_kegiatan">
                            <div class="text-danger">
                                @error('hasil_kegiatan')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Publish?</label>
                            <select wire:model="publish" class="form-control">
                                <option value="">Publikasikan?</option>
                                <option value="y">Ya</option>
                                <option value="n">Tidak</option>
                            </select>
                            <div class="text-danger">
                                @error('publish')
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
                <button class="btn btn-primary btn-sm" wire:click.prevent="create()">Simpan</button>
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

