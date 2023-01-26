@if (strpos(Config::get('admin'), Auth::user()->level) === false)
<script>window.location = "{{ route('index') }}";</script>
@endif

<div>
    <h3>Slider</h3>
    <div class="row">
        <div class="col-lg-2"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add">
            Tambah Gambar
          </button></div>
        <div class="col-lg-1 mb-1">
            <select wire:model='result' class="form-control">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="50">50</option>
                <option value="100">100</option>
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

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Link</th>
                <th>Button</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; ?>
            @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td><img src="{{ asset(Config::get('public')) }}/{{ $d->gambar }}" width="100px"></td>
                <td>{{ $d->judul }}</td>
                <td>{{ $d->deskripsi }}</td>
                <td>{{ $d->link }}</td>
                <td>{{ $d->tombol }}</td>
                <td><button class="btn btn-success btn-sm mb-1" wire:click="edit({{$d->id_slider}})" data-toggle="modal" data-target="#edit">Edit</button> <button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#delete" wire:click="konfirmasiHapus({{$d->id_slider}})">Delete</button></td>
            </tr>
            @endforeach
        </tbody>
        </table>
        {{ $data->links() }}

        <h3 class="mt-5">Dokumentasi</h3>
        <div class="row">
            
        <div class="col-lg-2"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add2">
            Tambah Gambar
          </button></div>
        <div class="col-lg-1 mb-1">
            <select wire:model='result' class="form-control">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="50">50</option>
                <option value="100">100</option>
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

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Link</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; ?>
            @foreach ($galery as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td><img src="{{ asset(Config::get('public')) }}/{{ $d->gambar }}" width="100px"></td>
                <td>{{ $d->judul }}</td>
                <td>{{ $d->deskripsi }}</td>
                <td>{{ $d->link }}</td>
                <td> <button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#delete2" wire:click="konfirmasiHapus2({{$d->id_galeri}})">Delete</button></td>
            </tr>
            @endforeach
        </tbody>
        </table>
        {{ $galery->links() }}



        <h3 class="mt-5">Jurusan</h3>
        <div class="row">
            <div class="col-lg-2"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add3">
                Tambah Gambar
              </button></div>
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
                    <th>Gambar</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; ?>
                @foreach ($jurusan as $d)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td><img src="{{ asset(Config::get('public')) }}/{{ $d->gambar }}" width="100px"></td>
                    <td>{{ $d->deskripsi }}</td>
                    <td> <button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#delete3" wire:click="konfirmasiHapus3({{$d->id_jurusan}})">Delete</button></td>
                </tr>
                @endforeach
            </tbody>
            </table>


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
                    <div class="col-sm">
                                <div class="form-group">
                                  <img src="{{ asset(Config::get('public')) }}/{{ $gambar }}" width="150px">
                                </div>
                  
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control" wire:model="judul">
                            <div class="text-danger">
                                @error('judul')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" class="form-control" wire:model="deskripsi">
                            <div class="text-danger">
                                @error('deskripsi')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" class="form-control" wire:model="link">
                            <div class="text-danger">
                                @error('link')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Button</label>
                            <input type="text" class="form-control" wire:model="tombol">
                            <div class="text-danger">
                                @error('tombol')
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
                <div class="col-sm">
                            <div class="form-group">
                              <label for="exampleFormControlFile1">Upload Gambar</label>
                              <input type="file" class="form-control-file" id="exampleFormControlFile1" wire:model="gambar">
                            </div>
              
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" class="form-control" wire:model="judul">
                        <div class="text-danger">
                            @error('judul')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" class="form-control" wire:model="deskripsi">
                        <div class="text-danger">
                            @error('deskripsi')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" class="form-control" wire:model="link">
                        <div class="text-danger">
                            @error('link')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Button</label>
                        <input type="text" class="form-control" wire:model="tombol">
                        <div class="text-danger">
                            @error('tombol')
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
  </div>




  <!-- Modal EDIT USER -->
  <div wire:ignore.self class="modal fade" id="edit2">
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
                <div class="col-sm">
                            <div class="form-group">
                              <img src="{{ asset(Config::get('public')) }}/{{ $gambar }}" width="150px">
                            </div>
              
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" class="form-control" wire:model="judul">
                        <div class="text-danger">
                            @error('judul')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" class="form-control" wire:model="deskripsi">
                        <div class="text-danger">
                            @error('deskripsi')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" class="form-control" wire:model="link">
                        <div class="text-danger">
                            @error('link')
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
            <button class="btn btn-primary btn-sm" wire:click.prevent="update2()">Simpan</button>
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
  <div wire:ignore.self class="modal fade" id="delete2">
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
            <button class="btn btn-danger btn-sm" wire:click="delete2()">Hapus</button>
        </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Modal ADD USER -->
<div wire:ignore.self class="modal fade" id="add2">
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
                          <label for="exampleFormControlFile1">Upload Gambar</label>
                          <input type="file" class="form-control-file" id="exampleFormControlFile1" wire:model="gambar">
                        </div>
          
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" class="form-control" wire:model="judul">
                    <div class="text-danger">
                        @error('judul')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" class="form-control" wire:model="deskripsi">
                    <div class="text-danger">
                        @error('deskripsi')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Link</label>
                    <input type="text" class="form-control" wire:model="link">
                    <div class="text-danger">
                        @error('link')
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
        <button class="btn btn-primary btn-sm" wire:click.prevent="create2()" id="tambahclose">Simpan</button>
      </form>
    </div>
    </div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>


<!-- Modal EDIT USER -->
<div wire:ignore.self class="modal fade" id="edit3">
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
              <div class="col-sm">
                          <div class="form-group">
                            <img src="{{ asset(Config::get('public')) }}/{{ $gambar }}" width="150px">
                          </div>
                  <div class="form-group">
                      <label>Deskripsi</label>
                      <textarea rows="10" class="form-control" wire:model="deskripsi"></textarea>
                      <div class="text-danger">
                          @error('deskripsi')
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
          <button class="btn btn-primary btn-sm" wire:click.prevent="update3()">Simpan</button>
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
<div wire:ignore.self class="modal fade" id="delete3">
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
              Apakah anda yakin untuk menghapus data ini?

          </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <div class="form-group">
          <button class="btn btn-danger btn-sm" wire:click="delete3()">Hapus</button>
      </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal ADD USER -->
<div wire:ignore.self class="modal fade" id="add3">
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
                        <label for="exampleFormControlFile1">Upload Gambar</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1" wire:model="gambar">
                      </div>
              <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea rows="10" wire:model="deskripsi" class="form-control">{{ $deskripsi }}</textarea>
                  <div class="text-danger">
                      @error('deskripsi')
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
      <button class="btn btn-primary btn-sm" wire:click.prevent="create3()" id="tambahclose">Simpan</button>
    </form>
  </div>
  </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>

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

    window.addEventListener('closeModal', event => {
     $("#add2").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#edit2").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#delete2").modal('hide');
    })

    window.addEventListener('closeModal', event => {
     $("#add3").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#edit3").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#delete3").modal('hide');
    })

  </script>
    </div>

