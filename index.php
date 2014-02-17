<?php
    session_start();
    include_once __DIR__ . '/Server/DataAccess/dataAccess.php';
    $dataAccess = new DataAccess;  
?>
<Html>
    <Head>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>
            var x = <?php echo($dataAccess->getData());?>;
            eval(x)
            $(document).ready(function(){
              $("button").click(function(){
                $.get("http://localhost/OpenLaw/Server/DataAccess/dataAccess.php?url=getData",function(data,status){
                  alert(data);
                });
              });
            });
        </script>
    </Head>
    <body>
        <button>Send an HTTP GET request to a page and get the result back</button>
    </body>
</Html>
