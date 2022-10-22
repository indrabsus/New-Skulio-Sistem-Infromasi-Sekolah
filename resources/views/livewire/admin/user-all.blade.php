@if (Auth::user()->level != 'admin')
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
        <input type="text" wire:model='search' class="form-control" placeholder="Cari Username">
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
            <th>Username</th>
            <th>Level</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; ?>
        @foreach ($data as $d)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $d->username }}</td>
            <td>{{ $d->level }}</td>
            <td><button class="btn btn-success btn-sm" wire:click="edit({{$d->id}})" data-toggle="modal" data-target="#edit">Edit</button> <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete" wire:click="konfirmasiHapus({{$d->id}})">Delete</button></td>
        </tr>
        @endforeach
    </tbody>
    </table>

    {{ $data->links() }}

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
                            <label>Level</label>
                            <input type="text" class="form-control" wire:model="level">
                            <div class="text-danger">
                                @error('level')
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
                            <input name="username" class="form-control" wire:model="username" disabled>
                        </div>
                        <div class="form-group">

                            <label>Level</label>
                            <select class="form-control" wire:model="level">
                              <option value="">Pilih Level</option>
                                @foreach ($datalevel as $l)
                                    <option value="{{ $l->level }}">{{ $l->level }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger">
                                @error('level')
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
  <script>
    window.addEventListener('closeModal', event => {
     $("#add").modal('hide');
    })
    window.livewire.on('edit',()=>{
        $('#edit').modal('hide');
    });

    window.livewire.on('delete',()=>{
        $('#delete').modal('hide');
    });
  </script>
</div>
