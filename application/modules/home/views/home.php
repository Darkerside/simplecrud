<div class="container-fluid">
  <div class="row">
    <!-- /.col -->
    <div class="col-md-12">
      <div class="row">
        <div class="col-lg-3 col-6">

          <div class="small-box bg-success">
            <div class="inner">
              <h3><?php echo $dashboard['notes']; ?></h3>
              <p>Notes</p>
            </div>
            <div class="icon">
              <i class="fas fa-copy"></i>
            </div>
            <a href="<?= base_url('notes') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <?php if ($user['role'] == 'Admin') { ?>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $dashboard['users']; ?></h3>
                <p>Users</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="<?= base_url('users') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        <?php }; ?>

      </div>
    </div>
  </div>