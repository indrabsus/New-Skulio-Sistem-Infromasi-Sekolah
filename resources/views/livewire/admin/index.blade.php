<div>
    <h3 class="mb-3">Dashboard</h3>
<!-- Small boxes (Stat box) -->
<div class="row">

    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{$teachers}}</h3>

          <p>Guru</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{$students}}</h3>

          <p>Siswa</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{$groups}}</h3>

          <p>Kelas</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
       </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{$subjects}}</h3>

          <p>Mata Pelajaran</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
       </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

  <div class="mt-3">
    <div class="container">
        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ubah" wire:click="ubah({{Auth::user()->id}})">Ubah Password</button>
      </div>
    </div>

    <div wire:ignore.self class="modal fade" id="ubah">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Ubah Password</h4>
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
                              <label>Password Baru</label>
                              <input name="password" class="form-control" value="{{old('password')}}" wire:model="password" type="password">
                              <div class="text-danger">
                                  @error('password')
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
              <button class="btn btn-primary btn-sm" wire:click.prevent="ganti()">Simpan</button>
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
