<?php
session_start();
include_once __DIR__ . '/Server/DataAccess/dataAccess.php';
$dataAccess = DataAccess::global_instance();
?>
<Html>
	<Head>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular.min.js"></script>
		<script>
			$(document).ready(function() {
				
				$("#get").click(function() {
					$.get("http://localhost/OpenLaw/Server/DataAccess/getData.php?type=all", function(data, status) {
						$("#json").val(data);
					});
				});
				
				$("#set").click(function() {
					var x = $("#json").val();
					$.ajax({
						url : "http://localhost/OpenLaw/Server/DataAccess/setData.php?type=all&data=" + x,
						type : 'POST',
						contentType : 'application/json',
						data : {"data": x },
						dataType : 'json'
					});
				});
			});
		</script>
	</Head>
	<body>
		<button id="get">
			Get data
		</button>
		<button id="set"> 
            Set data
        </button>
		<textarea type="text" id="json"></textarea>
	</body>
</Html>
