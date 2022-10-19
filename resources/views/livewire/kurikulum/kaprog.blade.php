<div>

    <div class="row">
      <div class="col-lg-3 mb-2"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addc">
          Tambah Jurusan
        </button></div>

    @if(session('pesan'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
    {{session('pesan')}}
    </div>
    @endif
      <table class="table table-bordered table-striped">
          <tr>
              <th>No</th>
              <th>Jurusan</th>
              <th>Kaprog</th>
              <th>Aksi</th>
          </tr>
          <tr>
          <?php $no=1; ?>
          @foreach ($kaprog as $k)
          <td>{{$no++}}</td>
          <td><a href="" data-toggle="modal" data-target="#editk" wire:click="editK({{$k->id_kaprog}})">{{$k->jurusan}}</a></td>
          <td>@if (is_null($k->id_guru))
            <a href="" data-toggle="modal" data-target="#editc" wire:click="editC({{$k->id_kaprog}})">Belum di Set</a>
          @else
          <a href="" data-toggle="modal" data-target="#editc" wire:click="editC({{$k->id_kaprog}})">{{$k->nama_guru}}</a>
          @endif</td>
          <td><button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete" wire:click="konfirmasiHapus({{$k->id_kaprog}})">Hapus</i></button></td>
          </tr>
          @endforeach
      </table>
      <!-- Modal Tambah kelas -->
    <div wire:ignore.self class="modal fade" id="addc">
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
                              <label>Jurusan</label>
                              <input name="jurusan" class="form-control" value="{{old('jurusan')}}" wire:model="jurusan">
                              <div class="text-danger">
                                  @error('jurusan')
                                      {{$message}}
                                  @enderror
                              </div>
                          </div>
                          <div class="form-group">
                              <label>Nama Guru</label>
                              <select name="id_guru" wire:model="id_guru" class="form-control">
                                  <option value="">Pilih Guru</option>
                                  @foreach ($guru as $g)
                                  <option value="{{$g->id_guru}}">{{$g->nama_guru}}</option>
                                  @endforeach

                              </select>
                              <div class="text-danger">
                                  @error('id_guru')
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
              <button class="btn btn-primary btn-sm" wire:click.prevent="createC()">Simpan</button>
            </form>
          </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal edit Pemasukan -->
    <div wire:ignore.self class="modal fade" id="editc">
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
                              <label>Jurusan</label>
                              <input name="jurusan" class="form-control" value="{{old('jurusan')}}" wire:model="jurusan" disabled>
                              <div class="text-danger">
                                  @error('jurusan')
                                      {{$message}}
                                  @enderror
                              </div>
                          </div>
                          <div class="form-group">
                              <label>Nama Guru</label>
                              <select name="id_guru" wire:model="id_guru" class="form-control">
                                  <option value="">Pilih Guru</option>
                                  @foreach ($guru as $g)
                                  <option value="{{$g->id_guru}}">{{$g->nama_guru}}</option>
                                  @endforeach

                              </select>
                              <div class="text-danger">
                                  @error('id_guru')
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
            <h4 class="modal-title">Hapus Kelas</h4>
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
              <button class="btn btn-danger btn-sm" wire:click="delete()">Hapus</button>
          </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div wire:ignore.self class="modal fade" id="jadwal">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Extra Large Modal</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>One fine body&hellip;</p>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal edit Pemasukan -->
    <div wire:ignore.self class="modal fade" id="editk">
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
                            <label>jurusan</label>
                            <input name="jurusan" class="form-control" value="{{old('jurusan')}}" wire:model="jurusan">
                            <div class="text-danger">
                                @error('jurusan')
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
            <button class="btn btn-primary btn-sm" wire:click.prevent="updateK()">Simpan</button>
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
      window.livewire.on('addc',()=>{
          $('#addc').modal('hide');
      });

      window.livewire.on('editk',()=>{
          $('#editk').modal('hide');
      });

      window.livewire.on('jadwal',()=>{
          $('#jadwal').modal('hide');
      });

      window.livewire.on('editc',()=>{
          $('#editc').modal('hide');
      });

      window.livewire.on('edit',()=>{
          $('#edit').modal('hide');
      });

      window.livewire.on('delete',()=>{
          $('#delete').modal('hide');
      });

      window.livewire.on('addnon',()=>{
          $('#addnon').modal('hide');
      });
    </script>
    </div>
