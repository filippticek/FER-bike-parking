<html>
<head>
<title>Datatables</title>
	<link rel="stylesheet"  href="vendor/DataTables/datatables.min.css">
	<script src="vendor/jquery/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="vendor/DataTables/datatables.min.js" type="text/javascript"></script>
	<style>
	body {font-family: calibri;color:#4e7480;}
	</style>
</head>
<body>
<div class="container">
	<table id="contact-detail" class="display nowrap" cellspacing="0" width="100%">
	<thead>
		<tr>
		<th>id</th>
		<th>Name</th>
		<th>email</th>

		</tr>
	</thead>
	</table>
	</div>
</body>
<script>
$(document).ready(function() {
    $('#contact-detail').DataTable({
        processing: true,
        serverSide: true,
        ajax: "data/getData.php"
    } );
} );
</script>
</html>
