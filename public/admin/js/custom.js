$(document).ready(function () {
    $("#current_password").keyup(function () {
        var current_password = $("#current_password").val();

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "post",
            url: "/admin/check-current-password",
            data: { current_password: current_password },
            success: function (resp) {
                if (resp == "false") {
                    $("#verifyCurrentPassword").html(
                        "Current Password is incorrect"
                    );
                } else if (resp == "true") {
                    $("#verifyCurrentPassword").html(
                        "Current Password is Correct"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    //update cms page
    $(document).on("click", ".updateCmsPageStatus", function () {
        // Get the status and page_id attributes from the clicked element
        var status = $(this).children("i").attr("status");
        var page_id = $(this).attr("page_id");

        // Alert to test if the attributes are correctly obtained
        // alert(page_id);

        // Make an AJAX request to update the CMS page status
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "post",
            url: "/admin/update-cms-pages-page-status",
            data: { status: status, page_id: page_id },
            success: function (resp) {
                // Handle success response
                if (resp["status"] == 0) {
                    $("#page-" + page_id).html(
                        "<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#page-" + page_id).html(
                        "<i class='fas fa-toggle-on'  status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    //updat ethe sub domain

    $(document).on("click", ".updateSubadminsStatus", function () {
        var status = $(this).children("i").attr("status");
        var subadmin_id = $(this).attr("subadmin_id");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "post",
            url: "/admin/update-subadmin-status",
            data: { status: status, subadmin_id: subadmin_id },
            success: function (resp) {
                // Handle success response
                if (resp["status"] == 0) {
                    $("#subadmin-" + subadmin_id).html(
                        "<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#subadmin-" + subadmin_id).html(
                        "<i class='fas fa-toggle-on' style='color: blue' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    // simple jequree the delete the cms page
    $(document).on("click", ".confirmedDelete", function () {
        // alert("test");
        // return false;

        // Swal.fire({
        //     title: 'Error!',
        //     text: 'Do you want to continue',
        //     icon: 'error',
        //     confirmButtonText: 'Cool'
        //   })

        //   return false;

        // var name=$(this).attr("name");
        // if(confirm('Are you sure to delete this '+name+' ?')){
        //     return true
        // }
        // return false;

        //confirmed delete with sweetalret

        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success",
                });
                window.location.href =
                    "/admin/delete-" + record + "/" + recordid;
            }
        });
    });

    // check the email valid or not


    $("#email").keyup(function () {
        var email = $("#email").val();
        // email it input text fild id

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "post",
            url: "/admin/add-subadmin",
            // added actual url
            data: { email: email },
                    success: function (response) {
                        // response received from controller to check email is already exist or not
                        if (response.exists) {
                            $("#verifyduplicate")
                            //verifyduplicate this is the span id to print the error
                                .text("Email already exists!")
                                .css("color", "red");
                            // You can handle further actions here
                        } else {
                            $("#verifyduplicate")
                                .text("Email is available")
                                .css("color", "green");
                            // Email is available, you can handle further actions here
                        }
                    },
                    error: function (xhr, status, error) {
                        var errorMessage = xhr.responseText; // Get the error message from the response
                        $("#verifyduplicate")
                            .text("Not Matched " )
                            .css("color", "green");
                    },
                });
    });
});
