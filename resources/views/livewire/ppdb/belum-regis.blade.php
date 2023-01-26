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
                <th>Asal Sekolah</th>
                <th>No Hp</th>
                <th>Reg</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr>
                <td>{{ $d->nisn }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->asal_sekolah }}</td>
                <td><a href="https://api.whatsapp.com/send?phone=62{{ substr($d->nohp, 1) }}" target="_blank">{{ $d->nohp }}</a></td>
                <td>@if ($d->daftar == 150000)
                  <i class="fa fa-check-square" aria-hidden="true"></i>
                @else
                <i class="fa fa-times-circle" aria-hidden="true"></i>
                @endif</td>
                 <td> <button class="btn btn-success btn-sm mb-1" wire:click="bayar({{ $d->id_ppdb }})" data-toggle="modal" data-target="#bayar">Bayar</button></td>
            </tr>
            @endforeach
        </tbody>
        </table>
        {{ $data->links() }}

        <table>
          <tr>
            <td><h4>Total Uang Pendaftaran </h4></td>
            <td><h4>:</h4></td>
            <td><h4>Rp. {{ number_format($uangdaftar, 2 , ',','.') }}</h4></td>
          </tr>
          <tr>
            <td><h4>Total Uang PPDB </h4></td>
            <td>:</td>
            <td><h4>Rp. {{ number_format($uangppdb, 2 , ',','.') }}</h4></td>
          </tr>
        </table>
        <hr>
        <h3>Total Keseluruhan : Rp. {{ number_format($uangdaftar+$uangppdb, 2 , ',','.') }}</h3>




        {{-- <!-- Modal Detail -->
  <div wire:ignore.self class="modal fade" id="detail">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Siswa Baru</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="container">
                <table class="table table-bordered">
                  <tr>
                    <td>NISN</td>
                    <td>{{ $nisn }}</td>
                  </tr>
                  <tr>
                    <td>Nama</td>
                    <td>{{ $nama }}</td>
                  </tr>
                  <tr>
                    <td>Jenis Kelamin</td>
                    <td>@if ($jenkel == 'l')
                        Laki-laki
                    @else
                        Perempuan
                    @endif</td>
                  </tr>
                  <tr>
                    <td>Asal Sekolah</td>
                    <td>{{ $asal_sekolah }}</td>
                  </tr>
                  <tr>
                    <td>Minat</td>
                    <td>{{ $minat }}</td>
                  </tr>
                  <tr>
                    <td>No Handphone</td>
                    <td>{{ $nohp }}</td>
                  </tr>
                  <tr>
                    <td>Tanggal Lahir</td>
                    <td>{{ date('d F Y', strtotime($ttl)) }}</td>
                  </tr>
                  <tr>
                    <td>Alamat</td>
                    <td>{{ $alamat }}</td>
                  </tr>
                  <tr>
                    <td>Agama</td>
                    <td>{{ $agama }}</td>
                  </tr>
                  <tr>
                    <td>Nama Ortu</td>
                    <td>{{ $ortu }}</td>
                  </tr>
                  <tr>
                    <td>Daftar</td>
                    <td>{{ $daftar == 0 ? "-" : "LUNAS"}}</td>
                  </tr>
                  <tr>
                    <td>Tanggal Daftar</td>
                    <td>@if ($bayardaftar != NULL)
                        {{ date('d F Y - h:i', strtotime($bayardaftar)) }}
                        @else
                        -
                    @endif</td>
                  </tr>
                  <tr>
                    <td>Cicilan 1</td>
                    <td>{{ "Rp. " . $cicilan1}}</td>
                  </tr>
                  <tr>
                    <td>Tanggal ke-1</td>
                    <td>@if ($bayar1 != NULL)
                        {{ date('d F Y - h:i', strtotime($bayar1)) }}
                        @else
                        -
                    @endif</td>
                  </tr>
                  <tr>
                    <td>Cicilan 2</td>
                    <td>{{ "Rp. " . $cicilan2 }}</td>
                  </tr>
                  <tr>
                    <td>Tanggal ke-2</td>
                    <td>@if ($bayar2 != NULL)
                        {{ date('d F Y - h:i', strtotime($bayar2)) }}
                        @else
                        -
                    @endif</td>
                  </tr>
                  <tr>
                    <td>Cicilan 3</td>
                    <td>{{ "Rp. " . $cicilan3 }}</td>
                  </tr>
                  <tr>
                    <td>Tanggal ke-3</td>
                    <td>@if ($bayar3 != NULL)
                        {{ date('d F Y - h:i', strtotime($bayar3)) }}
                        @else
                        -
                    @endif</td>
                  </tr>
                  
                </table>


            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <div class="form-group">
        </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal --> --}}

      <!-- Modal EDIT USER -->
      <div wire:ignore.self class="modal fade" id="bayar">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pembayaran</h4>
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
                              <label>Bayar Pendaftaran</label>
                              <select class="form-control" wire:model="daftar">
                                <option value="">Belum Bayar</option>
                                <option value="150000">LUNAS</option>
                              </select>
                              <div class="text-danger">
                                @error('daftar')
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
                <button class="btn btn-primary btn-sm" wire:click.prevent="updateBayar()">Simpan</button>
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

