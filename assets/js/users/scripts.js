$(document).ready(async function () {
  initClick()
  await getRoleDropdown()
  let submitType = 'create'
  let userId = null

  $('#createUsers').submit(async function (ev) {
    ev.preventDefault();
    $(document.body).css({ 'cursor': 'wait' });

    let url = (submitType === 'create') ? './users/add' : `./users/update/${userId}`
    const formData = {
      username: $("#username").val(),
      roleId: $("#user-role").val(),
      password: $("#password").val(),
      retype: $("#retype-password").val(),
      isActive: $("#is-active").val(),
    };
    console.log(url, formData)

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
    $("#username").val(null)
    $("#user-role").val(null)
    $("#password").val(null)
    $("#retype-password").val(null)
    $("#is-active").val(null)
    $('#createModal').modal('hide')
    Swal.fire({
      icon: 'success',
      title: 'Success',
    })
    let tbody = ''
    data.data.forEach(item => {
      tbody += `<tr>
        <td>${item.id}</td>
        <td>${item.username}</td>
        <td>${item.role_name}</td>
        <td>${(item.is_active === '1') ? 'Active' : 'Non-Active'}</td>
        <td>${moment.unix(item.created_at).format('DD MMM YYYY')}</td>
        <td>
        <button class='btn btn-sm btn-success mr-1 btn-view' user-data='${item.id}'><i class='fas fa-eye'></i></button>
        <button class='btn btn-sm btn-primary mr-1 btn-edit' user-data='${item.id}'><i class='fas fa-edit'></i></button>
        <button class='btn btn-sm btn-danger btn-delete' user-data='${item.id}'><i class='fas fa-trash'></i></button>
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
      url: `/users/delete/${id}`, // target element(s) to be updated with server response 
      cache: false,
      //check this in Firefox browser
      success: function (response) { showSuccess(response) },
      error: function (response) { showError(response) }
    });
    $(document.body).css({ 'cursor': 'default' });
    await initClick()
    return false;
  }

  async function getDataById(id) {
    await $.ajax({
      type: "GET",
      //set the data type
      dataType: 'json',
      url: `/users/get/${id}`, // target element(s) to be updated with server response 
      cache: false,
      //check this in Firefox browser
      success: function (response) {
        $("#username").val(response.data.username)
        $("#user-role").val(response.data.role_id)
        $("#password").val('********')
        $("#retype-password").val('********')
        $("#is-active").val(response.data.is_active)
        $('#user-created').val(moment.unix(response.data.created_at).format('DD MMM YYYY'))
        $(document.body).css({ 'cursor': 'default' });
        $('#createModal').modal('show')
      },
      error: function (response) { showError(response) }
    });
    return false;
  }

  async function getRoleDropdown() {
    $.ajax({
      type: "GET",
      //set the data type
      dataType: 'json',
      url: '/roles/getAll', // target element(s) to be updated with server response 
      cache: false,
      //check this in Firefox browser
      success: function (response) {
        let options = '<option selected disabled>Choose...</option>';
        response.data.forEach(item => {
          options += `<option value='${item.id}'>${item.role_name}</option>`
        })
        $("#user-role").html(options);
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
        showDenyButton: true,
        showCancelButton: true,
        showConfirmButton: false,
        denyButtonText: 'Yes',
        icon: 'question',
        title: 'Delete Data',
        text: `Are you sure deleting data id ${$(this).attr('user-data')}`,
      })
        .then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isDenied) {
            deleteRow($(this).attr('user-data'))
          } else {
            $(document.body).css({ 'cursor': 'default' });
          }
        })
    })

    $('.btn-view').click(function () {
      event.stopPropagation();
      event.stopImmediatePropagation();
      $(document.body).css({ 'cursor': 'wait' });
      console.log('view')
      usersId = $(this).attr('user-data')
      $('#createModalLabel').html('View users')
      $('#createUsers .btn-submit').addClass('d-none')
      getDataById($(this).attr('user-data'))
    })

    $('.btn-edit').click(async function () {
      event.stopPropagation();
      event.stopImmediatePropagation();
      $(document.body).css({ 'cursor': 'wait' });
      console.log('view')
      submitType = 'update'
      userId = $(this).attr('user-data')
      await getDataById($(this).attr('user-data'))
      $('#createModalLabel').html('Edit users')
      $('#createUsers .btn-submit').addClass('d-none')
      $("#username").attr('disabled', false)
      $("#user-role").attr('disabled', false)
      $("#password").attr('disabled', true)
      $("#retype-password").attr('disabled', true)
      $("#is-active").attr('disabled', false)
      $('#createUsers .btn-submit').html('Create').removeClass('d-none')
    })

    $('.btn-create').click(function () {
      event.stopPropagation();
      event.stopImmediatePropagation();
      console.log('create')
      submitType = 'create'
      getRoleDropdown()
      $('#createModalLabel').html('Create users')
      $('#createUsers .btn-submit').html('Create').removeClass('d-none')
      $("#username").attr('disabled', false).val(null)
      $("#user-role").attr('disabled', false).html("<option value='null' disabled>Loading...</option>").val('null')
      $("#password").attr('disabled', false).val(null)
      $("#retype-password").attr('disabled', false).val(null)
      $("#is-active").attr('disabled', false).val('null')
      $('#user-created').val(moment().format('DD MMM YYYY'))
      $('#createModal').modal('show')
    })
  }
})