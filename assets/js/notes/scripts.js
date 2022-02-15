// $(function () {
// $('#example2').DataTable({
//   "paging": true,
//   "lengthChange": false,
//   "searching": false,
//   "ordering": true,
//   "info": true,
//   "autoWidth": false,
//   "responsive": true,
// });

$(document).ready(async function () {
  initClick()
  let submitType = 'create'
  let username = $("#username").val()
  let notesId = null

  $('#createNotes').submit(async function (ev) {
    ev.preventDefault();
    $(document.body).css({ 'cursor': 'wait' });

    let url = (submitType === 'create') ? './notes/add' : `./notes/update/${notesId}`
    const formData = {
      noteTitle: $("#note-title").val(),
      noteBody: $("#note-body").val(),
    };
    await $.ajax({
      type: "POST",
      //set the data type
      dataType: 'json',
      url, // target element(s) to be updated with server response 
      cache: false,
      //set body
      data: formData,
      //check this in Firefox browser
      success: function (response) { showSuccess(response) },
      error: function (response) { showError(response) }
    });
    $(document.body).css({ 'cursor': 'default' });
    await initClick()
    return false;
  });

  function showSuccess(data) {
    $("#note-title").val(null)
    $("#note-body").val(null)
    $('#createModal').modal('hide')
    Swal.fire({
      icon: 'success',
      title: 'Success',
    })
    let tbody = ''
    data.data.forEach(item => {
      tbody += `<tr id='note-${item.id}'>
        <td>${item.id}</td>
        <td>${item.username}</td>
        <td>${item.note_title}</td>
        <td>${moment.unix(item.created_at).format('DD MMM YYYY')}</td>
        <td>
        <button class='btn btn-sm btn-success mr-1 btn-view' note-data='${item.id}'><i class='fas fa-eye'></i></button>
        <button class='btn btn-sm btn-primary mr-1 btn-edit' note-data='${item.id}'><i class='fas fa-edit'></i></button>
        <button class='btn btn-sm btn-danger btn-delete' note-data='${item.id}'><i class='fas fa-trash'></i></button>
        </td>
      </tr>
      `
    });
    $('#example2 tbody').html(tbody)
  }

  function showError(data) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      html: data.responseJSON.data
    })
  }

  async function deleteRow(id) {
    await $.ajax({
      type: "POST",
      //set the data type
      dataType: 'json',
      url: `/notes/delete/${id}`, // target element(s) to be updated with server response 
      cache: false,
      //check this in Firefox browser
      success: function (response) { showSuccess(response) },
      error: function (response) { showError(response) }
    });
    $(document.body).css({ 'cursor': 'default' });
    await initClick()
    return false;
  }

  function getDataById(id) {
    $.ajax({
      type: "GET",
      //set the data type
      dataType: 'json',
      url: `/notes/get/${id}`, // target element(s) to be updated with server response 
      cache: false,
      //check this in Firefox browser
      success: function (response) {
        $('#username').val(response.data.username)
        $("#note-title").val(response.data.note_title)
        $("#note-body").val(response.data.note_body)
        $('#note-created').val(moment.unix(response.data.created_at).format('DD MMM YYYY'))
        $(document.body).css({ 'cursor': 'default' });
        $('#createModal').modal('show')
      },
      error: function (response) { showError(response) }
    });
    return false;
  }

  async function initClick() {
    $('.btn-delete').click(function () {
      event.stopPropagation();
      event.stopImmediatePropagation();
      $(document.body).css({ 'cursor': 'wait' });
      console.log('delete')
      Swal.fire({
        confirmButtonText: 'Yes',
        icon: 'question',
        title: 'Delete Data',
        text: `Are you sure deleting data id ${$(this).attr('note-data')}`,
      })
        .then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            deleteRow($(this).attr('note-data'))
          }
        })
    })

    $('.btn-edit').click(function () {
      event.stopPropagation();
      event.stopImmediatePropagation();
      $(document.body).css({ 'cursor': 'wait' });
      console.log('edit')
      submitType = 'update'
      notesId = $(this).attr('note-data')
      $('#createNotes').addClass('update')
      $('#createModalLabel').html('Update Notes')
      $('#createNotes .btn-submit').html('Update').removeClass('d-none')
      $("#note-title").attr('disabled', false)
      $("#note-body").attr('disabled', false)
      getDataById($(this).attr('note-data'))
    })

    $('.btn-view').click(function () {
      event.stopPropagation();
      event.stopImmediatePropagation();
      $(document.body).css({ 'cursor': 'wait' });
      console.log('view')
      notesId = $(this).attr('note-data')
      $('#createModalLabel').html('View Notes')
      $('#createNotes .btn-submit').addClass('d-none')
      $("#note-title").attr('disabled', true)
      $("#note-body").attr('disabled', true)
      getDataById($(this).attr('note-data'))
    })

    $('.btn-create').click(function () {
      event.stopPropagation();
      event.stopImmediatePropagation();
      console.log('create')
      submitType = 'create'
      $('#createNotes').removeClass('update')
      $('#createModalLabel').html('Create Notes')
      $('#createNotes btn-submit').html('Create').removeClass('d-none')
      $("#note-title").attr('disabled', false)
      $("#note-body").attr('disabled', false)
      $("#username").val(username)
      $("#note-title").val(null)
      $("#note-body").val(null)
      $('#note-created').val(moment().format('DD MMM YYYY'))
      $('#createModal').modal('show')
    })
  }
})