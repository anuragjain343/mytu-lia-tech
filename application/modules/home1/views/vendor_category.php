<!--vendor category-->
<section id="content" class="site-content sec-pad">
    <div class="container content-container">
    <div class="row mrgn-btm">
    <!--left portion-->
    <!--right-portion-->
    <div class="col-lg-offset-1 col-lg-10 col-md-10 col-sm-12">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <section>
                    <header class="vendor-cate-head">
                        <div class="row">
                            <!--search box-->
                            <div class="wrap">
                                <div class="search">
                                    <input type="hidden" name="cat_id" id="cat_id" value="<?php echo $cat_id; ?>">
                                    <input type="text" name="search_name" id="search_name" class="searchTerm vendor-search" placeholder="Search Vendor"  />
                                    <button type="submit" class="searchButton">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="woocommerce columns-3">
                        <ul class="product-loop-categories">
                            <!--first vendor-->
                            <div id="ajaxData"></div>
                        </ul><!--/product-loop-categories-->
                    </div><!--/woocommerce columns-3-->
                    <!--pagination-->
                </section>
            </main>
        <!--/pagination-->
        </div>
    </div>
</section>

<div class="modal fade" id="check_login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog frgt-pswd" role="document">
        <div class="modal-content">
            <div class="modal-header bg-img">
                <div class="frgt-head">
                  Login  
                </div><!--/frgt-head-->
            </div>
            <div class="modal-body modal-frgt-body">
                <div class="container">
                    <div class="dlte-cnfrmtn">
                        Please login first to chat with vendor.
                    </div>
                </div>
            </div><!--/modal-frgt-body-->
            <div class="container">
                <div class="modal-footer brdr-top" data-dismiss="modal">
                    <button id="next" type="button" class="btn btn-primary del_btn">Ok</button>
                </div>                                                                      
            </div>       
        </div>
    </div>
</div>
<script type="text/javascript">
 
    $('#search_name').keyup(function() {
        var $th = $(this);
        $th.val($th.val().replace(/(\s{2,})|[^a-zA-Z']/g, ' '));
        $th.val($th.val().replace(/^\s*/, ''));
    });


    var currentRequest;
    $('#search_name').keyup(function() {
        $("#ajaxData").html('');
        pagination(base_url +"home/users/vendor_cat_list/");
    });
        

    pagination(base_url +"home/users/vendor_cat_list/");
    function pagination(url){

        var search_name= $('#search_name').val().trim(),
            cat_id = $('#cat_id').val();
        $('#loader').hide();
    

        var currentRequest = $.ajax({
            url: url,
            type: "POST",
            data:{page: url,id:cat_id,search_name:search_name},              
            cache: false,   
            beforeSend: function() {
                if(currentRequest != null) {
                    currentRequest.abort();
                }
            },                          
            success: function(data){ 
            
                $("#ajaxData").html(data);
                $("#ven_cat").addClass("active");
            }
        });
    }
  
</script>