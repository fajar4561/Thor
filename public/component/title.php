<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-end">
                <?php if ($_GET['halaman'] != 'beranda') { ?>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="?halaman=beranda">RSPM</a></li>
                        <?php 
                            $kata_kata = explode(" ", $title);
                            foreach ($kata_kata as $kata) :
                        ?>

                        <li class="breadcrumb-item"><a href="#"><?=ucwords($kata)?></a></li>
                        
                        <?php endforeach ?>
                    </ol>    
                <?php  } ?>
                

            </div>
            <h4 class="page-title">Halaman <?=ucwords($title)?></h4>
        </div>
        <!--end page-title-box-->
    </div>
    <!--end col-->
</div>