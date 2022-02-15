<div class="container-fluid">
  <div class="row">
    <!-- /.col -->
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-row">
            <button type="button" class="btn btn-primary ml-auto mb-3 btn-create" data-toggle="modal" data-target="#createModal">
              Create
            </button>
          </div>
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Is Active</th>
                <th>Create At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $data = count($usersTable);
              if ($data == 0) {
                echo "<tr>
                  <td colspan='5' class='text-center'>No Data</td>
                </tr>";
              } else {
                foreach ($usersTable as $item) {
                  echo "<tr>";
                  echo "<td>" . $item->id . "</td>";
                  echo "<td>" . $item->username . "</td>";
                  echo "<td>" . $item->role_name . "</td>";
                  echo "<td>" . $item->is_active . "</td>";
                  echo "<td>" . date('d M Y', $item->created_at) . "</td>";
                  echo "<td>
                  <button class='btn btn-sm btn-success mr-1 btn-view' user-data='" . $item->id . "'><i class='fas fa-eye'></i></button>
                  <button class='btn btn-sm btn-primary mr-1 btn-edit' user-data='" . $item->id . "'><i class='fas fa-edit'></i></button>
                  <button class='btn btn-sm btn-danger btn-delete' user-data='" . $item->id . "'><i class='fas fa-trash'></i></button>
                  </td>";
                  echo "<tr>";
                }
              }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Is Active</th>
                <th>Create At</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">Create New Users</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="createUsers" method="post">
          <div class="modal-body">
            <div class="form-group mb-3">
              <label for="name">Username</label>
              <input type="text" class="form-control" id="username" placeholder="Username" name="username" required></input>
            </div>
            <div class="form-group mb-3">
              <label for="role">Role</label>
              <select id="user-role" class="form-control" placeholder="role" name="role" required>
                <option selected disabled>Loading...</option>
              </select>
            </div>
            <div class="form-group mb-3">
              <label for="password">Password</label>
              <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
            </div>
            <div class="form-group mb-3">
              <label for="retype-password">Retype Password</label>
              <input type="password" class="form-control" placeholder="Retype Password" name="retype-password" id="retype-password" required>
            </div>
            <div class="form-group mb-3">
              <label for="is-active">Activate</label>
              <select id="is-active" class="form-control" name="is-active" required>
                <option value="null" disabled>Choose</option>
                <option value="1">Active</option>
                <option value="0">Non-Active</option>
              </select>
            </div>
            <div class="form-group mb-3">
              <label for="date-picker-example">Created at</label>
              <input placeholder="Selected date" id="user-created" value="<?php echo date('d M Y'); ?>" class="form-control" readonly></input>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-submit">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>