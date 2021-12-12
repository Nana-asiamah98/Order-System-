$(document).ready(function () {
    $(".paginate_button").addClass('btn btn-info')

    if(localStorage.getItem('deleteUser') === 'y' ){
        swal("Done!", "It was succesfully deleted!", "success");
    }
    localStorage.setItem('deleteUser','n');

    /*Delete User*/
    $(document).on('click', '.deletedUser', function (e) {
        e.preventDefault();

        userId = $(this).attr('id');

        const dataColumn = {
            "_method": 'DELETE',
            "_csrf_token": $(this).data('csrf-token'),
        }
        const URL = $(this).data('remove-url')

        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3f51b5',
            cancelButtonColor: '#ff4081',
            confirmButtonText: 'Great ',
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "btn btn-danger",
                    closeModal: true,
                },
                confirm: {
                    text: "OK",
                    value: true,
                    visible: true,
                    className: "btn btn-primary",
                    closeModal: true
                }
            }}).then(function (isConfirm) {
            if (isConfirm) {
                console.log(isConfirm)

                $.ajax({
                    url: URL,
                    type: 'POST',
                    data: dataColumn
                }).then(function (d) {
                    // console.log(d)

                    localStorage.setItem('deleteUser', 'y');
                    window.location.reload();
                })
                    .catch(function (err) {
                        console.log(err)
                    })
            } else {
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        })
    });




});
