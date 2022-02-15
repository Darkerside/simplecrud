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
                <th>User</th>
                <th>Note Title</th>
                <th>Create At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $data = count($notesTable);
              if ($data == 0) {
                echo "<tr>
                  <td colspan='5' class='text-center'>No Data</td>
                </tr>";
              } else {
                foreach ($notesTable as $item) {
                  echo "<tr id='note-" . $item->id . "'>";
                  echo "<td>" . $item->id . "</td>";
                  echo "<td>" . $item->username . "</td>";
                  echo "<td>" . $item->note_title . "</td>";
                  echo "<td>" . date('d M Y', $item->created_at) . "</td>";
                  echo "<td>
                  <button class='btn btn-sm btn-success mr-1 btn-view' note-data='" . $item->id . "'><i class='fas fa-eye'></i></button>
                  <button class='btn btn-sm btn-primary mr-1 btn-edit' note-data='" . $item->id . "'><i class='fas fa-edit'></i></button>
                  <button class='btn btn-sm btn-danger btn-delete' note-data='" . $item->id . "'><i class='fas fa-trash'></i></button>
                  </td>";
                  echo "<tr>";
                }
              };
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>User</th>
                <th>Note Title</th>
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
          <h5 class="modal-title" id="createModalLabel">Create New Notes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="createNotes" method="post">
          <div class="modal-body">
            <div class="form-group mb-3">
              <label for="name">User</label>
              <input type="text" class="form-control" placeholder="Name" name="name" id="username" value="<?php echo $user['username']; ?>" readonly></input>
            </div>
            <div class="form-group mb-3">
              <label for="name">Title</label>
              <input type="text" id="note-title" class="form-control" placeholder="Title" name="note-title"></input>
            </div>
            <div class="form-group mb-3">
              <label for="notes">Notes</label>
              <textarea id="note-body" class="form-control" placeholder="Notes" name="note-body" rows="6"></textarea>
            </div>
            <div class="form-group mb-3">
              <label for="date-picker-example">Created at</label>
              <input placeholder="Selected date" id="note-created" value="<?php echo date('d M Y'); ?>" class="form-control" readonly></input>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-submit">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>