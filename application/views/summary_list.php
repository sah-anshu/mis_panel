 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <style type="text/css">
        .error { color: red; }
        input.invalid, textarea.invalid{
            border: 2px solid red !important; 
        }

        input.valid, textarea.valid{
            border: 2px solid green;
        }
        table.dataTable tbody td {
            word-break: break-word;
            vertical-align: top;
        }
        table.dataTable tbody tr:hover {
          background-color: #ffa;
        }

        table.dataTable tbody tr:hover > .sorting_1 {
          background-color: #ffa;
        }

        table.dataTable thead:hover {
          background-color: #ffa;
        }

        body.modal-open > :not(.modal) {
            -webkit-filter: blur(2px);
            -moz-filter: blur(2px);
            -o-filter: blur(2px);
            -ms-filter: blur(2px);
            filter: blur(2px);
        }

    </style>

 
      <h2>Dashboard</h2>
      <hr/>
      <?php if ($_SESSION['is_admin'] === true) : ?>
      <a href="javascript:void(0)" class="btn btn-info" id="create-new-password">Add New</a>
      <hr/>
      <?php endif; ?>
      <br/>
      <table class="table table-bordered table-striped" id="password_list">
        <thead>
          <tr>
            
            <th>Date</th>
            <th>User ID</th>
            <th>Status</th>
            <th>No. Of SMS</th>
            <th>Credit Used</th>
           
            <?php if ($_SESSION['is_admin'] === true) : ?> <th>Action</th> <?php endif; ?>

          </tr>
        </thead>
        <tbody> 
            <?php if($summary): ?> 
            <?php foreach($summary as $password):?> 
            <tr id="password_id_<?php echo $password->id;?>">
                 
                <td> <?php echo $password->sendondate;?> </td>
                <td> <?php echo $password->user_id;?> </td>
                <td> <?php echo $password->status;?> </td>

                <td> <?php echo $password->totalcredits;?> </td>
                <td> <?php echo $password->billcredits;?> </td>

                <?php if ($_SESSION['is_admin'] === true) : ?>
                <td>
                  <a href="javascript:void(0)" data-id="<?php echo $password->id;?>" class="btn btn-info edit-password">Edit</a>
                  <a href="javascript:void(0)" data-id="<?php echo $password->id;?>" class="btn btn-danger delete-user delete-password">Delete</a>
                </td>
                <?php endif; ?>
            </tr> 
            <?php endforeach;?>
            <?php endif; ?> 
        </tbody>
      </table>
      <hr/>
 
    </div>

    <!-- Model for add edit password -->

    <div class="modal fade" id="ajax-password-modal"  tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="passwordCrudModal"></h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-11 mx-auto">
                <div class="alert" role="alert" id="passwordFormMsg">
                </div>
                <form id="passwordForm" name="passwordForm" class="form-horizontal">
                  <input type="hidden" name="password_id" id="password_id">
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <label for="name" class="control-label">Application</label>
                      <input type="text" class="form-control" id="Application" name="Application" placeholder="Enter Application" value="" maxlength="50" required="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-6">
                      <label for="name" class="control-label">SAPSID</label>
                      <input type="text" class="form-control" id="SAPSID" name="SAPSID" placeholder="Enter SAPSID" value="" maxlength="3" minlength="3" onKeyPress="if(this.value.length==3) return false;">
                    </div>
                    <div class="col-sm-6">
                      <label for="name" class="control-label">SAPClient</label>
                      <input type="number" class="form-control" id="SAPClient" name="SAPClient" placeholder="Enter SAPClient" value="" pattern="/^-?\d+\.?\d*$/" maxlength="3" onKeyPress="if(this.value.length==3) return false;">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <label for="name" class="control-label">URL</label>
                      <input type="text" class="form-control" id="URL" name="URL" placeholder="Enter URL" value="" maxlength="250">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-6">
                      <label for="name" class="control-label">Username</label>
                      <input type="text" class="form-control" id="UserName" name="UserName" placeholder="Enter Username" value="" maxlength="50">
                    </div>
                    <div class="col-sm-6">
                      <label for="name" class="control-label">Password</label>
                      <input type="text" class="form-control" id="Password" name="Password" placeholder="Enter Password" value="" maxlength="50">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <label class="control-label">Notes</label>
                      <textarea class="form-control" id="Notes" name="Notes" placeholder="Enter Notes"></textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>

    <!-- END Model for add edit password -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  
<script language="javascript">
var SITEURL = '<?php echo base_url(); ?>';

