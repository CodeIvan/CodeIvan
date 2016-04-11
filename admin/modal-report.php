      <div class="modal" id="print-laporan">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="report.php" method="post">
              <div class="modal-header" style="background-color: #f39c12;">
                <button class="close" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i></button>
                <h1 align="center" style="color: #fff;">Cetak Laporan  <i class="glyphicon glyphicon-print fa-lg"></i></h1>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="tgl1">Tanggal Awal</label>
                      <input type="date" name="tgl1" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="tgl2">Tanggal Akhir</label>
                      <input type="date" name="tgl2" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <div class="row">
                  <div class="col-md-6">
                    <button type="submit" name="cetak" class="btn btn-success btn-block btn-lg">Cetak <i class="glyphicon glyphicon-print fa-lg"></i></button>
                  </div>
                  <div class="col-md-6">
                    <button type="reset" name="batal" class="btn btn-danger btn-block btn-lg" data-dismiss="modal">Batal <i class="glyphicon glyphicon-remove fa-lg"></i></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
