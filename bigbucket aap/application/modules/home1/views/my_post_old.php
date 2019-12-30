<?php
        $frontend_assets =  base_url().'frontend_asset/';
?>

<!--my post-->
<section id="my-post" class="sectn-pad2">
    <div class="container">
        <!--create button-->  
        <div class="col-lg-8 col-lg-offset-2 col-md-12 col-xs-12">

        </div> 
        <!--button for create-post-->
        <div id="ajaxData">
            
        </div>
    </div>
</section>

<script type="text/javascript">
    
    pagination(base_url + "home/posts/postList/");
    function pagination(url)
    {   
        $.ajax({
            url: url,
            type: "POST",
            data:{page: url},              
            cache: false,   
            beforeSend: function() {
               $("div#divLoading").addClass('show');
            },                          
            success: function(data){ 
                $("div#divLoading").removeClass('show');
                $("#ajaxData").html(data);
            }
        });

    }

    
    

</script>