$(document).ready(function() {


    var table = $("#password_list").DataTable({
        "stateSave": false,
        // Processing indicator
        "processing": true,
        // DataTables server-side processing mode
        "serverSide": true,
        // Initial no order.
        "order": [],
        // Load data from an Ajax source
        "ajax": {
            "url": SITEURL + "index.php/summary/getLists/",
            "type": "POST"
        },
        'aoColumnDefs': [
            { 
                "aTargets": [0], //column index counting from the left
                "sType": 'date',
                "fnRender": function ( dateObj ) {
                    var oDate = new Date(dateObj.aData[0]);
                    result = oDate.getDate()+"/"+(oDate.getMonth()+1)+"/"+oDate.getFullYear();
                    return "<span>"+result+"</span>";
                }
            },          
            {
                'bSortable': false,
                'aTargets': [-1,]  
            }
        ],

    });

    $('#password_list tbody').on( 'hover', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    
    /*  When user click add user button */
    <?php if ($_SESSION['is_admin'] === true ) : ?>

        $('#create-new-password').click(function() {
            $('#btn-save').val("create-password");
            $('#password_id').val('');
            $('#passwordForm').trigger("reset");
            $('#passwordCrudModal').html("Add New Password");
            $('#ajax-password-modal').modal({backdrop: false, show: true});

              $('.modal-dialog').draggable({
                handle: ".modal-header"
              });
        });
        
        /* When click edit user */
        $('body').on('click', '.edit-password', function() {
            var password_id = $(this).data("id");
            console.log(password_id);
            $.ajax({
                type: "Post",
                url: SITEURL + "index.php/password/get_password_by_id",
                data: {
                    id: password_id
                },
                dataType: "json",
                success: function(res) {
                    if (res.success == true) {
                        $('#title-error').hide();
                        $('#password_code-error').hide();
                        $('#description-error').hide();
                        $('#passwordCrudModal').html("Edit Password");
                        $('#btn-save').val("edit-password");
                        $('#ajax-password-modal').modal({backdrop: false, show: true});

                          $('.modal-dialog').draggable({
                            handle: ".modal-header"
                          });

                        $('#password_id').val(res.data.id);
                        $('#Application').val(res.data.Application);
                        $('#SAPSID').val(res.data.SAPSID);
                        $('#SAPClient').val(res.data.SAPClient);
                        $('#URL').val(res.data.URL);
                        $('#UserName').val(res.data.UserName);
                        $('#Password').val(res.data.Password);
                        $('#Notes').val(res.data.Notes);

                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

        
        $('body').on('click', '.delete-password', function() {
            var password_id = $(this).data("id");
            var password_app = $(this).data("app");
     
     
            if (confirm("Are you sure you want to delete this entry starting with: "+ password_app)) {
                $.ajax({
                    type: "Post",
                    url: SITEURL + "index.php/password/delete",
                    data: {
                        password_id: password_id
                    },
                    dataType: "json",
                    success: function(data) {
                        //$("#password_id_" + password_id).remove();
                        $('#password_list').DataTable().ajax.reload(null, false);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }
        });

    <?php endif; ?>

});

<?php if ($_SESSION['is_admin'] === true) : ?>

$('#SAPSID').on('input', function() {  
    var input=$(this);
    var re = /[A-Z]/;
    var is_SAPSID=re.test(input.val());
    if(is_SAPSID){ input.removeClass("invalid").addClass("valid");}
    else{ input.removeClass("valid").addClass("invalid");}
});


if ($("#passwordForm").length > 0) {
    $("#passwordForm").validate({
        submitHandler: function(form) {
            var actionType = $('#btn-save').val();
            $('#btn-save').html('Sending..');
            $.ajax({
                data: $('#passwordForm').serialize(),
                url: SITEURL + "index.php/password/store",
                type: "POST",
                cache: false, 
                dataType: 'json',
                success: function(res) {

                    var password = '<tr id="password_id_' + res.data.id + '"><td>' + res.data.id + '</td><td>' + res.data.Application + '</td><td>' + res.data.SAPSID + '</td><td>' + res.data.SAPClient + '</td><td>' + res.data.URL + '</td><td>' + res.data.UserName + '</td><td>' + res.data.Password + '</td><td>' + res.data.Notes + '</td><td>' + res.data.last_updated_timestamp + '</td>';

                    password += '<td><a href="javascript:void(0)" id="" data-id="' + res.data.id + '" class="btn btn-info edit-password">Edit</a><a href="javascript:void(0)" id="" data-id="' + res.data.id + '" class="btn btn-danger delete-user delete-password">Delete</a></td></tr>';

                    if (actionType == "create-password") {
                        $('#password_list').prepend(password);
                    } else {
                        $("#password_id_" + res.data.id).replaceWith(password);
                    }

                    if (res.status == true)
                    {
                        $('#passwordForm').trigger("reset");
                        $('#ajax-password-modal').modal('hide');
                        $('#passwordFormMsg').hide();
                        $('#btn-save').html('Save Changes');

                        $('#password_list').DataTable().ajax.reload(null, false);
                    } 
                    else 
                        { $('#passwordFormMsg').html(res.data.err).addClass("alert-danger"); $('#btn-save').html('Save Changes');  $('#password_list').DataTable().ajax.reload(null, false);  }

                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#btn-save').html('Save Changes');
                }
            });
        }
    })
} 
<?php endif; ?>

</script>
 