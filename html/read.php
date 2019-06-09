<!DOCTYPE html>
<html>
<head>
   <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
   <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

</head>
<body>
  <td>
 <button type="button" id="{{$lead->id}}"  name="{{$lead->id}}" onclick="deleteRecord(this.id,this)" data-token="{{ csrf_token() }}">Delete</button>
 </td>
  <table id="table" class="display" style="width:80%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>mail</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>mail</th>
        </tr>
    </tfoot>
  </table>
</body>
</html>

<script type="text/javascript">
// Delete a record

function deleteRecord(mech_id,row_index) {
$.ajax({
        url:"{{action('MechanicController@destroy')}}",
        type: 'get',
        data: {
              "id": mech_id,
              "_token": token,
              },
        success: function ()
             {
              var i = row_index.parentNode.parentNode.rowIndex;
              document.getElementById("table1").deleteRow(i);
            }
     });
}

$(document).ready(function(){
    var table = $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax" : "pages/getData.php",
        error: function () {  // error handling code
                    $("#example").css("display", "none");
                }

    });

});
</script>
