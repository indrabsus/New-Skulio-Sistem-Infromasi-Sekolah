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
          <select wire:model="sort" class="form-control">
            <option value="asc">1 - 10</option>
            <option value="desc">10 - 1</option>
          </select>
      </div>
      <div class="col-lg-3 mb-1">
        <input type="date" class="form-control" wire:model="tanggal">
      </div>
      <div class="col-lg-1 mb-1">
        @if ($tanggal != "")
        <a href="{{ route('laporanppdb', ['tanggal' => $tanggal]) }}" class="btn btn-primary" target="_blank">Print</a>
        @endif
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
              <th>#</th>
              <th>No Map</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>No Hp</th>
                <th>Uang PPDB</th>
                <th>Keterangan</th>
                <th>Bayar</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr>
                <td><a href="{{ route('siswabaru',['id' => $d->id_ppdb]) }}" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a></td>
                <td>{{ $d->no_urut }}</td>
                <td>{{ $d->nisn }}</td>
                <td>{{ $d->nama }}</td>
                <td><a href="https://api.whatsapp.com/send?phone=62{{ substr($d->nohp, 1) }}" target="_blank">{{ $d->nohp }}</a></td>
                <td>{{ "Rp. " . number_format($d->cicilan1+$d->cicilan2+$d->cicilan3, 2, ',', '.') }}</td>
                <td>@if (($d->daftar+$d->cicilan1+$d->cicilan2+$d->cicilan3)-2400000 == 0)
                    <strong>LUNAS</strong>
                @else
                    <span class="text-danger">{{  number_format(($d->daftar+$d->cicilan1+$d->cicilan2+$d->cicilan3)-2400000, 2, ',','.') }}</span>
                @endif
                </td>
                <td><button type="button" class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#cicil1" wire:click="cicil1({{ $d->id_ppdb }})" {{ $d->cicilan1 > 0 ? "disabled": "" }}>
                  C1
                </button>
                <button type="button" class="btn btn-warning btn-sm mb-1" data-toggle="modal" data-target="#cicil2" wire:click="cicil2({{ $d->id_ppdb }})" {{ $d->cicilan2 > 0 ? "disabled": "" }}>
                  C2
                </button>
                <button type="button" class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#cicil3" wire:click="cicil3({{ $d->id_ppdb }})" {{ $d->cicilan3 > 0 ? "disabled": "" }}>
                  C3
                </button>
              </td>
                <td>
                  <button type="button" class="btn btn-dark btn-sm mb-1" data-toggle="modal" data-target="#detail" wire:click="detail({{ $d->id_ppdb }})">
                    Siswa
                  </button> <button class="btn btn-success btn-sm mb-1" wire:click="bayar({{ $d->id_ppdb }})" data-toggle="modal" data-target="#bayar">Bayar</button></td>
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




        <!-- Modal Detail -->
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
                    <td>Rp. {{ $cicilan1 == null ? 0 : number_format($cicilan1, 2, ',','.')}}</td>
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
                    <td>Rp. {{ $cicilan2 == null ? 0 : number_format($cicilan2, 2, ',','.')}}</td>
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
                    <td>Rp. {{ $cicilan3 == null ? 0 : number_format($cicilan3, 2, ',','.')}}</td>
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
  <!-- /.modal -->

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
                              <select class="form-control" wire:model="daftar" {{ $daftar == 150000 ? "disabled" : ""}}>
                                <option value="">Belum Bayar</option>
                                <option value="150000">LUNAS</option>
                              </select>
                              <div class="text-danger">
                                @error('daftar')
                                    {{$message}}
                                @enderror
                            </div>
                            </div>

                            <div class="form-group">
                              <label>Tanggal Bayar</label>
                              <input type="datetime-local" class="form-control" wire:model="bayardaftar" {{ $bayardaftar == NULL ? "" : "disabled"}}>
                              <div class="text-danger">
                                @error('bayardaftar')
                                    {{$message}}
                                @enderror
                            </div>
                            </div>

                            <div class="form-group">
                              <label>Bayar Cicilan 1</label>
                              <input type="text" class="form-control" wire:model="cicilan1" disabled>
                              <div class="text-danger">
                                @error('cicilan1')
                                    {{$message}}
                                @enderror
                            </div>
                            </div>

                            <div class="form-group">
                              <label>Tanggal Bayar</label>
                              <input type="datetime-local" class="form-control" wire:model="bayar1" disabled>
                              <div class="text-danger">
                                @error('bayar1')
                                    {{$message}}
                                @enderror
                            </div>
                            </div>

                            <div class="form-group">
                              <label>Bayar Cicilan 2</label>
                              <input type="text" class="form-control" wire:model="cicilan2" disabled>
                              <div class="text-danger">
                                @error('cicilan2')
                                    {{$message}}
                                @enderror
                            </div>
                            </div>

                            <div class="form-group">
                              <label>Tanggal Bayar</label>
                              <input type="datetime-local" class="form-control" wire:model="bayar2" disabled>
                              <div class="text-danger">
                                @error('bayar2')
                                    {{$message}}
                                @enderror
                            </div>
                            </div>

                            <div class="form-group">
                              <label>Bayar Cicilan 3</label>
                              <input type="text" class="form-control" wire:model="cicilan3" disabled>
                              <div class="text-danger">
                                @error('cicilan3')
                                    {{$message}}
                                @enderror
                            </div>
                            </div>

                            <div class="form-group">
                              <label>Tanggal Bayar</label>
                              <input type="datetime-local" class="form-control" wire:model="bayar3" disabled>
                              <div class="text-danger">
                                @error('bayar3')
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
             
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- Modal EDIT USER -->
      <div wire:ignore.self class="modal fade" id="cicil1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Cicilan 1</h4>
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
                            <label>Nama</label>
                            <input type="text" class="form-control" wire:model="nama" disabled>
                            <div class="text-danger">
                              @error('nama')
                                  {{$message}}
                              @enderror
                          </div>
                          </div>

                            <div class="form-group">
                              <label>Bayar Cicilan 1</label>
                              <input type="text" class="form-control" wire:model="cicilan1">
                              <div class="text-danger">
                                @error('cicilan1')
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
                <button class="btn btn-primary btn-sm" wire:click.prevent="updateCicil1()">Simpan</button>
              </form>
            </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

       <!-- Modal EDIT USER -->
       <div wire:ignore.self class="modal fade" id="cicil2">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Cicilan 2</h4>
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
                            <label>Nama</label>
                            <input type="text" class="form-control" wire:model="nama" disabled>
                            <div class="text-danger">
                              @error('nama')
                                  {{$message}}
                              @enderror
                          </div>
                          </div>

                            <div class="form-group">
                              <label>Bayar Cicilan 2</label>
                              <input type="text" class="form-control" wire:model="cicilan2">
                              <div class="text-danger">
                                @error('cicilan2')
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
                <button class="btn btn-primary btn-sm" wire:click.prevent="updateCicil2()">Simpan</button>
              </form>
            </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

       <!-- Modal EDIT USER -->
       <div wire:ignore.self class="modal fade" id="cicil3">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Cicilan 3</h4>
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
                            <label>Nama</label>
                            <input type="text" class="form-control" wire:model="nama" disabled>
                            <div class="text-danger">
                              @error('nama')
                                  {{$message}}
                              @enderror
                          </div>
                          </div>

                            <div class="form-group" wire:ignore>
                              <label>Bayar Cicilan 3</label>
                              <input type="text" class="form-control" wire:model="cicilan3">
                              <div class="text-danger">
                                @error('cicilan3')
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
                <button class="btn btn-primary btn-sm" wire:click.prevent="updateCicil3()">Simpan</button>
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
     $("#cicil1").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#cicil2").modal('hide');
    })
    window.addEventListener('closeModal', event => {
     $("#cicil3").modal('hide');
    })

  </script>
    </div>

