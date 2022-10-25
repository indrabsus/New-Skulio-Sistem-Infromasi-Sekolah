@if (strpos(Config::get('guru'), Auth::user()->level) === false)
<script>window.location = "{{ route('index') }}";</script>
@endif
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
            <input type="text" wire:model='search' class="form-control" placeholder="Cari Nama File">
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
                <th>Nama File</th>
                <th>Format</th>
                <th>Tanggal Upload</th>
                @if (Auth::user()->level == 'admin' || Auth::user()->level == 'kurikulum')
                    <th>Pengirim</th>
                @endif
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; ?>
            @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nama_file }}</td>
                <td>@if ($d->ekstensi == 'doc' || $d->ekstensi == 'docx')
                    Microsoft Word Document
                @elseif($d->ekstensi == 'xls' || $d->ekstensi == 'xlsx')
                    Microsoft Excel Document
                @elseif($d->ekstensi == 'ppt' || $d->ekstensi == 'pptx')
                    Microsoft Power Poin Document
                @else
                    <a href="{{ $d->file_path }}" target="_blank">Link Document</a>
                @endif</td>
                <td>{{ \Carbon\Carbon::parse($d->created_at)->translatedFormat('l, d F Y') }}</td>
                @if (Auth::user()->level == 'admin' || Auth::user()->level == 'kurikulum')
                    <td>{{ $d->username }}</td>
                @endif
                <td>@if ($d->jenis == 'file')
                    <button class="btn btn-success btn-sm mb-1" wire:click="download({{$d->id_file}})">Download</button>
                @endif <button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#delete" wire:click="konfirmasiHapus({{$d->id_file}})">Delete</button></td>
            </tr>
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
                        <label>Nama File</label>
                        <input class="form-control" wire:model="nama_file">
                        <div class="text-danger">
                            @error('nama_file')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Jenis File</label>
                        <select class="form-control" wire:model="jenis">
                            <option value="">Pilih Jenis File</option>
                            <option value="file">File</option>
                            <option value="url">Url</option>
                        </select>
                        <div class="text-danger">
                            @error('jenis')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    @if ($jenis != '')
                    <div class="form-group">
                        <label>File Upload</label>
                        @if ($jenis == 'file')
                        <input class="form-control" wire:model="file_path" type="file">
                        <div wire:loading wire:target="file_path">Uploading...</div>
                        @elseif ($jenis == 'url')
                        <input class="form-control" wire:model="file_path">
                        @endif
                        <div class="text-danger">
                            @error('file_path')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    @endif
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

