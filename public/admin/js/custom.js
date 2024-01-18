$(document).ready(function () {
    $("#current_password").keyup(function (){
        var current_password = $("#current_password").val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/check-current-password',
            data: {current_password: current_password},
            success: function(resp) {
                if(resp == "false") {
                    $("#verifyCurrentPassword").html("Current Password is incorrect");
                } else if(resp == "true") {
                    $("#verifyCurrentPassword").html("Current Password is Correct");
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });



    //update cms page
    $(document).on("click", ".updateCmsPageStatus", function() {
        // Get the status and page_id attributes from the clicked element
        var status = $(this).children("i").attr("status");
        var page_id = $(this).attr("page_id");

        // Alert to test if the attributes are correctly obtained
        alert(page_id);

        // Make an AJAX request to update the CMS page status
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-cms-pages-page-status',
            data: { status: status, page_id: page_id },
            success: function(resp) {
                // Handle success response
                if(resp['status']==0){
                    $("#page-"+page_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
                }else  if(resp['status']==1){
                    $("#page-"+page_id).html("<i class='fas fa-toggle-on'  status='Active'></i>");

                }
            },
            error: function() {
                alert("Error");
            }
        });
    });
});
