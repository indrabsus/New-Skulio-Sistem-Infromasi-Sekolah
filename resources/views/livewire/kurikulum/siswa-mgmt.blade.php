<div>
    <div class="row">
        <div class="col-lg-2"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add">
            Tambah Siswa
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

        <table class="table table-responsive-md table-sm table-bordered table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Username</th>
                <th>No Hp</th>
                <th>Jenkel</th>
                <th>Kelas</th>
                <th>Poin</th>
                <th>ACC</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; ?>
            @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nama_siswa }}</td>
                <td>{{ $d->username }}</td>
                <td><a href="https://api.whatsapp.com/send?phone=62{{ substr($d->nohp, 1) }}" target="_blank">{{ $d->nohp }}</a></td>
                <td>@if ($d->jk_siswa == 'l')
                    Laki-laki
                @else
                    Perempuan
                @endif</td>
                <td>{{ $d->nama_kelas }}</td>
                <td>{{ $d->poin }}</td>
                <td>@if ($d->confirmed == 'y')
                    <i class="fa fa-check" aria-hidden="true"></i>
                @else
                <i class="fa fa-times" aria-hidden="true"></i>
                @endif
                    </td>
                <td><button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#reset" wire:click="creset({{$d->id}})">
                    Reset
                  </button> <button class="btn btn-success btn-sm" wire:click="edit({{$d->id}})" data-toggle="modal" data-target="#edit">Edit</button> <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete" wire:click="konfirmasiHapus({{$d->id}})">Delete</button></td>
            </tr>
            @endforeach
        </tbody>
        </table>
        {{ $data->links() }}



        <!-- Modal Reset USER -->
  <div wire:ignore.self class="modal fade" id="reset">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Reset Password</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="container">
                Apakah anda yakin untuk Reset Password ini?

                Secara otomatis password akan berganti menjadi : rahasia


            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <div class="form-group">
            <button class="btn btn-danger btn-sm" wire:click="resetpass()">Reset</button>
        </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

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
                            <label>Username</label>
                            <input name="username" class="form-control" wire:model="username">
                            <div class="text-danger">
                                @error('username')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                          <label>Nama Siswa</label>
                          <input name="kodenama_siswa_guru" class="form-control" wire:model="nama_siswa">
                          <div class="text-danger">
                              @error('nama_siswa')
                                  {{$message}}
                              @enderror
                          </div>
                      </div>
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
                        <div class="form-group">
                          <label>No HP</label>
                          <input name="nohp" class="form-control" wire:model="nohp">
                          <div class="text-danger">
                              @error('nohp')
                                  {{$message}}
                              @enderror
                          </div>
                      </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="custom-select form-control-border" wire:model="jk_siswa">
                              <option value="">Jenis Kelamin</option>
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>

                            <div class="text-danger">
                                @error('jk_siswa')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>ACC</label>
                            <select class="custom-select form-control-border" wire:model="confirmed">
                              <option value="">Konfirmasi</option>
                                <option value="y">Ya</option>
                                <option value="n">Tidak</option>
                            </select>

                            <div class="text-danger">
                                @error('confirmed')
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
                            <label>Username</label>
                            <input name="username" class="form-control" wire:model="username">
                            <div class="text-danger">
                                @error('username')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                          <label>Nama Siswa</label>
                          <input name="kodenama_siswa_guru" class="form-control" wire:model="nama_siswa">
                          <div class="text-danger">
                              @error('nama_siswa')
                                  {{$message}}
                              @enderror
                          </div>
                      </div>
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
                        <div class="form-group">
                          <label>No HP</label>
                          <input name="nohp" class="form-control" wire:model="nohp">
                          <div class="text-danger">
                              @error('nohp')
                                  {{$message}}
                              @enderror
                          </div>
                      </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="custom-select form-control-border" wire:model="jk_siswa">
                              <option value="">Jenis Kelamin</option>
                                <option value="l">Laki-laki</option>
                                <option value="">Perempuan</option>
                            </select>

                            <div class="text-danger">
                                @error('jk_siswa')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>ACC</label>
                            <select class="custom-select form-control-border" wire:model="confirmed">
                              <option value="">Konfirmasi</option>
                                <option value="y">Ya</option>
                                <option value="n">Tidak</option>
                            </select>

                            <div class="text-danger">
                                @error('confirmed')
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

